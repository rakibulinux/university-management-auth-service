import express from 'express';

import validateRequest from '../../middlewares/validateRequest';
import { AcademicSemesterValidation } from './academicSemester.validation';
import { AcademicSemesterController } from './academicSemester.controller';
const router = express.Router();

router.post(
  '/create-semester',
  validateRequest(AcademicSemesterValidation.createAcademicSemesterZodSchema),
  AcademicSemesterController.createSemester
);

router.patch(
  '/:id',
  validateRequest(AcademicSemesterValidation.updateAcademicSemesterZodSchema),
  AcademicSemesterController.updateSemister
);
router.get('/:id', AcademicSemesterController.getSingleSemister);
router.delete('/:id', AcademicSemesterController.deleteSingleSemister);
router.get('/', AcademicSemesterController.getAllSemisters);

export const AcademicSemesterRoutes = router;
