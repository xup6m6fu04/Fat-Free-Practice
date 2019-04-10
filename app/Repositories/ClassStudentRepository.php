<?php


namespace App\Repositories;

use App\ClassStudent;

class ClassStudentRepository
{
    public function addClassStudent($args)
    {
        $class_student = new ClassStudent();
        $class_student->id           = $args['id'];
        $class_student->class_id     = $args['class_id'];
        $class_student->student_id   = $args['student_id'];
        $class_student->created_at   = $args['created_at'];
        $class_student->updated_at   = $args['updated_at'];
        $class_student->save();

        return $class_student;
    }

    public function editClassStudent($id, $args)
    {
        $class_student = $this->getClassStudents(['id' => $id], 'load');

        $class_student->class_id     = $args['class_id'];
        $class_student->student_id   = $args['student_id'];
        $class_student->updated_at   = $args['updated_at'];
        $class_student->save();

        return $class_student;
    }

    public function getClassStudents($args = [], $type = 'find')
    {
        $id            = $args['id']            ?? false;
        $class_id      = $args['class_id']      ?? false;
        $student_id    = $args['student_id']    ?? false;
        $created_start = $args['created_start'] ?? false;
        $created_end   = $args['created_at']    ?? false;
        $updated_start = $args['updated_start'] ?? false;
        $updated_end   = $args['updated_at']    ?? false;

        $bind_arr[0] = ' 1=1 ';

        if ($id) {
            $bind_arr[0] .= ' AND id=:id ';
            $bind_arr[':id'] = $id;
        }
        if ($class_id) {
            $bind_arr[0] .= ' AND class_id=:class_id ';
            $bind_arr[':class_id'] = $class_id;
        }
        if ($student_id) {
            $bind_arr[0] = ' AND student_id=:student_id ';
            $bind_arr[':student_id'] = $student_id;
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

        $class_student = new ClassStudent();
        return $class_student->$type($bind_arr);

    }
}