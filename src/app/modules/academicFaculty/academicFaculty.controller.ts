import { Request, Response } from 'express';
import { AcademicFacultyService } from './academicFaculty.service';
import catchAsync from '../../../shared/catchAsync';
import sendResponse from '../../../shared/sendResponse';
import httpStatus from 'http-status';
import pick from '../../../shared/pick';
import { paginationField } from '../../constants/pagination';
import { IAcademicFaculty } from './academicFaculty.interface';
import { academicFacultyFilterableFields } from './academicFaculty.constant';

const createAcademicFaculty = catchAsync(
  async (req: Request, res: Response) => {
    const { ...academicFacultyData } = req.body;
    const result =
      await AcademicFacultyService.createAcademicFaculty(academicFacultyData);
    // next();
    sendResponse<IAcademicFaculty>(res, {
      statusCode: httpStatus.OK,
      success: true,
      message: 'Academic Faculty is Created Successfully',
      data: result,
    });
  },
);

const getAllAcademicFaculties = catchAsync(
  async (req: Request, res: Response) => {
    const filters = pick(req.query, academicFacultyFilterableFields);
    const paginationOptions = pick(req.query, paginationField);
    const result = await AcademicFacultyService.getAllAcademicFaculties(
      filters,
      paginationOptions,
    );
    // next();
    sendResponse<IAcademicFaculty[]>(res, {
      statusCode: httpStatus.OK,
      success: true,
      message: 'Academic Faculty retrived Successfully',
      meta: result.meta,
      data: result.data,
    });
  },
);

const getSingleAcademicFaculty = catchAsync(
  async (req: Request, res: Response) => {
    const id = req.params.id;
    const result = await AcademicFacultyService.getSingleAcademicFaculty(id);
    // next();
    sendResponse<IAcademicFaculty>(res, {
      statusCode: httpStatus.OK,
      success: true,
      message: 'Academic Faculty retrived Successfully',
      data: result,
    });
  },
);
const deleteSingleAcademicFaculty = catchAsync(
  async (req: Request, res: Response) => {
    const id = req.params.id;
    const result = await AcademicFacultyService.deleteSingleAcademicFaculty(id);
    // next();
    sendResponse<IAcademicFaculty>(res, {
      statusCode: httpStatus.OK,
      success: true,
      message: 'Academic Faculty deleted Successfully',
      data: result,
    });
  },
);
const updateAcademicFaculty = catchAsync(
  async (req: Request, res: Response) => {
    const id = req.params.id;
    const updatedData = req.body;
    const result = await AcademicFacultyService.updateAcademicFaculty(
      id,
      updatedData,
    );
    sendResponse<IAcademicFaculty>(res, {
      statusCode: httpStatus.OK,
      success: true,
      message: 'Academic Faculty Update Successfully',
      data: result,
    });
  },
);

export const AcademicFacultyController = {
  createAcademicFaculty,
  getAllAcademicFaculties,
  getSingleAcademicFaculty,
  updateAcademicFaculty,
  deleteSingleAcademicFaculty,
};
