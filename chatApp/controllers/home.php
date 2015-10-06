<?php

/**
 * Created by www.chat.io.
 * User: ariel.zusman
 * Date: 05/10/2015
 * Time: 16:55
 */

class Home extends Controller
{
    public function index($name='')
    {
        $user = $this->model('User');
        $user->name = $name;

        $this->view('home/index', ['name' => $user->name]);
    }

}