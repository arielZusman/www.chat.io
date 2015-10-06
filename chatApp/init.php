<?php
/**
 * Created by www.chat.io.
 * User: ariel.zusman
 * Date: 05/10/2015
 * Time: 16:43
 */



spl_autoload_register( function( $class ){
    require_once 'Core/' . $class . '.php';
});




