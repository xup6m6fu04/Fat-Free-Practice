<?php

namespace App;

use DB\SQL\Mapper;

class Teacher extends Mapper
{
    protected $table = 'teachers';

    public function __construct()
    {
        global $f3;
        parent::__construct($f3->get('db'), $this->table);
    }
}