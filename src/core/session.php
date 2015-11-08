<?php

/**
 * Created by www.chat.io.
 * User: ariel.zusman
 * Date: 13/10/2015
 * Time: 06:33
 */
class Session
{
    public static function exists($name)
    {
        return isset($_SESSION[$name]) ? true : false;
    }
    public static function put($name, $value)
    {
//        session_start();
        $_SESSION[$name] = $value;
//        session_write_close();
        return $_SESSION[$name];
    }

    public static function delete($name)
    {
        if(self::exists($name)){
            unset($_SESSION[$name]);
        }
    }

    public static function get($name)
    {
        return $_SESSION[$name];
    }

    public static function start()
    {
        session_start();
    }
}