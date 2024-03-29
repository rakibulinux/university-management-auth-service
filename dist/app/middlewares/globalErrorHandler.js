'use strict';
var __importDefault =
  (this && this.__importDefault) ||
  function (mod) {
    return mod && mod.__esModule ? mod : { default: mod };
  };
Object.defineProperty(exports, '__esModule', { value: true });
const config_1 = __importDefault(require('../../config'));
const handleValidatorError_1 = __importDefault(
  require('../../errors/handleValidatorError'),
);
const ApiError_1 = __importDefault(require('../../errors/ApiError'));
const logger_1 = require('../../shared/logger');
const zod_1 = require('zod');
const handleZodError_1 = __importDefault(
  require('../../errors/handleZodError'),
);
const handleCastError_1 = __importDefault(
  require('../../errors/handleCastError'),
);
// eslint-disable-next-line no-unused-vars, @typescript-eslint/no-unused-vars
const globalErrorHandler = (error, req, res, next) => {
  (config_1.default === null || config_1.default === void 0
    ? void 0
    : config_1.default.env) === 'development'
    ? logger_1.errorLogger.error(`Global Error Handler`, error)
    : logger_1.errorLogger.error(`Global Error Handler`, error);
  let statusCode = 500;
  let message = 'Something went wrong!';
  let errorMessage = [];
  if (
    (error === null || error === void 0 ? void 0 : error.name) ===
    'ValidationError'
  ) {
    const simplifiedError = (0, handleValidatorError_1.default)(error);
    statusCode = simplifiedError.statusCode;
    message = simplifiedError.message;
    errorMessage = simplifiedError.errorMessage;
  } else if (error instanceof zod_1.ZodError) {
    const simplifiedError = (0, handleZodError_1.default)(error);
    statusCode = simplifiedError.statusCode;
    message = simplifiedError.message;
    errorMessage = simplifiedError.errorMessage;
  } else if (error.name === 'CastError') {
    const simplifiedError = (0, handleCastError_1.default)(error);
    statusCode = simplifiedError.statusCode;
    message = simplifiedError.message;
    errorMessage = simplifiedError.errorMessage;
  } else if (error instanceof ApiError_1.default) {
    statusCode = error === null || error === void 0 ? void 0 : error.statusCode;
    message = error === null || error === void 0 ? void 0 : error.message;
    errorMessage = (error === null || error === void 0 ? void 0 : error.message)
      ? [
          {
            path: '',
            message:
              error === null || error === void 0 ? void 0 : error.message,
          },
        ]
      : [];
  } else if (error instanceof Error) {
    message = error === null || error === void 0 ? void 0 : error.message;
    errorMessage = (error === null || error === void 0 ? void 0 : error.message)
      ? [
          {
            path: '',
            message:
              error === null || error === void 0 ? void 0 : error.message,
          },
        ]
      : [];
  }
  res.status(statusCode).json({
    success: false,
    message,
    errorMessage,
    stack:
      config_1.default.env !== 'production'
        ? error === null || error === void 0
          ? void 0
          : error.stack
        : undefined,
  });
  // next();
};
exports.default = globalErrorHandler;
