import { academicDepartmentSearchableFields } from './academicDepartment.constant';
import {
  IAcademicDepartment,
  IAcademicDepartmentEvent,
  IAcademicDepartmentFilters,
} from './academicDepartment.interface';
import { AcademicDepartment } from './academicDepartment.model';
import { IPaginationOptions } from '../../../interfaces/pagination';
import { IGenericResponse } from '../../../interfaces/common';
import calculatePagination from '../../helpers/paginationHelpers';
import { SortOrder } from 'mongoose';
import { AcademicFaculty } from '../academicFaculty/academicFaculty.model';

const createDepartment = async (
  payload: IAcademicDepartment,
): Promise<IAcademicDepartment | null> => {
  const result = (await AcademicDepartment.create(payload)).populate(
    'academicFaculty',
  );
  return result;
};

const getAllDepartments = async (
  filters: IAcademicDepartmentFilters,
  paginationOptions: IPaginationOptions,
): Promise<IGenericResponse<IAcademicDepartment[]>> => {
  const { searchTerm, ...filtersData } = filters;

  const andCondition = [];

  if (searchTerm) {
    andCondition.push({
      $or: academicDepartmentSearchableFields.map(field => ({
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

  const result = await AcademicDepartment.find(whereCondition)
    .populate('academicFaculty')
    .sort(sortCondition)
    .skip(skip)
    .limit(limit);
  const total = await AcademicDepartment.countDocuments();

  return {
    meta: {
      page,
      limit,
      total,
    },
    data: result,
  };
};

const getSingleDepartment = async (
  id: string,
): Promise<IAcademicDepartment | null> => {
  const result = await AcademicDepartment.findById(id);
  return result;
};
const deleteSingleDepartment = async (
  id: string,
): Promise<IAcademicDepartment | null> => {
  const result = await AcademicDepartment.findByIdAndDelete(id);
  return result;
};
const updateDepartment = async (
  id: string,
  payload: Partial<IAcademicDepartment>,
): Promise<IAcademicDepartment | null> => {
  const result = await AcademicDepartment.findOneAndUpdate(
    { _id: id },
    payload,
    {
      new: true,
    },
  ).populate('academicFaculty');
  return result;
};

const createDepartmentFromEvent = async (
  event: IAcademicDepartmentEvent,
): Promise<void> => {
  const academicFaculty = await AcademicFaculty.findOne({
    syncId: event.academicFacultyId,
  });
  const payload = {
    title: event.title,
    academicFaculty: academicFaculty?._id,
    syncId: event.id,
  };

  await AcademicDepartment.create(payload);
};
const updateDepartmentFromEvent = async (
  event: IAcademicDepartmentEvent,
): Promise<void> => {
  const academicFaculty = await AcademicFaculty.findOne({
    syncId: event.academicFacultyId,
  });
  await AcademicDepartment.findOneAndUpdate(
    { syncId: event.id },
    {
      $set: {
        title: event.title,
        academicFaculty: academicFaculty?._id,
        syncId: event.id,
      },
    },
  );
};
const deleteDepartmentFromEvent = async (
  event: IAcademicDepartmentEvent,
): Promise<void> => {
  await AcademicDepartment.findOneAndDelete({ syncId: event.id });
};

export const AcademicDepartmentService = {
  createDepartment,
  getAllDepartments,
  getSingleDepartment,
  updateDepartment,
  deleteSingleDepartment,
  createDepartmentFromEvent,
  updateDepartmentFromEvent,
  deleteDepartmentFromEvent,
};
