<?php

/**
 * Created by www.chat.io.
 * User: ariel.zusman
 * Date: 05/10/2015
 * Time: 16:50
 */

class Controller
{
    public $db = null;

    public function __construct()
    {
        $this->db = DB::dbHandle();
    }
    protected function model($model)
    {
        require_once '../chatApp/models/' . $model . '.php';
        return new $model();
    }

    protected function view($view, $data = [])
    {
        require_once '../chatApp/views/' . $view . '.php';
    }
}