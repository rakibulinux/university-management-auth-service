'use strict';
Object.defineProperty(exports, '__esModule', { value: true });
exports.UserValidation = void 0;
const zod_1 = require('zod');
const student_constent_1 = require('../student/student.constent');
const createStudentZodSchema = zod_1.z.object({
  body: zod_1.z.object({
    password: zod_1.z.string().optional(),
    student: zod_1.z.object({
      name: zod_1.z.object({
        firstName: zod_1.z.string({
          required_error: 'First name required',
        }),
        middleName: zod_1.z.string().optional(),
        lastName: zod_1.z.string({
          required_error: 'Last name required',
        }),
      }),
      gender: zod_1.z.enum([...student_constent_1.gender], {
        required_error: 'Gender is required',
      }),
      dateOfBirth: zod_1.z.string({
        required_error: 'Date Of is Birth required',
      }),
      email: zod_1.z.string({
        required_error: 'Email is required',
      }),
      contactNo: zod_1.z.string({
        required_error: 'Contact No is  required',
      }),
      emergencyContactNo: zod_1.z.string({
        required_error: 'Emergency Contact No is required',
      }),
      presentAddress: zod_1.z.string({
        required_error: 'Present Address is required',
      }),
      permanentAddress: zod_1.z.string({
        required_error: 'Permanent Address is required',
      }),
      bloodGroup: zod_1.z.enum([...student_constent_1.bloodGroup]).optional(),
      guardian: zod_1.z.object({
        fatherName: zod_1.z.string({
          required_error: 'Father Name required',
        }),
        fatherOccupation: zod_1.z.string({
          required_error: 'Father Occupation is required',
        }),
        fatherContactNo: zod_1.z.string({
          required_error: 'Father Contact No is  required',
        }),
        motherName: zod_1.z.string({
          required_error: 'Mother Name is required',
        }),
        motherOccupation: zod_1.z.string({
          required_error: 'Mother Occupation is required',
        }),
        motherContactNo: zod_1.z.string({
          required_error: 'Mother Contact No is required',
        }),
        address: zod_1.z.string({
          required_error: 'Address is required',
        }),
      }),
      localGuardian: zod_1.z.object({
        name: zod_1.z.string({
          required_error: 'Name is required',
        }),
        occupation: zod_1.z.string({
          required_error: 'Occupation is required',
        }),
        contactNo: zod_1.z.string({
          required_error: 'Contact No is required',
        }),
        address: zod_1.z.string({
          required_error: 'Address is required',
        }),
      }),
      academicSemester: zod_1.z.string({
        required_error: 'Academic Semester is required',
      }),
      academicDepartment: zod_1.z.string({
        required_error: 'Academic Department is required',
      }),
      academicFaculty: zod_1.z.string({
        required_error: 'Academic Faculty is required',
      }),
    }),
  }),
});
const createFacultyZodSchema = zod_1.z.object({
  body: zod_1.z.object({
    password: zod_1.z.string().optional(),
    faculty: zod_1.z.object({
      name: zod_1.z.object({
        firstName: zod_1.z.string({
          required_error: 'First name required',
        }),
        middleName: zod_1.z.string().optional(),
        lastName: zod_1.z.string({
          required_error: 'Last name required',
        }),
      }),
      gender: zod_1.z.enum([...student_constent_1.gender], {
        required_error: 'Gender is required',
      }),
      dateOfBirth: zod_1.z.string({
        required_error: 'Date Of is Birth required',
      }),
      email: zod_1.z.string({
        required_error: 'Email is required',
      }),
      contactNo: zod_1.z.string({
        required_error: 'Contact No is  required',
      }),
      emergencyContactNo: zod_1.z.string({
        required_error: 'Emergency Contact No is required',
      }),
      presentAddress: zod_1.z.string({
        required_error: 'Present Address is required',
      }),
      permanentAddress: zod_1.z.string({
        required_error: 'Permanent Address is required',
      }),
      designation: zod_1.z.string({
        required_error: 'Designation is required',
      }),
      academicDepartment: zod_1.z.string({
        required_error: 'Academic Department is required',
      }),
      academicFaculty: zod_1.z.string({
        required_error: 'Academic Faculty is required',
      }),
    }),
  }),
});
const createAdminZodSchema = zod_1.z.object({
  body: zod_1.z.object({
    password: zod_1.z.string().optional(),
    admin: zod_1.z.object({
      name: zod_1.z.object({
        firstName: zod_1.z.string({
          required_error: 'First name required',
        }),
        middleName: zod_1.z.string().optional(),
        lastName: zod_1.z.string({
          required_error: 'Last name required',
        }),
      }),
      gender: zod_1.z.enum([...student_constent_1.gender], {
        required_error: 'Gender is required',
      }),
      dateOfBirth: zod_1.z.string({
        required_error: 'Date Of is Birth required',
      }),
      email: zod_1.z.string({
        required_error: 'Email is required',
      }),
      contactNo: zod_1.z.string({
        required_error: 'Contact No is  required',
      }),
      emergencyContactNo: zod_1.z.string({
        required_error: 'Emergency Contact No is required',
      }),
      department: zod_1.z.string({
        required_error: 'Department is required',
      }),
      designation: zod_1.z.string({
        required_error: 'Designation is required',
      }),
    }),
  }),
});
exports.UserValidation = {
  createStudentZodSchema,
  createFacultyZodSchema,
  createAdminZodSchema,
};
