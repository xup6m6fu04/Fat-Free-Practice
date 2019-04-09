<?php


namespace App\Repositories;

use App\School;

class SchoolRepository
{
    public function addSchool($args)
    {
        $school = new School();
        $school->id           = $args['id'];
        $school->name         = $args['name'];
        $school->enable       = $args['enable'];
        $school->created_at   = $args['created_at'];
        $school->updated_at   = $args['updated_at'];
        $school->save();

        return $school;
    }

    public function editSchool($id, $args)
    {
        $school = $this->getSchools(['id' => $id], 'load');

        $school->name         = $args['name'];
        $school->enable       = $args['enable'];
        $school->updated_at   = $args['updated_at'];
        $school->save();

        return $school;
    }

    public function getSchools($args = [], $type = 'find')
    {
        $id            = $args['id']            ?? false;
        $name          = $args['name']          ?? false;
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
        if ($name) {
            $bind_arr[0] = ' AND name=:name ';
            $bind_arr[':name'] = $name;
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

        $school = new School();
        return $school->$type($bind_arr);

    }
}