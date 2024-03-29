import httpStatus from 'http-status';
import ApiError from '../../../errors/ApiError';
import {
  IChangePassword,
  ILoginUser,
  ILoginUserResponse,
  IRefreshTokenResponse,
} from './auth.interface';
import { User } from '../user/user.model';
import { JwtPayload, Secret } from 'jsonwebtoken';
import config from '../../../config';
import { jwtHelpers } from '../../helpers/jwtHelpers';

const loginUser = async (payload: ILoginUser): Promise<ILoginUserResponse> => {
  const { id, password } = payload;

  // const user = new User();
  const isUserExsist = await User.isUserExsist(id);

  if (!isUserExsist) {
    throw new ApiError(httpStatus.NOT_FOUND, 'User does not exsist');
  }

  if (
    isUserExsist.password &&
    !(await User.isPasswordMatched(password, isUserExsist?.password))
  ) {
    throw new ApiError(httpStatus.UNAUTHORIZED, 'Password is incorrect');
  }

  const { id: userId, role, needsPasswordChanged } = isUserExsist;

  //Token
  const accessToken = jwtHelpers.createToken(
    { userId, role },
    config.jwt.secret as Secret,
    config.jwt.expires_in as string,
  );
  const refreshToken = jwtHelpers.createToken(
    { userId, role },
    config.jwt.refresh_secret as Secret,
    config.jwt.refresh_expires_in as string,
  );

  // const accessToken = jwt.sign(
  //   {
  //     id: isUserExsist?.id,
  //     role: isUserExsist?.role,
  //   },
  //   config.jwt.secret as Secret,
  //   {
  //     expiresIn: config.jwt.expires_in,
  //   }
  // );
  // const refreshToken = jwt.sign(
  //   {
  //     id: isUserExsist?.id,
  //     role: isUserExsist?.role,
  //   },
  //   config.jwt.refresh_secret as Secret,
  //   {
  //     expiresIn: config.jwt.refresh_expires_in,
  //   }
  // );

  return { accessToken, refreshToken, needsPasswordChanged };
};

const refreshToken = async (token: string): Promise<IRefreshTokenResponse> => {
  let verifiedToken = null;

  // invalid token
  try {
    verifiedToken = jwtHelpers.verifyToken(
      token,
      config.jwt.refresh_secret as Secret,
    );
    // verifiedToken = jwt.verify(token, config.jwt.refresh_secret as Secret);
  } catch (err) {
    throw new ApiError(httpStatus.FORBIDDEN, 'Invalid Refresh Token');
  }
  const { userId } = verifiedToken;
  const isUserExsist = await User.isUserExsist(userId);

  //Generate new token
  if (!isUserExsist) {
    throw new ApiError(httpStatus.NOT_FOUND, 'User does not exsist');
  }

  const newAccessToken = jwtHelpers.createToken(
    {
      id: isUserExsist.id,
      role: isUserExsist.role,
    },
    config.jwt.secret as Secret,
    config.jwt.expires_in as string,
  );
  return {
    accessToken: newAccessToken,
  };
};
const changePassword = async (
  user: JwtPayload | null,
  payload: IChangePassword,
): Promise<void> =>
  // : Promise<ILoginUserResponse>
  {
    const { oldPassword, newPassword } = payload;

    // 1st way
    // const isUserExsist = await User.isUserExsist(user?.userId);

    // Good way
    const isUserExsist = await User.findOne({ id: user?.userId }).select(
      '+password',
    );

    if (!isUserExsist) {
      throw new ApiError(httpStatus.NOT_FOUND, 'User Not Found');
    }

    // Checking old password
    if (
      isUserExsist.password &&
      !(await User.isPasswordMatched(oldPassword, isUserExsist.password))
    ) {
      throw new ApiError(httpStatus.UNAUTHORIZED, 'Old Password is incorrect');
    }

    // Hash passowrd
    // const newHashPassword = await bcrypt.hash(
    //   newPassword,
    //   Number(config.bcrypt_salt_rounds)
    // );
    // const query = { id: user?.userId };
    // const updatedData = {
    //   password: newHashPassword,
    //   needsPasswordChanged: false,
    //   passwordChangedAt: new Date(),
    // };
    // await User.findOneAndUpdate(query, updatedData);
    isUserExsist.needsPasswordChanged = false;
    isUserExsist.password = newPassword;
    isUserExsist.save();
  };

export const AuthService = {
  loginUser,
  refreshToken,
  changePassword,
};
