import { z } from 'zod';
import { bloodGroup, gender } from '../student/student.constent';

const createStudentZodSchema = z.object({
  body: z.object({
    password: z.string().optional(),
    student: z.object({
      name: z.object({
        firstName: z.string({
          required_error: 'First name required',
        }),
        middleName: z.string().optional(),
        lastName: z.string({
          required_error: 'Last name required',
        }),
      }),
      gender: z.enum([...gender] as [string, ...string[]], {
        required_error: 'Gender is required',
      }),
      dateOfBirth: z.string({
        required_error: 'Date Of is Birth required',
      }),
      email: z.string({
        required_error: 'Email is required',
      }),
      contactNo: z.string({
        required_error: 'Contact No is  required',
      }),
      emergencyContactNo: z.string({
        required_error: 'Emergency Contact No is required',
      }),
      presentAddress: z.string({
        required_error: 'Present Address is required',
      }),
      permanentAddress: z.string({
        required_error: 'Permanent Address is required',
      }),
      bloodGroup: z.enum([...bloodGroup] as [string, ...string[]]).optional(),
      guardian: z.object({
        fatherName: z.string({
          required_error: 'Father Name required',
        }),
        fatherOccupation: z.string({
          required_error: 'Father Occupation is required',
        }),
        fatherContactNo: z.string({
          required_error: 'Father Contact No is  required',
        }),
        motherName: z.string({
          required_error: 'Mother Name is required',
        }),
        motherOccupation: z.string({
          required_error: 'Mother Occupation is required',
        }),
        motherContactNo: z.string({
          required_error: 'Mother Contact No is required',
        }),
        address: z.string({
          required_error: 'Address is required',
        }),
      }),
      localGuardian: z.object({
        name: z.string({
          required_error: 'Name is required',
        }),
        occupation: z.string({
          required_error: 'Occupation is required',
        }),
        contactNo: z.string({
          required_error: 'Contact No is required',
        }),
        address: z.string({
          required_error: 'Address is required',
        }),
      }),
      academicSemester: z.string({
        required_error: 'Academic Semester is required',
      }),
      academicDepartment: z.string({
        required_error: 'Academic Department is required',
      }),
      academicFaculty: z.string({
        required_error: 'Academic Faculty is required',
      }),
    }),
  }),
});
const createFacultyZodSchema = z.object({
  body: z.object({
    password: z.string().optional(),
    faculty: z.object({
      name: z.object({
        firstName: z.string({
          required_error: 'First name required',
        }),
        middleName: z.string().optional(),
        lastName: z.string({
          required_error: 'Last name required',
        }),
      }),
      gender: z.enum([...gender] as [string, ...string[]], {
        required_error: 'Gender is required',
      }),
      dateOfBirth: z.string({
        required_error: 'Date Of is Birth required',
      }),
      email: z.string({
        required_error: 'Email is required',
      }),
      contactNo: z.string({
        required_error: 'Contact No is  required',
      }),
      emergencyContactNo: z.string({
        required_error: 'Emergency Contact No is required',
      }),
      presentAddress: z.string({
        required_error: 'Present Address is required',
      }),
      permanentAddress: z.string({
        required_error: 'Permanent Address is required',
      }),
      designation: z.string({
        required_error: 'Designation is required',
      }),
      academicDepartment: z.string({
        required_error: 'Academic Department is required',
      }),
      academicFaculty: z.string({
        required_error: 'Academic Faculty is required',
      }),
    }),
  }),
});
const createAdminZodSchema = z.object({
  body: z.object({
    password: z.string().optional(),
    admin: z.object({
      name: z.object({
        firstName: z.string({
          required_error: 'First name required',
        }),
        middleName: z.string().optional(),
        lastName: z.string({
          required_error: 'Last name required',
        }),
      }),
      gender: z.enum([...gender] as [string, ...string[]], {
        required_error: 'Gender is required',
      }),
      dateOfBirth: z.string({
        required_error: 'Date Of is Birth required',
      }),
      email: z.string({
        required_error: 'Email is required',
      }),
      contactNo: z.string({
        required_error: 'Contact No is  required',
      }),
      emergencyContactNo: z.string({
        required_error: 'Emergency Contact No is required',
      }),
      department: z.string({
        required_error: 'Department is required',
      }),
      designation: z.string({
        required_error: 'Designation is required',
      }),
    }),
  }),
});

export const UserValidation = {
  createStudentZodSchema,
  createFacultyZodSchema,
  createAdminZodSchema,
};
