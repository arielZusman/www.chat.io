<?php 
error_reporting(~E_NOTICE);
set_time_limit(0);

spl_autoload_register( function( $class ){
    require_once $class . '.php';
});

// create DB handle
$db = DB::dbHandle();
$chatApp = new ChatApp($db);
