<?php


namespace App\Repositories;

use App\Student;
use Carbon\Carbon;

class StudentRepository
{
    public function addStudent($args)
    {
        $student = new Student();
        $student->student_id   = $args['student_id'];
        $student->name         = $args['name'];
        $student->email        = $args['email'];
        $student->password     = $args['password'];
        $student->enable       = $args['enable'];
        $student->created_at   = Carbon::parse($args['created_at'])->timestamp;
        $student->updated_at   = Carbon::parse($args['updated_at'])->timestamp;
        $student->save();

        return $student;
    }

    public function editStudent($student_id, $args)
    {
        $student = $this->getStudents(['student_id' => $student_id], 'load');

        $student->name         = $args['name'];
        $student->email        = $args['email'];
        // $student->password     = $args['password'];
        $student->enable       = $args['enable'];
        $student->updated_at   = Carbon::parse($args['updated_at'])->timestamp;
        $student->save();

        return $student;
    }

    public function getStudents($args = [], $type = 'find', $key_word = false)
    {
        $connect = ($key_word) ? 'OR ' : 'AND ';
        $symbol = ($key_word) ? 'like ' : '= ';
        $bind_arr[0] = ($key_word) ? '' : '    1=1  ';

        $id            = $args['id']            ?? false;
        $student_id    = $args['student_id']    ?? false;
        $name          = $args['name']          ?? false;
        $email         = $args['email']         ?? false;
        // $password      = $args['password']      ?? false;
        $enable        = $args['enable']        ?? false;
        $created_start = $args['created_start'] ?? false;
        $created_end   = $args['created_at']    ?? false;
        $updated_start = $args['updated_start'] ?? false;
        $updated_end   = $args['updated_at']    ?? false;

        // SQL Params
        $limit_start  = $args['sql_limit_start']  ?? 0;
        $limit_end    = $args['sql_limit_end']    ?? 10;
        $order        = $args['sql_order']        ?? 'created_at';
        $sort         = $args['sql_sort']         ?? 'desc';

        if ($student_id) {
            $bind_arr[0] .= $connect . ' student_id '. $symbol .' :student_id ';
            $bind_arr[':student_id'] = $student_id;
        }
        if ($name) {
            $bind_arr[0] .= $connect . ' name ' . $symbol . ' :name ';
            $bind_arr[':name'] = $name;
        }
        if ($email) {
            $bind_arr[0] .= $connect . ' email ' . $symbol . ' :email ';
            $bind_arr[':email'] = $email;
        }
        if ($enable) {
            $bind_arr[0] .= $connect . ' enable ' . $symbol . ' :enable ';
            $bind_arr[':enable'] = $enable;
        }
        if ($id) {
            $bind_arr[0] .= ' AND id=:id ';
            $bind_arr[':id'] = $id;
        }
        if ($created_start) {
            $bind_arr[0] .= ' AND created_at >=:created_start ';
            $bind_arr[':created_start'] = $created_start;
        }
        if ($created_end) {
            $bind_arr[0] .= ' AND created_at <:created_end ';
            $bind_arr[':created_end'] = $created_end;
        }
        if ($updated_start) {
            $bind_arr[0] .= ' AND updated_at >=:updated_start ';
            $bind_arr[':updated_start'] = $updated_start;
        }
        if ($updated_end) {
            $bind_arr[0] .= ' AND updated_at <:updated_end ';
            $bind_arr[':updated_end'] = $updated_end;
        }

        $bind_arr[0] .= ' ORDER BY ' . $order . ' ' . $sort . ' LIMIT :limit_start, :limit_end ';
        $bind_arr[':limit_start'] = $limit_start;
        $bind_arr[':limit_end'] = $limit_end;

        $bind_arr[0] = substr($bind_arr[0], 3);

        $student = new Student();
        return $student->$type($bind_arr);

    }
}