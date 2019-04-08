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

        return $student;
    }

    public function editStudent($id, $args)
    {
        $student = $this->getStudents(['id' => $id], 'load');

        $student->school_id    = $args['school_id'];
        $student->name         = $args['name'];
        $student->email        = $args['email'];
        // $student->password     = $args['password'];
        $student->subscription = $args['subscription'];
        $student->enable       = $args['enable'];
        $student->updated_at   = $args['updated_at'];
        $student->save();

        return $student;
    }

    public function getStudents($args = [], $type = 'find')
    {
        $id            = $args['id']            ?? false;
        $school_id     = $args['school_id']     ?? false;
        $name          = $args['name']          ?? false;
        $email         = $args['email']         ?? false;
        // $password      = $args['password']      ?? false;
        $subscription  = $args['subscription']  ?? false;
        $enable        = $args['enable']        ?? false;
        $created_start = $args['created_start'] ?? false;
        $created_end   = $args['created_at']    ?? false;
        $updated_start = $args['updated_start'] ?? false;
        $updated_end   = $args['updated_at']    ?? false;

        $bind_arr[0] = ' 1=1 ';

        if ($id) {
            $bind_arr[0] .= ' AND id=:id ';
            $bind_arr[':id'] = $id;
        }

        if ($school_id) {
            $bind_arr[0] .= ' AND school_id=:school_id ';
            $bind_arr[':school_id'] = $school_id;
        }
        if ($name) {
            $bind_arr[0] = ' AND name=:name ';
            $bind_arr[':name'] = $name;
        }
        if ($email) {
            $bind_arr[0] = ' AND email=:email ';
            $bind_arr[':email'] = $email;
        }
        if ($subscription) {
            $bind_arr[0] = ' AND subscription=:subscription ';
            $bind_arr[':subscription'] = $subscription;
        }
        if ($enable) {
            $bind_arr[0] = ' AND enable=:enable ';
            $bind_arr[':enable'] = $enable;
        }
        if ($created_start) {
            $bind_arr[0] = ' AND created_at >=:created_start ';
            $bind_arr[':created_start'] = $created_start;
        }
        if ($created_end) {
            $bind_arr[0] = ' AND created_at <:created_end ';
            $bind_arr[':created_end'] = $created_end;
        }
        if ($updated_start) {
            $bind_arr[0] = ' AND updated_at >=:updated_start ';
            $bind_arr[':updated_start'] = $updated_start;
        }
        if ($updated_end) {
            $bind_arr[0] = ' AND updated_at <:updated_end ';
            $bind_arr[':updated_end'] = $updated_end;
        }

        $student = new Student();
        return $student->$type($bind_arr);

    }
}