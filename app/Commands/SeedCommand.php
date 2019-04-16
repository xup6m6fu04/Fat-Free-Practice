<?php


namespace App\Commands;

use App\Repositories\ClassRepository;
use App\Repositories\ClassStudentRepository;
use App\Repositories\ClassTeacherRepository;
use App\Repositories\SchoolRepository;
use App\Repositories\TeacherRepository;
use App\Repositories\StudentRepository;
use Carbon\Carbon;

class SeedCommand
{
    protected $f3;
    protected $db;
    protected $teacherRepository;
    protected $studentRepository;
    protected $schoolRepository;
    protected $classRepository;
    protected $classStudentRepository;
    protected $classTeacherRepository;

    public function __construct()
    {
        ini_set("memory_limit","4096M");
        global $f3;
        $this->f3 = $f3;
        $this->db = $f3->get('db');
        $this->teacherRepository = new TeacherRepository();
        $this->studentRepository = new StudentRepository();
        $this->schoolRepository = new SchoolRepository();
        $this->classRepository = new ClassRepository();
        $this->classStudentRepository = new ClassStudentRepository();
        $this->classTeacherRepository = new ClassTeacherRepository();
    }

    public function run()
    {
        $this->seedAll();
        $this->assignAll();
    }

    public function assignAll()
    {
        $this->assignTeacher();
        $this->assignStudent();
    }

    public function assignStudent()
    {
        $students = $this->studentRepository->getStudents([
            'sql_limit_end' => 999999
        ]);
        $count_class = 20;
        $offset = 0;
        foreach ($students as $student) {
            $class = $this->classRepository->getClasses([
                'school_id'       => $student->school_id,
                'sql_limit_start' => $offset,
                'sql_limit_end'   => 1,
            ], 'load');
            $args = [
                'class_id' => $class->class_id,
                'student_id' => $student->student_id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
            $this->classStudentRepository->addClassStudent($args);
            $offset++;
            if ($offset == $count_class) {
                $offset = 0;
            }
        }
    }

    public function assignTeacher()
    {
        $teachers = $this->teacherRepository->getTeachers([
            'sql_limit_end' => 999999
        ]);
        $count_class = 20;
        $offset = 0;
        foreach ($teachers as $teacher) {
            $class = $this->classRepository->getClasses([
                'school_id'       => $teacher->school_id,
                'sql_limit_start' => $offset,
                'sql_limit_end'   => 1,
            ], 'load');
            $args = [
                'class_id' => $class->class_id,
                'teacher_id' => $teacher->teacher_id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
            $this->classTeacherRepository->addClassTeacher($args);
            $offset++;
            if ($offset == $count_class) {
                $offset = 0;
            }
        }
    }

    public function seedAll()
    {
        $this->seedSchool();
        $this->seedClass();
        $this->seedStudent();
        $this->seedTeacher();
    }

    public function seedTeacher($num = 400)
    {
        $count_school = count($this->schoolRepository->getSchools());
        $count = ($this->f3->get('GET.count')) ?? $num;
        $offset = 0;
        for($i = 0; $i < $count; $i++) {
            $school = $this->schoolRepository->getSchools([
                'sql_limit_start' => $offset,
                'sql_limit_end' => 1,
            ], 'load');
            $this->teacherRepository->addTeacher(
                [
                    'teacher_id' => 'TID' . $this->randString(10, true),
                    'school_id'  => $school->school_id,
                    'name'       => 'TNAME' . $this->randString(10, true),
                    'email'      => $this->randString(10, false) . '@gmail.com',
                    'password'   => password_hash('password', PASSWORD_BCRYPT),
                    'enable'     => 'Y',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );
            $offset++;
            if ($offset == $count_school) {
                $offset = 0;
            }
        }

    }

    public function seedStudent($num = 10000)
    {
        $count_school = count($this->schoolRepository->getSchools());
        $offset = 0;
        // 產生學生
        $count = ($this->f3->get('GET.count')) ?? $num;
        for($i = 0; $i < $count; $i++) {
            $school = $this->schoolRepository->getSchools([
                'sql_limit_start' => $offset,
                'sql_limit_end' => 1,
            ], 'load');
            $this->studentRepository->addStudent(
                [
                    'student_id'   => 'SID' . $this->randString(10, true),
                    'school_id'  => $school->school_id,
                    'name'         => 'SNAME' . $this->randString(10, true),
                    'email'        => $this->randString(10, false) . '@gmail.com',
                    'password'     => password_hash('password', PASSWORD_BCRYPT),
                    'enable'       => 'Y',
                    'created_at'   => Carbon::now(),
                    'updated_at'   => Carbon::now(),
                ]
            );
            $offset++;
            if ($offset == $count_school) {
                $offset = 0;
            }
        }
    }

    public function seedSchool($num = 10)
    {
        $count = ($this->f3->get('GET.count')) ?? $num;
        for($i = 0; $i < $count; $i++) {
            $this->schoolRepository->addSchool(
                [
                    'school_id'  => 'ID' . $this->randString(10, true),
                    'name'       => 'SCHOOL' . $this->randString(7, true),
                    'enable'     => 'Y',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );
        }
    }

    public function seedClass($num = 20)
    {
        $count = ($this->f3->get('GET.count')) ?? $num;
        // Class 是隸屬在 School 底下故 School 不可無資料
        $school = $this->schoolRepository->getSchools();
        if (!$school) {
            $this->seedSchool();
            $school = $this->schoolRepository->getSchools();
        }
        foreach ($school as $school_v) {
            for($i = 0; $i < $count; $i++) {
                $this->classRepository->addClass(
                    [
                        'class_id'   => 'ID' . $this->randString(10, true),
                        'school_id'  => $school_v->school_id,
                        'name'       => 'CLASS' . $this->randString(7, true),
                        'enable'     => 'Y',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]
                );
            }
        }
    }

    /**
     * 產生亂數字串
     *
     * @param int $length
     * @param bool $only_number
     * @return string
     */
    public function randString($length = 10, $only_number = false)
    {
        $pattern = ($only_number) ? '0123456789' : '0123456789abcdefghijklmnopqrstuvwxyz';
        $string = '';
        while (strlen($string) < $length) {
            $string .= substr($pattern, rand(0, strlen($pattern) - 1), 1);
        }

        return $string;
    }
}