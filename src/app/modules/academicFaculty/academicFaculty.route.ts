import express from 'express';

import validateRequest from '../../middlewares/validateRequest';
import { AcademicFacultyValidation } from './academicFaculty.validation';
import { AcademicFacultyController } from './academicFaculty.controller';
const router = express.Router();

router.post(
  '/create-faculty',
  validateRequest(AcademicFacultyValidation.createAcademicFacultyZodSchema),
  AcademicFacultyController.createFaculty
);

router.patch(
  '/:id',
  validateRequest(AcademicFacultyValidation.updateAcademicFacultyZodSchema),
  AcademicFacultyController.updateSemister
);
router.get('/:id', AcademicFacultyController.getSingleSemister);
router.delete('/:id', AcademicFacultyController.deleteSingleSemister);
router.get('/', AcademicFacultyController.getAllSemisters);

export const AcademicFacultyRoutes = router;
