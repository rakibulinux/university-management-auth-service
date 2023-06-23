import { IAcademicSemester } from '../academicSemester/academicSemester.interface';
import { User } from './user.model';

// Student
export const findLastStudentId = async () => {
  const lastStudentId = await User.findOne(
    { role: 'student' },
    { id: 1, _id: 0 }
  )
    .sort({
      createdAt: -1,
    })
    .lean();
  return lastStudentId?.id ? lastStudentId.id.substring(4) : undefined;
};

export const generatedStudentId = async (
  academicSemester: IAcademicSemester | null
) => {
  const currentId =
    (await findLastStudentId()) || (0).toString().padStart(5, '0');

  let incrementdId = (parseInt(currentId) + 1).toString().padStart(5, '0');
  incrementdId = `${academicSemester?.year.substring(2)}${
    academicSemester?.code
  }${incrementdId}`;
  return incrementdId;
};

// Faculty
export const findLastFacultyId = async () => {
  const lastFacultyId = await User.findOne(
    { role: 'faculty' },
    { id: 1, _id: 0 }
  )
    .sort({
      createdAt: -1,
    })
    .lean();
  return lastFacultyId?.id ? lastFacultyId.id.substring(2) : undefined;
};

export const generatedFacultyId = async () => {
  const currentId =
    (await findLastFacultyId()) || (0).toString().padStart(5, '0');

  let incrementdId = (parseInt(currentId) + 1).toString().padStart(5, '0');
  incrementdId = `F-${incrementdId}`;
  return incrementdId;
};

// Admin
export const findLastAdminId = async () => {
  const lastAdminId = await User.findOne({ role: 'admin' }, { id: 1, _id: 0 })
    .sort({
      createdAt: -1,
    })
    .lean();
  return lastAdminId?.id ? lastAdminId.id.substring(2) : undefined;
};

export const generatedAdminId = async () => {
  const currentId =
    (await findLastAdminId()) || (0).toString().padStart(5, '0');

  let incrementdId = (parseInt(currentId) + 1).toString().padStart(5, '0');
  incrementdId = `A-${incrementdId}`;
  return incrementdId;
};
