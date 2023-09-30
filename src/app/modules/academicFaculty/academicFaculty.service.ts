import {
  IAcademicFaculty,
  IAcademicFacultyEvent,
  IAcademicFacultyFilters,
} from './academicFaculty.interface';
import { IPaginationOptions } from '../../../interfaces/pagination';
import { IGenericResponse } from '../../../interfaces/common';
import calculatePagination from '../../helpers/paginationHelpers';
import { SortOrder } from 'mongoose';
import { AcademicFaculty } from './academicFaculty.model';
import { academicFacultySearchableFields } from './academicFaculty.constant';

const createAcademicFaculty = async (
  payload: IAcademicFaculty,
): Promise<IAcademicFaculty | null> => {
  const result = await AcademicFaculty.create(payload);
  return result;
};

const getAllAcademicFaculties = async (
  filters: IAcademicFacultyFilters,
  paginationOptions: IPaginationOptions,
): Promise<IGenericResponse<IAcademicFaculty[]>> => {
  const { searchTerm, ...filtersData } = filters;

  const andCondition = [];

  if (searchTerm) {
    andCondition.push({
      $or: academicFacultySearchableFields.map(field => ({
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

  const result = await AcademicFaculty.find(whereCondition)
    .sort(sortCondition)
    .skip(skip)
    .limit(limit);
  const total = await AcademicFaculty.countDocuments();

  return {
    meta: {
      page,
      limit,
      total,
    },
    data: result,
  };
};

const getSingleAcademicFaculty = async (
  id: string,
): Promise<IAcademicFaculty | null> => {
  const result = await AcademicFaculty.findById(id);
  return result;
};
const deleteSingleAcademicFaculty = async (
  id: string,
): Promise<IAcademicFaculty | null> => {
  const result = await AcademicFaculty.findByIdAndDelete(id);
  return result;
};
const updateAcademicFaculty = async (
  id: string,
  payload: Partial<IAcademicFaculty>,
): Promise<IAcademicFaculty | null> => {
  const result = await AcademicFaculty.findOneAndUpdate({ _id: id }, payload, {
    new: true,
  });
  return result;
};

const createFacultyFromEvent = async (
  event: IAcademicFacultyEvent,
): Promise<void> => {
  console.log(event);
  await AcademicFaculty.create({
    title: event.title,
    syncId: event.id,
  });
};
const updateFacultyFromEvent = async (
  event: IAcademicFacultyEvent,
): Promise<void> => {
  await AcademicFaculty.findOneAndUpdate(
    { syncId: event.id },
    {
      $set: {
        title: event.title,
        syncId: event.id,
      },
    },
  );
};
const deleteFacultyFromEvent = async (
  event: IAcademicFacultyEvent,
): Promise<void> => {
  await AcademicFaculty.findOneAndDelete({ syncId: event.id });
};

export const AcademicFacultyService = {
  createAcademicFaculty,
  getAllAcademicFaculties,
  getSingleAcademicFaculty,
  updateAcademicFaculty,
  deleteSingleAcademicFaculty,
  createFacultyFromEvent,
  updateFacultyFromEvent,
  deleteFacultyFromEvent,
};
