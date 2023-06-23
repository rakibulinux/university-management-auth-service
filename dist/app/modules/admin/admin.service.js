"use strict";
var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
var __rest = (this && this.__rest) || function (s, e) {
    var t = {};
    for (var p in s) if (Object.prototype.hasOwnProperty.call(s, p) && e.indexOf(p) < 0)
        t[p] = s[p];
    if (s != null && typeof Object.getOwnPropertySymbols === "function")
        for (var i = 0, p = Object.getOwnPropertySymbols(s); i < p.length; i++) {
            if (e.indexOf(p[i]) < 0 && Object.prototype.propertyIsEnumerable.call(s, p[i]))
                t[p[i]] = s[p[i]];
        }
    return t;
};
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
exports.AdminService = void 0;
const paginationHelpers_1 = __importDefault(require("../../helpers/paginationHelpers"));
const admin_constent_1 = require("./admin.constent");
const admin_model_1 = require("./admin.model");
const ApiError_1 = __importDefault(require("../../../errors/ApiError"));
const http_status_1 = __importDefault(require("http-status"));
const getAllAdmins = (filters, paginationOptions) => __awaiter(void 0, void 0, void 0, function* () {
    const { searchTerm } = filters, filtersData = __rest(filters, ["searchTerm"]);
    const andCondition = [];
    if (searchTerm) {
        andCondition.push({
            $or: admin_constent_1.adminSearchableFields.map(field => ({
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
    const { page, limit, skip, soryBy, sortOrder } = (0, paginationHelpers_1.default)(paginationOptions);
    const sortCondition = {};
    if (soryBy && sortOrder) {
        sortCondition[soryBy] = sortOrder;
    }
    const whereCondition = andCondition.length > 0 ? { $and: andCondition } : {};
    const result = yield admin_model_1.Admin.find(whereCondition)
        .sort(sortCondition)
        .skip(skip)
        .limit(limit);
    const total = yield admin_model_1.Admin.countDocuments();
    return {
        meta: {
            page,
            limit,
            total,
        },
        data: result,
    };
});
const getSingleAdmin = (id) => __awaiter(void 0, void 0, void 0, function* () {
    const result = yield admin_model_1.Admin.findById(id);
    return result;
});
const deleteSingleAdmin = (id) => __awaiter(void 0, void 0, void 0, function* () {
    const result = yield admin_model_1.Admin.findByIdAndDelete(id);
    return result;
});
const updateAdmin = (id, payload) => __awaiter(void 0, void 0, void 0, function* () {
    const isExsist = yield admin_model_1.Admin.findOne({ _id: id });
    if (!isExsist) {
        throw new ApiError_1.default(http_status_1.default.NOT_FOUND, 'Admin Not found');
    }
    const { name } = payload, adminData = __rest(payload, ["name"]);
    const updateAdminData = Object.assign({}, adminData);
    if (name && Object.keys(name).length > 0) {
        Object.keys(name).forEach(key => {
            const nameKey = `name.${key}`;
            updateAdminData[nameKey] = name[key];
        });
    }
    const result = yield admin_model_1.Admin.findOneAndUpdate({ _id: id }, updateAdminData, {
        new: true,
    });
    return result;
});
exports.AdminService = {
    getAllAdmins,
    getSingleAdmin,
    updateAdmin,
    deleteSingleAdmin,
};
