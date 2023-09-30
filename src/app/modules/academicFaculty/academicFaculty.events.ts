import { RedisClient } from '../../../shared/redis';
import {
  EVENT_ACADEMIC_FACULTY_CREATED,
  EVENT_ACADEMIC_FACULTY_DELETE,
  EVENT_ACADEMIC_FACULTY_UPDATED,
} from './academicFaculty.constant';
import { IAcademicFacultyEvent } from './academicFaculty.interface';
import { AcademicFacultyService } from './academicFaculty.service';

const initAcademicFacultyEvents = () => {
  RedisClient.subscribe(EVENT_ACADEMIC_FACULTY_CREATED, async (e: string) => {
    const data: IAcademicFacultyEvent = JSON.parse(e);

    await AcademicFacultyService.createFacultyFromEvent(data);
  });
  RedisClient.subscribe(EVENT_ACADEMIC_FACULTY_UPDATED, async (e: string) => {
    const data: IAcademicFacultyEvent = JSON.parse(e);
    await AcademicFacultyService.updateFacultyFromEvent(data);
  });
  RedisClient.subscribe(EVENT_ACADEMIC_FACULTY_DELETE, async (e: string) => {
    const data: IAcademicFacultyEvent = JSON.parse(e);
    await AcademicFacultyService.deleteFacultyFromEvent(data);
  });
};

export default initAcademicFacultyEvents;
