<?php 
error_reporting(~E_NOTICE);
set_time_limit(0);

spl_autoload_register( function( $class ){
    require_once $class . '.php';
});

$app = new App;
$server = new Server("127.0.0.1", 5000, $app);
