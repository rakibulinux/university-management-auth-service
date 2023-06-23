"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const calculatePagination = (options) => {
    const page = Number(options.page || 1);
    const limit = Number(options.limit || 10);
    const skip = (page - 1) * limit;
    const soryBy = options.soryBy || 'createdAt';
    const sortOrder = options.sortOrder || 'desc';
    return {
        page,
        limit,
        skip,
        soryBy,
        sortOrder,
    };
};
exports.default = calculatePagination;
