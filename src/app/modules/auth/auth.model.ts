/* eslint-disable @typescript-eslint/no-this-alias */
import { Schema, model } from 'mongoose';
import bcrype from 'bcrypt';
import config from '../../../config';
import { ILoginUser, LoginUserModel } from './auth.interface';
const loginUserSchema = new Schema<ILoginUser>(
  {
    id: {
      type: String,
      required: true,
      unique: true,
    },
    password: {
      type: String,
      required: true,
    },
  },
  {
    timestamps: true,
    toJSON: {
      virtuals: true,
    },
  }
);

loginUserSchema.pre('save', async function (next) {
  const user = this;
  user.password = await bcrype.hash(
    user.password,
    Number(config.bcrypt_salt_rounds)
  );
  next();
});

export const User = model<ILoginUser, LoginUserModel>('User', loginUserSchema);
