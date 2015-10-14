<?php

/**
 * Created by www.chat.io.
 * User: ariel.zusman
 * Date: 13/10/2015
 * Time: 06:46
 */
class Token
{
    static $tokenName = 'token';

    public static function generate()
    {
        return Session::put(self::$tokenName, md5(uniqid()));
    }

    public static function check($token)
    {
        if(Session::exists(self::$tokenName) && $token === Session::get(self::$tokenName)){
            Session::delete(self::$tokenName);
            return true;
        }

        return false;
    }

}