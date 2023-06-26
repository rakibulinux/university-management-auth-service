import { z } from 'zod';

const loginZodSchema = z.object({
  body: z.object({
    id: z.string({
      required_error: 'ID Is Required',
    }),
    password: z.string({
      required_error: 'Password Is Required',
    }),
  }),
});
const refreshTokenZodSchema = z.object({
  cookies: z.object({
    refreshToken: z.string({
      required_error: 'ID Is Required',
    }),
  }),
});
const changePasswordZodSchema = z.object({
  cookies: z.object({
    oldPassword: z.string({
      required_error: 'Old Password Is Required',
    }),
    newPassword: z.string({
      required_error: 'New Password Is Required',
    }),
  }),
});

export const AuthValidation = {
  loginZodSchema,
  refreshTokenZodSchema,
  changePasswordZodSchema,
};
