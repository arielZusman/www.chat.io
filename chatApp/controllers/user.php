<?php

/**
 * Created by www.chat.io.
 * User: ariel.zusman
 * Date: 10/10/2015
 * Time: 18:32
 */
class User extends Controller
{
    public function login($username = '')
    {

        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);

        if ( $this->user_exists($username) ) {

           $this->db->query("INSERT INTO users (username) VALUES (?)", array($username));
//           $this->db->query("SELECT * FROM users");

        }





        $users = $this->db->_results;
        var_dump($users);


        exit();
    }

    public function register()
    {

    }

    public function logout()
    {

    }

    private function user_exists($username='')
    {
        return true;
    }

    private function is_login($username='')
    {

    }

    private function get_all_users()
    {

    }
}