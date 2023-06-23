import { z } from 'zod';

const createAuthZodSchema = z.object({
  body: z.object({
    id: z.string({
      required_error: 'ID Is Required',
    }),
    password: z.string({
      required_error: 'Password Is Required',
    }),
  }),
});

export const AuthValidation = {
  createAuthZodSchema,
};
