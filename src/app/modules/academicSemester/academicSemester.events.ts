import { RedisClient } from '../../../shared/redis';
import {
  EVENT_ACADEMIC_SEMESTER_CREATED,
  EVENT_ACADEMIC_SEMESTER_DELETE,
  EVENT_ACADEMIC_SEMESTER_UPDATED,
} from './academicSemester.constant';
import { IAcademicSemesterEvent } from './academicSemester.interface';
import { AcademicSemesterService } from './academicSemester.service';

const initAcademicSemesterEvents = () => {
  RedisClient.subscribe(EVENT_ACADEMIC_SEMESTER_CREATED, async (e: string) => {
    const data: IAcademicSemesterEvent = JSON.parse(e);

    await AcademicSemesterService.createSemisterFromEvent(data);
  });
  RedisClient.subscribe(EVENT_ACADEMIC_SEMESTER_UPDATED, async (e: string) => {
    const data: IAcademicSemesterEvent = JSON.parse(e);
    await AcademicSemesterService.updateSemisterFromEvent(data);
  });
  RedisClient.subscribe(EVENT_ACADEMIC_SEMESTER_DELETE, async (e: string) => {
    const data: IAcademicSemesterEvent = JSON.parse(e);
    await AcademicSemesterService.deleteSemisterFromEvent(data);
  });
};

export default initAcademicSemesterEvents;
