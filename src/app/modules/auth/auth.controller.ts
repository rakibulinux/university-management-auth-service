import { Request, Response } from 'express';
import { AuthService } from './auth.service';
import catchAsync from '../../../shared/catchAsync';
import sendResponse from '../../../shared/sendResponse';
import httpStatus from 'http-status';

const loginUser = catchAsync(async (req: Request, res: Response) => {
  const { ...loginData } = req.body;
  const result = await AuthService.loginUser(loginData);

  sendResponse(res, {
    statusCode: httpStatus.OK,
    success: true,
    message: 'User Login Successfully',
    data: result,
  });
});

export const AuthController = {
  loginUser,
};
