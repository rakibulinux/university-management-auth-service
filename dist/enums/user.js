'use strict';
Object.defineProperty(exports, '__esModule', { value: true });
exports.BloodGroup = exports.Gender = exports.ENUM_USE_ROLE = void 0;
/* eslint-disable no-unused-vars */
var ENUM_USE_ROLE;
(function (ENUM_USE_ROLE) {
  ENUM_USE_ROLE['SUPER_ADMIN'] = 'super_admin';
  ENUM_USE_ROLE['ADMIN'] = 'admin';
  ENUM_USE_ROLE['STUDENT'] = 'student';
  ENUM_USE_ROLE['FACULTY'] = 'faculty';
})(ENUM_USE_ROLE || (exports.ENUM_USE_ROLE = ENUM_USE_ROLE = {}));
var Gender;
(function (Gender) {
  Gender['Male'] = 'male';
  Gender['Female'] = 'female';
})(Gender || (exports.Gender = Gender = {}));
var BloodGroup;
(function (BloodGroup) {
  BloodGroup['APositive'] = 'A+';
  BloodGroup['ANegative'] = 'A-';
  BloodGroup['BPositive'] = 'B+';
  BloodGroup['BNegative'] = 'B-';
  BloodGroup['ABPositive'] = 'AB+';
  BloodGroup['ABNegative'] = 'AB-';
  BloodGroup['OPositive'] = 'O+';
  BloodGroup['ONegative'] = 'O-';
})(BloodGroup || (exports.BloodGroup = BloodGroup = {}));
