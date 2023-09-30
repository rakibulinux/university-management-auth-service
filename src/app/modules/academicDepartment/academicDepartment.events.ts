import { RedisClient } from '../../../shared/redis';
import {
  EVENT_ACADEMIC_DEPARTMENT_CREATED,
  EVENT_ACADEMIC_DEPARTMENT_DELETE,
  EVENT_ACADEMIC_DEPARTMENT_UPDATED,
} from './academicDepartment.constant';
import { IAcademicDepartmentEvent } from './academicDepartment.interface';
import { AcademicDepartmentService } from './academicDepartment.service';

const initAcademicDepartmentEvents = () => {
  RedisClient.subscribe(
    EVENT_ACADEMIC_DEPARTMENT_CREATED,
    async (e: string) => {
      const data: IAcademicDepartmentEvent = JSON.parse(e);

      await AcademicDepartmentService.createDepartmentFromEvent(data);
    },
  );
  RedisClient.subscribe(
    EVENT_ACADEMIC_DEPARTMENT_UPDATED,
    async (e: string) => {
      const data: IAcademicDepartmentEvent = JSON.parse(e);
      await AcademicDepartmentService.updateDepartmentFromEvent(data);
    },
  );
  RedisClient.subscribe(EVENT_ACADEMIC_DEPARTMENT_DELETE, async (e: string) => {
    const data: IAcademicDepartmentEvent = JSON.parse(e);
    await AcademicDepartmentService.deleteDepartmentFromEvent(data);
  });
};

export default initAcademicDepartmentEvents;
