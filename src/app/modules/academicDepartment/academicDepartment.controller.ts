import { Request, Response } from 'express';
import { AcademicDepartmentService } from './academicDepartment.service';
import catchAsync from '../../../shared/catchAsync';
import sendResponse from '../../../shared/sendResponse';
import httpStatus from 'http-status';
import pick from '../../../shared/pick';
import { paginationField } from '../../constants/pagination';
import { IAcademicDepartment } from './academicDepartment.interface';
import { academicDepartmentFilterableFields } from './academicDepartment.constant';

const createDepartment = catchAsync(async (req: Request, res: Response) => {
  const { ...academicDepartmentData } = req.body;
  const result = await AcademicDepartmentService.createDepartment(
    academicDepartmentData,
  );
  // next();
  sendResponse<IAcademicDepartment>(res, {
    statusCode: httpStatus.OK,
    success: true,
    message: 'Academic Department is Created Successfully',
    data: result,
  });
});

const getAllDepartments = catchAsync(async (req: Request, res: Response) => {
  const filters = pick(req.query, academicDepartmentFilterableFields);
  const paginationOptions = pick(req.query, paginationField);
  const result = await AcademicDepartmentService.getAllDepartments(
    filters,
    paginationOptions,
  );
  // next();
  sendResponse<IAcademicDepartment[]>(res, {
    statusCode: httpStatus.OK,
    success: true,
    message: 'Department retrived Successfully',
    meta: result.meta,
    data: result.data,
  });
});

const getSingleDepartment = catchAsync(async (req: Request, res: Response) => {
  const id = req.params.id;
  const result = await AcademicDepartmentService.getSingleDepartment(id);
  // next();
  sendResponse<IAcademicDepartment>(res, {
    statusCode: httpStatus.OK,
    success: true,
    message: 'Department retrived Successfully',
    data: result,
  });
});
const deleteSingleDepartment = catchAsync(
  async (req: Request, res: Response) => {
    const id = req.params.id;
    const result = await AcademicDepartmentService.deleteSingleDepartment(id);
    // next();
    sendResponse<IAcademicDepartment>(res, {
      statusCode: httpStatus.OK,
      success: true,
      message: 'Department deleted Successfully',
      data: result,
    });
  },
);
const updateDepartment = catchAsync(async (req: Request, res: Response) => {
  const id = req.params.id;
  const updatedData = req.body;
  const result = await AcademicDepartmentService.updateDepartment(
    id,
    updatedData,
  );
  sendResponse<IAcademicDepartment>(res, {
    statusCode: httpStatus.OK,
    success: true,
    message: 'Department Update Successfully',
    data: result,
  });
});

export const AcademicDepartmentController = {
  createDepartment,
  getAllDepartments,
  getSingleDepartment,
  updateDepartment,
  deleteSingleDepartment,
};
