import { Model } from 'mongoose';
export type UserName = {
  firstName: string;
  middleName: string;
  lastName: string;
};

export type IAdmin = {
  id: string;
  name: UserName;
  gender: 'male' | 'female';
  dateOfBirth: string;
  email: string;
  contactNo: string;
  emergencyContactNo: string;
  department: string;
  designation: string;
  profileImage?: string;
};

export type AdminModel = Model<IAdmin, Record<string, unknown>>;
export type IAdminFilters = { searchTerm?: string };
