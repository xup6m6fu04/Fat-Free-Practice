<?php

namespace App;

use DB\SQL\Mapper;

class Student extends Mapper
{
    protected $table = 'students';

    public function __construct()
    {
        global $f3;
        parent::__construct($f3->get('db'), $this->table);
    }

    public function getTable()
    {
        return $this->table;
    }
}