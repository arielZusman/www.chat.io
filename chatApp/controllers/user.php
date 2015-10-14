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
        $token = filter_input(INPUT_POST,'token');

        if ( Token::check($token) ) {
            echo 'true';
//            if ( $this->user_exists($username) ) {
//                echo 'true';
//            }
        }

        exit();
    }

    public function register()
    {
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $token = filter_input(INPUT_POST,'token');
        if ( Token::check($token) ) {
            if ( $this->user_exists($username) ) {
                $this->db->query("INSERT INTO users (username, is_online ) VALUES (?, '1')", array($username));
                Session::start();
            }
        }






        $users = $this->db->_results;
        var_dump($users);


        exit();
    }

    public function logout()
    {

    }

    private function user_exists($username='')
    {
        $this->db->query('SELECT COUNT(1) FROM users WHERE username = ?', array($username));
        if ( $this->db->results() ) {
            return true;
        }
        return false;
    }

    private function is_login($username='')
    {
        $this->db->query('SELECT is_online FROM users WHERE username =  ?', array($username));
        if ( $this->db->results() ) {
            return true;
        }
        return false;
    }

    private function get_all_users()
    {

    }
}