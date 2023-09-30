import { User } from './user.model';
import { IUser } from './user.interface';
import config from '../../../config';
import ApiError from '../../../errors/ApiError';
import {
  generatedAdminId,
  generatedFacultyId,
  generatedStudentId,
} from './user.utils';
import { IStudent } from '../student/student.interface';
import { AcademicSemester } from '../academicSemester/academicSemester.model';
import mongoose from 'mongoose';
import { Student } from '../student/student.model';
import httpStatus from 'http-status';
import { IFaculty } from '../faculty/faculty.interface';
import { Faculty } from '../faculty/faculty.model';
import { Admin } from '../admin/admin.model';
import { IAdmin } from '../admin/admin.interface';
import { RedisClient } from '../../../shared/redis';
import { EVENT_STUDENT_CREATED } from '../student/student.constent';
import { EVENT_FACULTY_CREATED } from '../faculty/faculty.constent';
const createStudent = async (
  student: IStudent,
  user: IUser,
): Promise<IUser | null> => {
  if (!user.password) {
    user.password = config.default_student_pass as string;
  }
  user.role = 'student';

  const academicSemester = await AcademicSemester.findById(
    student.academicSemester,
  );
  let newUserAllData = null;
  const session = await mongoose.startSession();
  try {
    session.startTransaction();

    const id = await generatedStudentId(academicSemester);

    user.id = id;
    student.id = id;

    const newStudent = await Student.create([student], { session });

    if (!newStudent.length) {
      throw new ApiError(httpStatus.BAD_REQUEST, 'Student create failed');
    }

    user.student = newStudent[0]._id;

    const newUser = await User.create([user], { session });

    if (!newUser.length) {
      throw new ApiError(httpStatus.BAD_REQUEST, 'User create failed');
    }
    newUserAllData = newUser[0];

    await session.commitTransaction();
    await session.endSession();
  } catch (error) {
    session.abortTransaction();
    session.endSession();
    throw error;
  }

  if (newUserAllData) {
    newUserAllData = await User.findOne({ id: newUserAllData.id }).populate({
      path: 'student',
      populate: [
        {
          path: 'academicSemester',
        },
        {
          path: 'academicFaculty',
        },
        {
          path: 'academicDepartment',
        },
      ],
    });
  }
  if (newUserAllData) {
    await RedisClient.publish(
      EVENT_STUDENT_CREATED,
      JSON.stringify(newUserAllData.student),
    );
  }
  return newUserAllData;
};
const createFaculty = async (
  faculty: IFaculty,
  user: IUser,
): Promise<IUser | null> => {
  if (!user.password) {
    user.password = config.default_faculty_pass as string;
  }
  user.role = 'faculty';

  let newUserAllData = null;
  const session = await mongoose.startSession();
  try {
    session.startTransaction();

    const id = await generatedFacultyId();
    user.id = id;
    faculty.id = id;

    const newFaculty = await Faculty.create([faculty], { session });

    if (!newFaculty.length) {
      throw new ApiError(httpStatus.BAD_REQUEST, 'Faculty create failed');
    }

    user.faculty = newFaculty[0]._id;

    const newUser = await User.create([user], { session });

    if (!newUser.length) {
      throw new ApiError(httpStatus.BAD_REQUEST, 'User create failed');
    }
    newUserAllData = newUser[0];

    await session.commitTransaction();
    await session.endSession();
  } catch (error) {
    session.abortTransaction();
    session.endSession();
    throw error;
  }

  if (newUserAllData) {
    newUserAllData = await User.findOne({ id: newUserAllData.id }).populate({
      path: 'faculty',
      populate: [
        {
          path: 'academicFaculty',
        },
        {
          path: 'academicDepartment',
        },
      ],
    });
  }
  if (newUserAllData) {
    await RedisClient.publish(
      EVENT_FACULTY_CREATED,
      JSON.stringify(newUserAllData.faculty),
    );
  }
  return newUserAllData;
};
const createAdmin = async (
  admin: IAdmin,
  user: IUser,
): Promise<IUser | null> => {
  if (!user.password) {
    user.password = config.default_admin_pass as string;
  }

  user.role = 'admin';

  let newUserAllData = null;
  const session = await mongoose.startSession();
  try {
    session.startTransaction();

    const id = await generatedAdminId();
    user.id = id;
    admin.id = id;

    const newAdmin = await Admin.create([admin], { session });

    if (!newAdmin.length) {
      throw new ApiError(httpStatus.BAD_REQUEST, 'Admin create failed');
    }

    user.admin = newAdmin[0]._id;

    const newUser = await User.create([user], { session });

    if (!newUser.length) {
      throw new ApiError(httpStatus.BAD_REQUEST, 'User create failed');
    }
    newUserAllData = newUser[0];

    await session.commitTransaction();
    await session.endSession();
  } catch (error) {
    session.abortTransaction();
    session.endSession();
    throw error;
  }

  if (newUserAllData) {
    newUserAllData = await User.findOne({ id: newUserAllData.id });
  }

  return newUserAllData;
};

export const UserService = {
  createStudent,
  createFaculty,
  createAdmin,
};
