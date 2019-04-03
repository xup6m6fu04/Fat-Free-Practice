<?php


namespace App\Repositories;

use App\Student;

class StudentRepository
{
    public function addStudent($args)
    {
        $student = new Student();
        $student->id           = $args['id'];
        $student->school_id    = $args['school_id'];
        $student->name         = $args['name'];
        $student->email        = $args['email'];
        $student->password     = $args['password'];
        $student->subscription = $args['subscription'];
        $student->enable       = $args['enable'];
        $student->created_at   = $args['created_at'];
        $student->updated_at   = $args['updated_at'];
        $student->save();
    }
}