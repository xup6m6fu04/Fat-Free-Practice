<?php


namespace App\Controllers;

use Template;
use View;

class Controller
{
    protected function template($template)
    {
        echo Template::instance()->render($template);
    }

    protected function view($view)
    {
        echo View::instance()->render($view);
    }
}