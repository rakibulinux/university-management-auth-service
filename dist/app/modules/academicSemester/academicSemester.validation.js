'use strict';
Object.defineProperty(exports, '__esModule', { value: true });
exports.AcademicSemesterValidation = void 0;
const zod_1 = require('zod');
const academicSemester_constant_1 = require('./academicSemester.constant');
const createAcademicSemesterZodSchema = zod_1.z.object({
  body: zod_1.z.object({
    title: zod_1.z.enum(
      [...academicSemester_constant_1.academicSemesterTitle],
      {
        required_error: 'Title is required',
      },
    ),
    year: zod_1.z.string({
      required_error: 'Year is required',
    }),
    code: zod_1.z.enum([...academicSemester_constant_1.academicSemesterCode], {
      required_error: 'Code is required',
    }),
    startMonth: zod_1.z.enum(
      [...academicSemester_constant_1.academicSemesterMonth],
      {
        required_error: 'Start Month is required',
      },
    ),
    endMonth: zod_1.z.enum(
      [...academicSemester_constant_1.academicSemesterMonth],
      {
        required_error: 'Start Month is required',
      },
    ),
  }),
});
const updateAcademicSemesterZodSchema = zod_1.z
  .object({
    body: zod_1.z.object({
      title: zod_1.z
        .enum([...academicSemester_constant_1.academicSemesterTitle])
        .optional(),
      year: zod_1.z.string().optional(),
      code: zod_1.z
        .enum([...academicSemester_constant_1.academicSemesterCode])
        .optional(),
      startMonth: zod_1.z
        .enum([...academicSemester_constant_1.academicSemesterMonth])
        .optional(),
      endMonth: zod_1.z
        .enum([...academicSemester_constant_1.academicSemesterMonth])
        .optional(),
    }),
  })
  .refine(
    data =>
      (data.body.title && data.body.code) ||
      (!data.body.title && !data.body.code),
    {
      message: 'Either provide title and code both neither update others',
    },
  );
exports.AcademicSemesterValidation = {
  createAcademicSemesterZodSchema,
  updateAcademicSemesterZodSchema,
};
