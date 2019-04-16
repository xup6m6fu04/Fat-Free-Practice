<?php


namespace App\Repositories;

use App\Teacher;
use Carbon\Carbon;
use Exception;

class TeacherRepository
{
    public function addTeacher($args)
    {
        $teacher = new Teacher();
        $teacher->teacher_id = $args['teacher_id'];
        $teacher->school_id  = $args['school_id'];
        $teacher->name       = $args['name'];
        $teacher->email      = $args['email'];
        $teacher->password   = $args['password'];
        $teacher->enable     = $args['enable'];
        $teacher->created_at   = Carbon::parse($args['created_at'])->timestamp;
        $teacher->updated_at   = Carbon::parse($args['updated_at'])->timestamp;
        $teacher->save();

        return $teacher;
    }

    public function editTeacher($teacher_id, $args)
    {
        $teacher = $this->getTeachers(['teacher_id' => $teacher_id], 'load');

        $school_id = $args['school_id'] ?? false;
        $name      = $args['name']      ?? false;
        $email     = $args['email']     ?? false;
        $enable    = $args['enable']    ?? false;

        if ($school_id) {
            $teacher->school_id = $school_id;
        }
        if ($name) {
            $teacher->name = $name;
        }
        if ($email) {
            $teacher->email = $email;
        }
        if ($enable) {
            $teacher->enable = $enable;
        }

        $teacher->updated_at = Carbon::parse($args['updated_at'])->timestamp;
        $teacher->save();

        return $teacher;
    }

    public function getTeachers($args = [], $type = 'find', $key_word = false)
    {
        $connect = ($key_word) ? 'OR ' : 'AND ';
        $symbol = ($key_word) ? 'like ' : '= ';
        $bind_arr[0] = ($key_word) ? '' : '    1=1  ';

        $id            = $args['id']            ?? false;
        $teacher_id    = $args['teacher_id']    ?? false;
        $school_id     = $args['school_id']     ?? false;
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

        if ($teacher_id) {
            $bind_arr[0] .= $connect . ' teacher_id '. $symbol .' :teacher_id ';
            $bind_arr[':teacher_id'] = $teacher_id;
        }
        if ($school_id) {
            $bind_arr[0] .= $connect . ' school_id '. $symbol .' :school_id ';
            $bind_arr[':school_id'] = $school_id;
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

        $teacher = new Teacher();
        return $teacher->$type($bind_arr);

    }
}