'use strict';
var __awaiter =
  (this && this.__awaiter) ||
  function (thisArg, _arguments, P, generator) {
    function adopt(value) {
      return value instanceof P
        ? value
        : new P(function (resolve) {
            resolve(value);
          });
    }
    return new (P || (P = Promise))(function (resolve, reject) {
      function fulfilled(value) {
        try {
          step(generator.next(value));
        } catch (e) {
          reject(e);
        }
      }
      function rejected(value) {
        try {
          step(generator['throw'](value));
        } catch (e) {
          reject(e);
        }
      }
      function step(result) {
        result.done
          ? resolve(result.value)
          : adopt(result.value).then(fulfilled, rejected);
      }
      step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
  };
var __importDefault =
  (this && this.__importDefault) ||
  function (mod) {
    return mod && mod.__esModule ? mod : { default: mod };
  };
Object.defineProperty(exports, '__esModule', { value: true });
exports.AcademicSemester = void 0;
const mongoose_1 = require('mongoose');
const academicSemester_constant_1 = require('./academicSemester.constant');
const ApiError_1 = __importDefault(require('../../../errors/ApiError'));
const http_status_1 = __importDefault(require('http-status'));
const academicSemesterSchema = new mongoose_1.Schema(
  {
    title: {
      type: String,
      required: true,
      enum: academicSemester_constant_1.academicSemesterTitle,
    },
    year: { type: String, required: true },
    code: {
      type: String,
      required: true,
      enum: academicSemester_constant_1.academicSemesterCode,
    },
    startMonth: {
      type: String,
      required: true,
      enum: academicSemester_constant_1.academicSemesterMonth,
    },
    endMonth: {
      type: String,
      required: true,
      enum: academicSemester_constant_1.academicSemesterMonth,
    },
  },
  {
    timestamps: true,
    toJSON: {
      virtuals: true,
    },
  }
);
academicSemesterSchema.pre('save', function (next) {
  return __awaiter(this, void 0, void 0, function* () {
    const isExsist = yield exports.AcademicSemester.findOne({
      title: this.title,
      year: this.year,
    });
    if (isExsist) {
      throw new ApiError_1.default(
        http_status_1.default.CONFLICT,
        'Academic Semister is already exsist'
      );
    }
    next();
  });
});
exports.AcademicSemester = (0, mongoose_1.model)(
  'AcademicSemester',
  academicSemesterSchema
);
// Handle same year and same semister issue
