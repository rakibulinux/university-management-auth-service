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
var __rest =
  (this && this.__rest) ||
  function (s, e) {
    var t = {};
    for (var p in s)
      if (Object.prototype.hasOwnProperty.call(s, p) && e.indexOf(p) < 0)
        t[p] = s[p];
    if (s != null && typeof Object.getOwnPropertySymbols === 'function')
      for (var i = 0, p = Object.getOwnPropertySymbols(s); i < p.length; i++) {
        if (
          e.indexOf(p[i]) < 0 &&
          Object.prototype.propertyIsEnumerable.call(s, p[i])
        )
          t[p[i]] = s[p[i]];
      }
    return t;
  };
var __importDefault =
  (this && this.__importDefault) ||
  function (mod) {
    return mod && mod.__esModule ? mod : { default: mod };
  };
Object.defineProperty(exports, '__esModule', { value: true });
exports.FacultyService = void 0;
const paginationHelpers_1 = __importDefault(
  require('../../helpers/paginationHelpers'),
);
const faculty_constent_1 = require('./faculty.constent');
const faculty_model_1 = require('./faculty.model');
const http_status_1 = __importDefault(require('http-status'));
const ApiError_1 = __importDefault(require('../../../errors/ApiError'));
const getAllFaculties = (filters, paginationOptions) =>
  __awaiter(void 0, void 0, void 0, function* () {
    const { searchTerm } = filters,
      filtersData = __rest(filters, ['searchTerm']);
    const andCondition = [];
    if (searchTerm) {
      andCondition.push({
        $or: faculty_constent_1.facultySearchableFields.map(field => ({
          [field]: {
            $regex: searchTerm,
            $options: 'i',
          },
        })),
      });
    }
    if (Object.keys(filtersData).length) {
      andCondition.push({
        $and: Object.entries(filtersData).map(([field, value]) => ({
          [field]: value,
        })),
      });
    }
    const { page, limit, skip, soryBy, sortOrder } = (0,
    paginationHelpers_1.default)(paginationOptions);
    const sortCondition = {};
    if (soryBy && sortOrder) {
      sortCondition[soryBy] = sortOrder;
    }
    const whereCondition =
      andCondition.length > 0 ? { $and: andCondition } : {};
    const result = yield faculty_model_1.Faculty.find(whereCondition)
      .sort(sortCondition)
      .skip(skip)
      .limit(limit);
    const total = yield faculty_model_1.Faculty.countDocuments();
    return {
      meta: {
        page,
        limit,
        total,
      },
      data: result,
    };
  });
const getSingleFaculty = id =>
  __awaiter(void 0, void 0, void 0, function* () {
    const result = yield faculty_model_1.Faculty.findById(id);
    return result;
  });
const deleteSingleFaculty = id =>
  __awaiter(void 0, void 0, void 0, function* () {
    const result = yield faculty_model_1.Faculty.findByIdAndDelete(id);
    return result;
  });
const updateFaculty = (id, payload) =>
  __awaiter(void 0, void 0, void 0, function* () {
    const isExsist = yield faculty_model_1.Faculty.findOne({ _id: id });
    if (!isExsist) {
      throw new ApiError_1.default(
        http_status_1.default.NOT_FOUND,
        'Faculty Not found',
      );
    }
    const { name } = payload,
      facultyData = __rest(payload, ['name']);
    const updateFacultyData = Object.assign({}, facultyData);
    if (name && Object.keys(name).length > 0) {
      Object.keys(name).forEach(key => {
        const nameKey = `name.${key}`;
        updateFacultyData[nameKey] = name[key];
      });
    }
    const result = yield faculty_model_1.Faculty.findOneAndUpdate(
      { _id: id },
      updateFacultyData,
      {
        new: true,
      },
    );
    return result;
  });
exports.FacultyService = {
  getAllFaculties,
  getSingleFaculty,
  updateFaculty,
  deleteSingleFaculty,
};
