import httpStatus from 'http-status';
import ApiError from '../../../errors/ApiError';
import {
  academicSemesterSearchableFields,
  academicSemesterTitleCodeMapper,
} from './academicSemester.constant';
import {
  IAcademicSemester,
  IAcademicSemesterEvent,
  IAcademicSemesterFilters,
} from './academicSemester.interface';
import { AcademicSemester } from './academicSemester.model';
import { IPaginationOptions } from '../../../interfaces/pagination';
import { IGenericResponse } from '../../../interfaces/common';
import calculatePagination from '../../helpers/paginationHelpers';
import { SortOrder } from 'mongoose';

const createSemister = async (
  payload: IAcademicSemester,
): Promise<IAcademicSemester | null> => {
  if (academicSemesterTitleCodeMapper[payload.title] !== payload.code) {
    throw new ApiError(httpStatus.BAD_REQUEST, 'Invalid Semister Code');
  }
  const result = await AcademicSemester.create(payload);
  return result;
};

const getAllSemisters = async (
  filters: IAcademicSemesterFilters,
  paginationOptions: IPaginationOptions,
): Promise<IGenericResponse<IAcademicSemester[]>> => {
  const { searchTerm, ...filtersData } = filters;

  const andCondition = [];

  if (searchTerm) {
    andCondition.push({
      $or: academicSemesterSearchableFields.map(field => ({
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

  const { page, limit, skip, sortBy, sortOrder } =
    calculatePagination(paginationOptions);

  const sortCondition: { [key: string]: SortOrder } = {};
  if (sortBy && sortOrder) {
    sortCondition[sortBy] = sortOrder;
  }

  const whereCondition = andCondition.length > 0 ? { $and: andCondition } : {};

  const result = await AcademicSemester.find(whereCondition)
    .sort(sortCondition)
    .skip(skip)
    .limit(limit);
  const total = await AcademicSemester.countDocuments();

  return {
    meta: {
      page,
      limit,
      total,
    },
    data: result,
  };
};

const getSingleSemister = async (
  id: string,
): Promise<IAcademicSemester | null> => {
  const result = await AcademicSemester.findById(id);
  return result;
};
const deleteSingleSemister = async (
  id: string,
): Promise<IAcademicSemester | null> => {
  const result = await AcademicSemester.findByIdAndDelete(id);
  return result;
};
const updateSemister = async (
  id: string,
  payload: Partial<IAcademicSemester>,
): Promise<IAcademicSemester | null> => {
  if (
    payload.title &&
    payload.code &&
    academicSemesterTitleCodeMapper[payload.title] !== payload.code
  ) {
    throw new ApiError(httpStatus.BAD_REQUEST, 'Invalid Semister Code');
  }
  const result = await AcademicSemester.findOneAndUpdate({ _id: id }, payload, {
    new: true,
  });
  return result;
};

const createSemisterFromEvent = async (
  event: IAcademicSemesterEvent,
): Promise<void> => {
  await AcademicSemester.create({
    title: event.title,
    year: event.year,
    code: event.code,
    startMonth: event.startMonth,
    endMonth: event.endMonth,
    syncId: event.id,
  });
};
const updateSemisterFromEvent = async (
  event: IAcademicSemesterEvent,
): Promise<void> => {
  await AcademicSemester.findOneAndUpdate(
    { syncId: event.id },
    {
      $set: {
        title: event.title,
        year: event.year,
        code: event.code,
        startMonth: event.startMonth,
        endMonth: event.endMonth,
        syncId: event.id,
      },
    },
  );
};
const deleteSemisterFromEvent = async (
  event: IAcademicSemesterEvent,
): Promise<void> => {
  await AcademicSemester.findOneAndDelete({ syncId: event.id });
};

export const AcademicSemesterService = {
  createSemister,
  getAllSemisters,
  getSingleSemister,
  updateSemister,
  deleteSingleSemister,
  createSemisterFromEvent,
  updateSemisterFromEvent,
  deleteSemisterFromEvent,
};
