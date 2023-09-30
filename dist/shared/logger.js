'use strict';
Object.defineProperty(exports, '__esModule', { value: true });
exports.logger = exports.errorLogger = void 0;
const winston_1 = require('winston');
const {
  combine,
  timestamp,
  label,
  printf,
  // prettyPrint
} = winston_1.format;
const myFormat = printf(({ level, message, label, timestamp }) => {
  const date = new Date(timestamp);
  const hour = date.getHours();
  const minutes = date.getMinutes();
  const seconds = date.getSeconds();
  return `${date} ${hour} ${minutes} ${seconds} [${label}] ${level}: ${message}`;
});
const logger = (0, winston_1.createLogger)({
  level: 'info',
  format: combine(
    label({ label: 'right meow!' }),
    timestamp(),
    myFormat,
    // prettyPrint()
  ),
  transports: [
    new winston_1.transports.Console(),
    // new DailyRotateFile({
    //   filename: path.join(
    //     process.cwd(),
    //     'logs',
    //     'winston',
    //     'success',
    //     'ph-success-%DATE%.log'
    //   ),
    //   datePattern: 'YYYY-DD-MM-HH',
    //   zippedArchive: true,
    //   maxSize: '20m',
    //   maxFiles: '14d',
    // }),
  ],
});
exports.logger = logger;
const errorLogger = (0, winston_1.createLogger)({
  level: 'error',
  format: combine(
    label({ label: 'right meow!' }),
    timestamp(),
    myFormat,
    // prettyPrint()
  ),
  transports: [
    new winston_1.transports.Console(),
    // new DailyRotateFile({
    //   filename: path.join(
    //     process.cwd(),
    //     'logs',
    //     'winston',
    //     'error',
    //     'ph-error-%DATE%.log'
    //   ),
    //   datePattern: 'YYYY-DD-MM-HH',
    //   zippedArchive: true,
    //   maxSize: '20m',
    //   maxFiles: '14d',
    // }),
  ],
});
exports.errorLogger = errorLogger;
