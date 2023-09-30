'use strict';
Object.defineProperty(exports, '__esModule', { value: true });
exports.Faculty = exports.FacultySchema = void 0;
const mongoose_1 = require('mongoose');
const user_1 = require('../../../enums/user');
exports.FacultySchema = new mongoose_1.Schema(
  {
    id: {
      type: String,
      required: true,
      unique: true,
    },
    name: {
      type: {
        firstName: {
          type: String,
          required: true,
        },
        lastName: {
          type: String,
          required: true,
        },
        middleName: {
          type: String,
          required: false,
        },
      },
      required: true,
    },
    gender: {
      type: String,
      enum: user_1.Gender,
    },
    dateOfBirth: {
      type: String,
    },
    email: {
      type: String,
      unique: true,
      required: true,
    },
    contactNo: {
      type: String,
      unique: true,
      required: true,
    },
    emergencyContactNo: {
      type: String,
      required: true,
    },
    bloodGroup: {
      type: String,
      enum: user_1.BloodGroup,
    },
    presentAddress: {
      type: String,
      required: true,
    },
    permanentAddress: {
      type: String,
      required: true,
    },
    designation: {
      type: String,
      required: true,
    },
    academicFaculty: {
      type: mongoose_1.Schema.Types.ObjectId,
      ref: 'AcademicFaculty',
      required: true,
    },
    academicDepartment: {
      type: mongoose_1.Schema.Types.ObjectId,
      ref: 'AcademicDepartment',
      required: true,
    },
    profileImage: {
      type: String,
      // required: true,
    },
  },
  {
    timestamps: true,
    toJSON: {
      virtuals: true,
    },
  },
);
exports.Faculty = (0, mongoose_1.model)('Faculty', exports.FacultySchema);
