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
const mongoose_1 = __importDefault(require('mongoose'));
const app_1 = __importDefault(require('./app'));
const index_1 = __importDefault(require('./config/index'));
const logger_1 = require('./shared/logger');
let server;
function startServer() {
  return __awaiter(this, void 0, void 0, function* () {
    try {
      yield mongoose_1.default.connect(index_1.default.database_url);
      logger_1.logger.info(`🛢   Database is connected successfully`);
      server = app_1.default.listen(index_1.default.port, () => {
        logger_1.logger.info(
          `Application listening on port ${index_1.default.port}`,
        );
      });
    } catch (err) {
      logger_1.errorLogger.error('Failed to connect to the database', err);
      process.exit(1);
    }
  });
}
function gracefulShutdown() {
  if (server) {
    server.close(() => {
      logger_1.logger.info('Server gracefully closed');
      process.exit(0);
    });
  } else {
    process.exit(0);
  }
}
process.on('uncaughtException', error => {
  logger_1.errorLogger.error(error);
  process.exit(1);
});
process.on('unhandledRejection', error => {
  logger_1.errorLogger.error(error);
  gracefulShutdown();
});
process.on('SIGTERM', () => {
  logger_1.logger.info('SIGTERM signal received');
  gracefulShutdown();
});
startServer().catch(error => {
  logger_1.errorLogger.error('Failed to start the server', error);
  process.exit(1);
});
