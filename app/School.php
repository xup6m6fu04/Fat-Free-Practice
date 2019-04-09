<?php

namespace App;

use DB\SQL\Mapper;

class School extends Mapper
{
    protected $table = 'schools';

    public function __construct()
    {
        global $f3;
        parent::__construct($f3->get('db'), $this->table);
    }
}