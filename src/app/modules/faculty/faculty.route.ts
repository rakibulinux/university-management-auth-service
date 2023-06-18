import express from 'express';
// import validateRequest from '../../middlewares/validateRequest';
import { FacultyController } from './faculty.controller';
import validateRequest from '../../middlewares/validateRequest';
import { FacultyValidation } from './student.validation';

const router = express.Router();

router.get('/:id', FacultyController.getSingleFaculty);
router.get('/', FacultyController.getAllFaculties);
router.delete('/:id', FacultyController.deleteSingleFaculty);

router.patch(
  '/:id',
  validateRequest(FacultyValidation.updateFacultyZodSchema),
  FacultyController.updateFaculty
);

export const FacultyRoutes = router;
