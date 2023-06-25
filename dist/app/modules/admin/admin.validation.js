'use strict';
Object.defineProperty(exports, '__esModule', { value: true });
exports.AdminValidation = void 0;
const zod_1 = require('zod');
const admin_constent_1 = require('./admin.constent');
const updateAdminZodSchema = zod_1.z.object({
  body: zod_1.z.object({
    name: zod_1.z.object({
      firstName: zod_1.z.string().optional(),
      middleName: zod_1.z.string().optional(),
      lastName: zod_1.z.string().optional(),
    }),
    gender: zod_1.z.enum([...admin_constent_1.gender]).optional(),
    dateOfBirth: zod_1.z.string().optional(),
    email: zod_1.z.string().optional(),
    contactNo: zod_1.z.string().optional(),
    emergencyContactNo: zod_1.z.string().optional(),
    department: zod_1.z.string().optional(),
    designation: zod_1.z.string().optional(),
  }),
});
exports.AdminValidation = {
  updateAdminZodSchema,
};
