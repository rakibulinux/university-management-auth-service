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
Object.defineProperty(exports, '__esModule', { value: true });
exports.generatedAdminId =
  exports.findLastAdminId =
  exports.generatedFacultyId =
  exports.findLastFacultyId =
  exports.generatedStudentId =
  exports.findLastStudentId =
    void 0;
const user_model_1 = require('./user.model');
// Student
const findLastStudentId = () =>
  __awaiter(void 0, void 0, void 0, function* () {
    const lastStudentId = yield user_model_1.User.findOne(
      { role: 'student' },
      { id: 1, _id: 0 }
    )
      .sort({
        createdAt: -1,
      })
      .lean();
    return (
      lastStudentId === null || lastStudentId === void 0
        ? void 0
        : lastStudentId.id
    )
      ? lastStudentId.id.substring(4)
      : undefined;
  });
exports.findLastStudentId = findLastStudentId;
const generatedStudentId = academicSemester =>
  __awaiter(void 0, void 0, void 0, function* () {
    const currentId =
      (yield (0, exports.findLastStudentId)()) ||
      (0).toString().padStart(5, '0');
    let incrementdId = (parseInt(currentId) + 1).toString().padStart(5, '0');
    incrementdId = `${
      academicSemester === null || academicSemester === void 0
        ? void 0
        : academicSemester.year.substring(2)
    }${
      academicSemester === null || academicSemester === void 0
        ? void 0
        : academicSemester.code
    }${incrementdId}`;
    return incrementdId;
  });
exports.generatedStudentId = generatedStudentId;
// Faculty
const findLastFacultyId = () =>
  __awaiter(void 0, void 0, void 0, function* () {
    const lastFacultyId = yield user_model_1.User.findOne(
      { role: 'faculty' },
      { id: 1, _id: 0 }
    )
      .sort({
        createdAt: -1,
      })
      .lean();
    return (
      lastFacultyId === null || lastFacultyId === void 0
        ? void 0
        : lastFacultyId.id
    )
      ? lastFacultyId.id.substring(2)
      : undefined;
  });
exports.findLastFacultyId = findLastFacultyId;
const generatedFacultyId = () =>
  __awaiter(void 0, void 0, void 0, function* () {
    const currentId =
      (yield (0, exports.findLastFacultyId)()) ||
      (0).toString().padStart(5, '0');
    let incrementdId = (parseInt(currentId) + 1).toString().padStart(5, '0');
    incrementdId = `F-${incrementdId}`;
    return incrementdId;
  });
exports.generatedFacultyId = generatedFacultyId;
// Admin
const findLastAdminId = () =>
  __awaiter(void 0, void 0, void 0, function* () {
    const lastAdminId = yield user_model_1.User.findOne(
      { role: 'admin' },
      { id: 1, _id: 0 }
    )
      .sort({
        createdAt: -1,
      })
      .lean();
    return (
      lastAdminId === null || lastAdminId === void 0 ? void 0 : lastAdminId.id
    )
      ? lastAdminId.id.substring(2)
      : undefined;
  });
exports.findLastAdminId = findLastAdminId;
const generatedAdminId = () =>
  __awaiter(void 0, void 0, void 0, function* () {
    const currentId =
      (yield (0, exports.findLastAdminId)()) || (0).toString().padStart(5, '0');
    let incrementdId = (parseInt(currentId) + 1).toString().padStart(5, '0');
    incrementdId = `A-${incrementdId}`;
    return incrementdId;
  });
exports.generatedAdminId = generatedAdminId;
