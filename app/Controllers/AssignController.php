<?php

namespace App\Controllers;

use App\Services\ClassService;
use App\Services\ClassStudentService;
use App\Services\SchoolService;
use App\Services\StudentService;
use App\Services\TeacherService;
use App\Traits\LoggerTrait;
use Exception;
use Monolog\Logger;

class AssignController extends Controller
{
    protected $f3;
    protected $db;
    protected $schoolService;
    protected $classService;
    protected $studentService;
    protected $teacherService;
    protected $classStudentService;
    protected $classTeacherService;

    use LoggerTrait;

    public function __construct()
    {
        global $f3;
        $this->f3 = $f3;
        $this->db = $f3->get('db');
        $this->schoolService = new SchoolService();
        $this->classService = new ClassService();
        $this->studentService = new StudentService();
        $this->teacherService = new TeacherService();
        $this->classStudentService = new ClassStudentService();
    }

    public function assignStudent()
    {
        try {

            $student_id = $this->f3->get('POST.assign_student_id');
            $school_id = $this->f3->get('POST.assign_school_id');
            $class_id = $this->f3->get('POST.assign_class_id');

            // 檢查 class_id 跟 school_id 是否存在且對應
            $class = $this->classService->getClassBySchoolIdAndParams([
                'school_id' => $school_id,
                'class_id'  => $class_id
            ]);

            if (!$class) {
                throw new Exception('School And Class Not Found');
            }

            // 檢查學生是否存在
            $student = $this->studentService->getStudentByStudentId($student_id);

            if (!$student) {
                throw new Exception('Student Not Found');
            }

            // 查看學生原本是否有被分配
            $class_student = $this->classStudentService->getByStudentId($student_id);
            if ($class_student) {
                $this->classStudentService->editClassStudent($student_id, ['class_id' => $class_id]);
            } else {
                $this->classStudentService->addSchool([
                    'class_id' => $class_id,
                    'student_id' => $student_id
                ]);
            }

            return_json(['type' => 'success']);

        } catch (Exception $ex) {

            $this->Log($ex, Logger::ERROR);

            return_json([
                'type' => 'error',
                'message' => $ex->getMessage()
            ]);

        }
    }

    public function assignTeacher()
    {

    }
}