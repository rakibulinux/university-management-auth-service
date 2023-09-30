/* eslint-disable no-unused-vars */
import { Model, Types } from 'mongoose';
import { IStudent } from '../student/student.interface';

export type IUser = {
  id: string;
  role: string;
  password: string;
  needsPasswordChanged: true | false;
  passwordChangedAt?: Date;
  student?: Types.ObjectId | IStudent;
  faculty?: Types.ObjectId;
  admin?: Types.ObjectId;
};

export type UserModel = {
  isUserExsist(
    id: string,
  ): Promise<Pick<IUser, 'id' | 'role' | 'password' | 'needsPasswordChanged'>>;
  isPasswordMatched(
    givenPassword: string,
    savedPassword: string,
  ): Promise<boolean>;
} & Model<IUser>;

// export type IUserMethods = {
//   isUserExsist(id: string): Promise<Partial<IUser> | null>;
//   isPasswordMatched(
//     givenPassword: string,
//     savedPassword: string
//   ): Promise<boolean>;
// };

// export type UserModel = Model<IUser, Record<string, unknown>, IUserMethods>;
