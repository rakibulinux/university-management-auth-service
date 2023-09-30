import express from 'express';

import validateRequest from '../../middlewares/validateRequest';
import { AcademicDepartmentValidation } from './academicDepartment.validation';
import { AcademicDepartmentController } from './academicDepartment.controller';
import auth from '../../middlewares/auth';
import { ENUM_USER_ROLE } from '../../../enums/user';
const router = express.Router();

router.post(
  '/',
  // validateRequest(
  //   AcademicDepartmentValidation.createAcademicDepartmentZodSchema,
  // ),
  auth(ENUM_USER_ROLE.ADMIN, ENUM_USER_ROLE.SUPER_ADMIN),
  AcademicDepartmentController.createDepartment,
);

router.patch(
  '/:id',
  auth(ENUM_USER_ROLE.ADMIN, ENUM_USER_ROLE.SUPER_ADMIN),
  validateRequest(
    AcademicDepartmentValidation.updateAcademicDepartmentZodSchema,
  ),
  AcademicDepartmentController.updateDepartment,
);
router.get('/:id', AcademicDepartmentController.getSingleDepartment);
router.delete(
  '/:id',
  auth(ENUM_USER_ROLE.ADMIN, ENUM_USER_ROLE.SUPER_ADMIN),
  AcademicDepartmentController.deleteSingleDepartment,
);
router.get('/', AcademicDepartmentController.getAllDepartments);

export const AcademicDepartmentRoutes = router;
