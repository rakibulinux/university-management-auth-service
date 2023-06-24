import { Model } from 'mongoose';

export type ILoginUser = {
  id: string;
  password: string;
};

export type LoginUserModel = Model<ILoginUser, Record<string, unknown>>;
