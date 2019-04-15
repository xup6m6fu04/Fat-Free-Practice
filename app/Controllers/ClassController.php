<?php


namespace App\Controllers;

use App\Services\ClassService;
use App\Services\ClassStudentService;
use App\Services\SchoolService;
use App\Traits\LoggerTrait;
use Carbon\Carbon;
use Exception;
use Monolog\Logger;

class  ClassController extends Controller
{
    protected $f3;
    protected $db;
    protected $classService;
    protected $schoolService;
    protected $classStudentService;

    use LoggerTrait;

    public function __construct()
    {
        global $f3;
        $this->f3 = $f3;
        $this->db = $f3->get('db');
        $this->classService = new ClassService();
        $this->schoolService = new SchoolService();
        $this->classStudentService = new ClassStudentService();
    }

    public function pageClass()
    {
        try {
            $school_id = ($this->f3->get('GET.school_id')) ?? false;
            $school = $this->schoolService->getSchoolBySchoolId($school_id);

            if (!$school) {
                throw new Exception('School Not Found');
            }

            $key_word = ($this->f3->get('GET.key_word')) ?? false;
            if ($key_word) {
                $key_word = '%' . $key_word . '%';
            }
            $data_nums = $this->classService->countClassesBySchoolIdAndKeyWord($school_id, $key_word);

            $page = ($this->f3->get('GET.page')) ?? 1;
            $per = ($this->f3->get('GET.per')) ?? 20;

            $args = paginate($data_nums, $page, $per);
            $args['school_id'] = $school_id;

            $classes = $this->classService->getClassBySchoolIdAndParams($args, $key_word);

            $this->f3->set('school', $school);
            $this->f3->set('classes', $classes);
            $this->f3->set('page', $args);

            $this->template('class.html');

        } catch (Exception $ex) {
            $this->Log($ex, Logger::ERROR);
            $this->template('school.html');
        }

    }

    public function pageClassStudent()
    {
        try {
            $class_id = ($this->f3->get('GET.class_id')) ?? false;
            $class = $this->classService->getClassById($class_id);

            if (!$class) {
                throw new Exception('Class Not Found');
            }

            $school = $this->schoolService->getSchoolById($class->school_id);

            if (!$school) {
                throw new Exception('School Not Found');
            }

            $key_word = ($this->f3->get('GET.key_word')) ?? false;
            if ($key_word) {
                $key_word = '%' . $key_word . '%';
            }
            $data_nums = $this->vClassStudentService->countByClassId($class_id, $key_word);

            $page = ($this->f3->get('GET.page')) ?? 1;
            $per = ($this->f3->get('GET.per')) ?? 20;

            $args = paginate($data_nums, $page, $per);

            $class_students = $this->vClassStudentService->getByClassId($class_id, $key_word);

            $this->f3->set('school', $school);
            $this->f3->set('class', $class);
            $this->f3->set('class_students', $class_students);
            $this->f3->set('page', $args);

            $this->template('class_student.html');

        } catch (Exception $ex) {

            $this->Log($ex, Logger::ERROR);
            $this->template('school.html');

        }
    }

    public function pageClassTeacher()
    {
        try {
            $class_id = ($this->f3->get('GET.class_id')) ?? false;
            $class = $this->classService->getClassById($class_id);

            if (!$class) {
                throw new Exception('Class Not Found');
            }

            $school = $this->schoolService->getSchoolById($class->school_id);

            if (!$school) {
                throw new Exception('School Not Found');
            }

            $key_word = ($this->f3->get('GET.key_word')) ?? false;
            if ($key_word) {
                $key_word = '%' . $key_word . '%';
            }
            $data_nums = $this->vClassTeacherService->countByClassId($class_id, $key_word);

            $page = ($this->f3->get('GET.page')) ?? 1;
            $per = ($this->f3->get('GET.per')) ?? 20;

            $args = paginate($data_nums, $page, $per);

            $class_teachers = $this->vClassTeacherService->getByClassId($class_id, $key_word);

            $this->f3->set('school', $school);
            $this->f3->set('class', $class);
            $this->f3->set('class_teachers', $class_teachers);
            $this->f3->set('page', $args);

            $this->template('class_teacher.html');

        } catch (Exception $ex) {

            $this->Log($ex, Logger::ERROR);
            $this->template('school.html');

        }
    }

    public function addClass()
    {
        try {
            // 新增一個班級
            $args = [];
            $args['id']           = ($this->f3->get('POST.id'))        ?? false;
            $args['school_id']    = ($this->f3->get('POST.school_id')) ?? false;
            $args['name']         = ($this->f3->get('POST.name'))      ?? false;
            $args['enable']       = ($this->f3->get('POST.enable'))    ?? false;
            $args['created_at']   = Carbon::now();
            $args['updated_at']   = Carbon::now();

            // 新增資料
            $this->classService->addClass($args);

            return_json(['type' => 'success']);

        } catch (Exception $ex) {
            $this->Log($ex, Logger::ERROR);

            return_json([
                'type' => 'error',
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function editClass()
    {

        try {
            // 編輯一個班級
            $args = [];
            $args['id']           = ($this->f3->get('POST.id'))     ?? false;
            $args['name']         = ($this->f3->get('POST.name'))   ?? false;
            $args['enable']       = ($this->f3->get('POST.enable')) ?? false;
            $args['updated_at']   = Carbon::now();

            $this->classService->editClass($args['id'], $args);

            return_json([
                'type' => 'success'
            ]);

        } catch (Exception $ex) {
            $this->Log($ex, Logger::ERROR);

            return_json([
                'type' => 'error',
                'message' => $ex->getMessage()
            ]);

        }

    }

    public function getClassBySchoolId()
    {
        try {
            $school_id = ($this->f3->get('POST.school_id')) ?? false;
            $class = $this->classService->getClassBySchoolId($school_id);

            if (!$class) {
                throw new Exception('Class Not Found');
            }

            return_json([
                'type' => 'success',
                'class' => to_Array_two($class)
            ]);

        } catch (Exception $ex) {
            $this->Log($ex, Logger::ERROR);

            return_json([
                'type' => 'error',
                'message' => $ex->getMessage()
            ]);

        }
    }

    public function getClassById()
    {
        try {
            $id = ($this->f3->get('POST.id')) ?? false;
            $class = $this->classService->getClassById($id, 'load');

            if (!$class) {
                throw new Exception('Class Not Found');
            }

            return_json([
                'type' => 'success',
                'class' => to_Array($class)
            ]);

        } catch (Exception $ex) {
            $this->Log($ex, Logger::ERROR);

            return_json([
                'type' => 'error',
                'message' => $ex->getMessage()
            ]);

        }
    }
}