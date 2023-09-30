import { z } from 'zod';

const createAcademicDepartmentZodSchema = z.object({
  body: z.object({
    title: z.string({
      required_error: 'Department Title Required',
    }),
    academicFaculty: z.string().optional(),
  }),
});
const updateAcademicDepartmentZodSchema = z.object({
  body: z.object({
    title: z.string().optional(),
    academicFaculty: z.string().optional(),
  }),
});

export const AcademicDepartmentValidation = {
  createAcademicDepartmentZodSchema,
  updateAcademicDepartmentZodSchema,
};
