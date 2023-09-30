export const gender = ['male', 'female'];
export const bloodGroup = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];

export const facultySearchableFields = [
  'id',
  'email',
  'contactNo',
  'name.firstName',
  'name.middleName',
  'name.lastName',
  'emergencyContactNo',
];
export const facultyFilterableFields = [
  'searchTerm',
  'id',
  'bloodGroup',
  'email',
  'contactNo',
  'emergencyContactNo',
  'designation',
];

export const EVENT_FACULTY_CREATED = 'faculty-created';
export const EVENT_FACULTY_UPDATED = 'faculty-updated';
export const EVENT_FACULTY_DELETED = 'faculty-deleted';
