import { IAcademicSemester } from '../academicSemester/academicSemester.interface';
import User from './user.model';

export const findLastStudentId = async () => {
  const lastUser = await User.findOne({}, { id: 1, _id: 0 })
    .sort({
      createdAt: -1,
    })
    .lean();
  return lastUser?.id;
};
export const findLastFacultyId = async () => {
  const lastUser = await User.findOne({}, { id: 1, _id: 0 })
    .sort({
      createdAt: -1,
    })
    .lean();
  return lastUser?.id;
};
export const findLastAdminId = async () => {
  const lastUser = await User.findOne({}, { id: 1, _id: 0 })
    .sort({
      createdAt: -1,
    })
    .lean();
  return lastUser?.id;
};

export const generatedStudentId = async (
  academicSemester: IAcademicSemester
) => {
  const currentId =
    (await findLastStudentId()) || (0).toString().padStart(5, '0');

  let incrementdId = (parseFloat(currentId) + 1).toString().padStart(5, '0');
  incrementdId = `${academicSemester.year.substring(2)}${
    academicSemester.code
  }${incrementdId}`;
  console.log(incrementdId);
  // return incrementdId;
  //   lastUserId++
  //   return String(lastUserId).padStart(5, '0')
};
export const generatedFacultyId = async (
  academicSemester: IAcademicSemester
) => {
  const currentId =
    (await findLastFacultyId()) || (0).toString().padStart(5, '0');

  let incrementdId = (parseFloat(currentId) + 1).toString().padStart(5, '0');
  incrementdId = `${academicSemester.year.substring(2)}${
    academicSemester.code
  }${incrementdId}`;
  console.log(incrementdId);
  // return incrementdId;
  //   lastUserId++
  //   return String(lastUserId).padStart(5, '0')
};
export const generatedAdminId = async (academicSemester: IAcademicSemester) => {
  const currentId =
    (await findLastAdminId()) || (0).toString().padStart(5, '0');

  let incrementdId = (parseFloat(currentId) + 1).toString().padStart(5, '0');
  incrementdId = `${academicSemester.year.substring(2)}${
    academicSemester.code
  }${incrementdId}`;
  console.log(incrementdId);
  // return incrementdId;
  //   lastUserId++
  //   return String(lastUserId).padStart(5, '0')
};
