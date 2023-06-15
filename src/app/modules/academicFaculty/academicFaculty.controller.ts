import { Request, Response } from 'express';
import { AcademicFacultyService } from './academicFaculty.service';
import catchAsync from '../../../shared/catchAsync';
import sendResponse from '../../../shared/sendResponse';
import httpStatus from 'http-status';
import pick from '../../../shared/pick';
import { paginationField } from '../../constants/pagination';
import { IAcademicFaculty } from './academicFaculty.interface';
import { academicFacultyFilterableFields } from './academicFaculty.constant';

const createFaculty = catchAsync(async (req: Request, res: Response) => {
  const { ...academicFacultyData } = req.body;
  const result = await AcademicFacultyService.createFaculty(
    academicFacultyData
  );
  // next();
  sendResponse<IAcademicFaculty>(res, {
    statusCode: httpStatus.OK,
    success: true,
    message: 'Academic Faculty is Created Successfully',
    data: result,
  });
});

const getAllSemisters = catchAsync(async (req: Request, res: Response) => {
  const filters = pick(req.query, academicFacultyFilterableFields);
  const paginationOptions = pick(req.query, paginationField);
  const result = await AcademicFacultyService.getAllFacultys(
    filters,
    paginationOptions
  );
  // next();
  sendResponse<IAcademicFaculty[]>(res, {
    statusCode: httpStatus.OK,
    success: true,
    message: 'Faculty retrived Successfully',
    meta: result.meta,
    data: result.data,
  });
});

const getSingleSemister = catchAsync(async (req: Request, res: Response) => {
  const id = req.params.id;
  const result = await AcademicFacultyService.getSingleFaculty(id);
  // next();
  sendResponse<IAcademicFaculty>(res, {
    statusCode: httpStatus.OK,
    success: true,
    message: 'Faculty retrived Successfully',
    data: result,
  });
});
const deleteSingleSemister = catchAsync(async (req: Request, res: Response) => {
  const id = req.params.id;
  const result = await AcademicFacultyService.deleteSingleFaculty(id);
  // next();
  sendResponse<IAcademicFaculty>(res, {
    statusCode: httpStatus.OK,
    success: true,
    message: 'Faculty deleted Successfully',
    data: result,
  });
});
const updateSemister = catchAsync(async (req: Request, res: Response) => {
  const id = req.params.id;
  const updatedData = req.body;
  const result = await AcademicFacultyService.updateFaculty(id, updatedData);
  sendResponse<IAcademicFaculty>(res, {
    statusCode: httpStatus.OK,
    success: true,
    message: 'Faculty Update Successfully',
    data: result,
  });
});

export const AcademicFacultyController = {
  createFaculty,
  getAllSemisters,
  getSingleSemister,
  updateSemister,
  deleteSingleSemister,
};
