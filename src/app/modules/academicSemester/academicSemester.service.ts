import { IAcademicSemester } from './academicSemester.interface';
import { AcademicSemester } from './academicSemester.model';

const createSemister = async (
  payload: IAcademicSemester
): Promise<IAcademicSemester | null> => {
  const result = await AcademicSemester.create(payload);
  return result;
};

export const AcademicSemesterService = {
  createSemister,
};
