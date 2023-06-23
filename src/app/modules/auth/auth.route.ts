import express from 'express';
import validateRequest from '../../middlewares/validateRequest';
import { AuthValidation } from './auth.validation';
import { AuthController } from './auth.controller';
const router = express.Router();

router.post(
  '/login',
  validateRequest(AuthValidation.createAuthZodSchema),
  AuthController.loginUser
);
// router.post(
//   '/create-faculty',
//   validateRequest(AuthValidation.createFacultyZodSchema),
//   AuthController.createFaculty
// );
// router.post(
//   '/create-admin',
//   validateRequest(AuthValidation.createAdminZodSchema),
//   AuthController.createAdmin
// );

export const AuthRoutes = router;
