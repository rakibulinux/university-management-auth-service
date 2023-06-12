import express, { Application, NextFunction, Request, Response } from 'express';
import cors from 'cors';
import httpStatus from 'http-status';
import globalErrorHandler from './app/middlewares/globalErrorHandler';
import { UserRoutes } from './app/modules/user/user.route';
import { AcademicSemesterRoutes } from './app/modules/academicSemester/academicSemester.route';
// import ApiError from './errors/ApiError'

const app: Application = express();

app.use(cors());

app.use(express.json());
app.use(express.urlencoded({ extended: true }));

// Application route
app.use('/api/v1/users/', UserRoutes);
app.use('/api/v1/academic-semesters/', AcademicSemesterRoutes);

app.get('/', async (req: Request, res: Response) => {
  res.send('Server is Working');
  //   throw new Error('Testing error ')
  //   throw new ApiError(400, 'Orabapre')
  //   // next('Error got on Next')
});

//handle not found
app.use((req: Request, res: Response, next: NextFunction) => {
  res.status(httpStatus.NOT_FOUND).json({
    success: false,
    message: 'Not Found',
    errorMessages: [
      {
        path: req.originalUrl,
        message: 'API Not Found',
      },
    ],
  });
  next();
});

// Global Error handler
app.use(globalErrorHandler);

export default app;
