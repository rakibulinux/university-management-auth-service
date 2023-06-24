import httpStatus from 'http-status';
import ApiError from '../../../errors/ApiError';
import { ILoginUser } from './auth.interface';
import { User } from './auth.model';
import bcrypt from 'bcrypt';
const loginUser = async (payload: ILoginUser) => {
  const { id, password } = payload;
  const isUserExsist = await User.findOne(
    { id },
    { id: 1, password: 1, needsPasswordChanged: 1 }
  );
  if (!isUserExsist) {
    throw new ApiError(httpStatus.NOT_FOUND, 'User does not exsist');
  }
  const isPasswordMatched = await bcrypt.compare(
    password,
    isUserExsist?.password
  );

  if (!isPasswordMatched) {
    throw new ApiError(httpStatus.UNAUTHORIZED, 'Password is incorrect');
  }
  return {};
};

export const AuthService = {
  loginUser,
};
