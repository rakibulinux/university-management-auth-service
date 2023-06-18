import { z } from 'zod';
import { gender } from './admin.constent';

const updateAdminZodSchema = z.object({
  body: z.object({
    name: z.object({
      firstName: z.string().optional(),
      middleName: z.string().optional(),
      lastName: z.string().optional(),
    }),
    gender: z.enum([...gender] as [string, ...string[]]).optional(),
    dateOfBirth: z.string().optional(),
    email: z.string().optional(),
    contactNo: z.string().optional(),
    emergencyContactNo: z.string().optional(),
    department: z.string().optional(),
    designation: z.string().optional(),
  }),
});

export const AdminValidation = {
  updateAdminZodSchema,
};
