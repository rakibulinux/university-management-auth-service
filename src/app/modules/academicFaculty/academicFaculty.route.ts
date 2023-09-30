import express from 'express';

import validateRequest from '../../middlewares/validateRequest';
import { AcademicFacultyValidation } from './academicFaculty.validation';
import { AcademicFacultyController } from './academicFaculty.controller';
import auth from '../../middlewares/auth';
import { ENUM_USER_ROLE } from '../../../enums/user';
const router = express.Router();

router.post(
  '/',
  validateRequest(AcademicFacultyValidation.createAcademicFacultyZodSchema),
  auth(ENUM_USER_ROLE.SUPER_ADMIN, ENUM_USER_ROLE.ADMIN),
  AcademicFacultyController.createAcademicFaculty,
);

router.patch(
  '/:id',
  validateRequest(AcademicFacultyValidation.updateAcademicFacultyZodSchema),
  auth(
    ENUM_USER_ROLE.SUPER_ADMIN,
    ENUM_USER_ROLE.ADMIN,
    ENUM_USER_ROLE.FACULTY,
  ),
  AcademicFacultyController.updateAcademicFaculty,
);
router.get(
  '/:id',
  auth(
    ENUM_USER_ROLE.SUPER_ADMIN,
    ENUM_USER_ROLE.ADMIN,
    ENUM_USER_ROLE.FACULTY,
    ENUM_USER_ROLE.STUDENT,
  ),
  AcademicFacultyController.getSingleAcademicFaculty,
);
router.delete(
  '/:id',
  auth(ENUM_USER_ROLE.SUPER_ADMIN, ENUM_USER_ROLE.ADMIN),
  AcademicFacultyController.deleteSingleAcademicFaculty,
);
router.get(
  '/',
  auth(
    ENUM_USER_ROLE.SUPER_ADMIN,
    ENUM_USER_ROLE.ADMIN,
    ENUM_USER_ROLE.FACULTY,
    ENUM_USER_ROLE.STUDENT,
  ),
  AcademicFacultyController.getAllAcademicFaculties,
);

export const AcademicFacultyRoutes = router;
