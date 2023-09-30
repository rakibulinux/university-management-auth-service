/* eslint-disable @typescript-eslint/no-explicit-any */
import mongoose, { SortOrder } from 'mongoose';
import { IGenericResponse } from '../../../interfaces/common';
import { IPaginationOptions } from '../../../interfaces/pagination';
import calculatePagination from '../../helpers/paginationHelpers';
import { IFaculty, IFacultyFilters } from './faculty.interface';
import {
  EVENT_FACULTY_UPDATED,
  facultySearchableFields,
} from './faculty.constent';
import { Faculty } from './faculty.model';
import httpStatus from 'http-status';
import ApiError from '../../../errors/ApiError';
import { User } from '../user/user.model';
import { RedisClient } from '../../../shared/redis';

const getAllFaculties = async (
  filters: IFacultyFilters,
  paginationOptions: IPaginationOptions,
): Promise<IGenericResponse<IFaculty[]>> => {
  const { searchTerm, ...filtersData } = filters;

  const andCondition = [];

  if (searchTerm) {
    andCondition.push({
      $or: facultySearchableFields.map(field => ({
        [field]: {
          $regex: searchTerm,
          $options: 'i',
        },
      })),
    });
  }

  if (Object.keys(filtersData).length) {
    andCondition.push({
      $and: Object.entries(filtersData).map(([field, value]) => ({
        [field]: value,
      })),
    });
  }

  const { page, limit, skip, soryBy, sortOrder } =
    calculatePagination(paginationOptions);

  const sortCondition: { [key: string]: SortOrder } = {};
  if (soryBy && sortOrder) {
    sortCondition[soryBy] = sortOrder;
  }

  const whereCondition = andCondition.length > 0 ? { $and: andCondition } : {};

  const result = await Faculty.find(whereCondition)
    .populate('academicDepartment')
    .populate('academicFaculty')
    .sort(sortCondition)
    .skip(skip)
    .limit(limit);
  const total = await Faculty.countDocuments();

  return {
    meta: {
      page,
      limit,
      total,
    },
    data: result,
  };
};

const getSingleFaculty = async (id: string): Promise<IFaculty | null> => {
  const result = await Faculty.findOne({ id })
    .populate('academicDepartment')
    .populate('academicFaculty');
  if (!result) {
    throw new ApiError(
      httpStatus.NOT_FOUND,
      'Faculty ID is wrong or No Faculty Found',
    );
  }
  return result;
};

const deleteSingleFaculty = async (id: string): Promise<IFaculty | null> => {
  // check if the faculty is exist
  const isExist = await Faculty.findOne({ id });

  if (!isExist) {
    throw new ApiError(httpStatus.NOT_FOUND, 'Faculty not found !');
  }

  const session = await mongoose.startSession();

  try {
    session.startTransaction();
    //delete student first
    const student = await Faculty.findOneAndDelete({ id }, { session });
    if (!student) {
      throw new ApiError(404, 'Failed to delete faculty');
    }
    //delete user
    await User.deleteOne({ id });
    session.commitTransaction();
    session.endSession();

    return student;
  } catch (error) {
    session.abortTransaction();
    throw error;
  }
};

const updateFaculty = async (
  id: string,
  payload: Partial<IFaculty>,
): Promise<IFaculty | null> => {
  const isExsist = await Faculty.findOne({ id });

  if (!isExsist) {
    throw new ApiError(httpStatus.NOT_FOUND, 'Faculty Not found');
  }
  const { name, ...facultyData } = payload;
  const updateFacultyData: Partial<IFaculty> = { ...facultyData };

  if (name && Object.keys(name).length > 0) {
    Object.keys(name).forEach(key => {
      const nameKey = `name.${key}`;
      (updateFacultyData as any)[nameKey] = name[key as keyof typeof name];
    });
  }

  const result = await Faculty.findOneAndUpdate({ id }, updateFacultyData, {
    new: true,
  })
    .populate('academicFaculty')
    .populate('academicDepartment');
  if (result) {
    await RedisClient.publish(EVENT_FACULTY_UPDATED, JSON.stringify(result));
  }
  return result;
};
export const FacultyService = {
  getAllFaculties,
  getSingleFaculty,
  updateFaculty,
  deleteSingleFaculty,
};
