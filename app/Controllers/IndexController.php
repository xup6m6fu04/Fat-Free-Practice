<?php


namespace App\Controllers;

use App\User;

class IndexController extends Controller
{
    protected $f3;
    protected $db;

    public function __construct()
    {
        global $f3;
        $this->f3 = $f3;
        $this->db = $f3->get('db');
    }

    public function login()
    {
        /*
        $this->f3->set('name', 'ash');
        return $this->template('table.html');
        */

        /*
        $user = new User();
        $rec = new \Auth($user, array('id' => 'email', 'pw' => 'password'));
        if ($rec->login('2222@gg.cc','3f23f23')) {
            echo 'yab';
        } else {
            echo 'fuck';
        }
        */


        /*

        $user = new User();
        $res = $user->load('id = 1');
        echo "<pre>"; print_r($res); echo "</pre>"; exit;

        */


        /*

        $res = $this->db->exec(
            'SELECT * FROM users WHERE ID = ?',
            '1'
        );

        echo "<pre>"; print_r($res); echo "</pre>"; exit;

        */
    }
}