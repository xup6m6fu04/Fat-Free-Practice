<?php


namespace App\Commands;

use App\Repositories\TeacherRepository;
use App\Repositories\StudentRepository;
use Carbon\Carbon;

class SeedCommand
{
    protected $f3;
    protected $db;
    protected $teacherRepository;
    protected $studentRepository;

    public function __construct()
    {
        global $f3;
        $this->f3 = $f3;
        $this->db = $f3->get('db');
        $this->teacherRepository = new TeacherRepository();
        $this->studentRepository = new StudentRepository();
    }

    public function seedTeacher()
    {
        $count = ($this->f3->get('GET.count')) ?? 10;
        for($i = 0; $i < $count; $i++) {
            $this->teacherRepository->addTeacher(
                [
                    'id'        => 'ID' . $this->randString(10, true),
                    'school_id' => 'SCID' . $this->randString(10, true),
                    'name'      => 'NAME' . $this->randString(10, true),
                    'email'     => $this->randString(10, false) . '@gmail.com',
                    'password'  => password_hash('password', PASSWORD_BCRYPT),
                    'enable'    => 'Y',
                    'created_at'=> Carbon::now(),
                    'updated_at'=> Carbon::now(),
                ]
            );
        }
    }

    public function seedStudent()
    {
        $count = ($this->f3->get('GET.count')) ?? 10;
        for($i = 0; $i < $count; $i++) {
            $this->studentRepository->addStudent(
                [
                    'id' => 'ID' . $this->randString(10, true),
                    'school_id'     => 'SCID' . $this->randString(10, true),
                    'name'          => 'NAME' . $this->randString(10, true),
                    'email'         => $this->randString(10, false) . '@gmail.com',
                    'password'      => password_hash('password', PASSWORD_BCRYPT),
                    'subscription'  => 'Y',
                    'enable'        => 'Y',
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ]
            );
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