<?php
/**
 * Created by www.chat.io.
 * User: ariel.zusman
 * Date: 10/10/2015
 * Time: 18:49
 */

//Socket client example
if(!($sock = socket_create(AF_INET, SOCK_STREAM, 0))){
    $errorcode = socket_last_error();
    $errormsg = socket_strerror($errorcode);

    die("Couldn't create socket: [$errorcode] $errormsg \n");
}

echo "Socket created \n";

$ip_address =  gethostbyname("www.google.com");

if(!socket_connect($sock, $ip_address, 80)){
    $errorcode = socket_last_error();
    $errormsg = socket_strerror($errorcode);

    die("Couldn't connect: [$errorcode] $errormsg \n");
}

echo "Connection established \n";

$message = "GET / HTTP/1.1\r\n\r\n";

if( !socket_send( $sock, $message, strlen($message), 0)){
    $errorcode = socket_last_error();
    $errormsg = socket_strerror($errorcode);

    die("Couldn't send date: [$errorcode] $errormsg \n");
}

echo "Message send successfully \n";

if( socket_recv( $sock, $buf, 2045, MSG_WAITALL) === FALSE){
    $errorcode = socket_last_error();
    $errormsg = socket_strerror($errorcode);

    die("Couldn't receive date: [$errorcode] $errormsg \n");
}

echo $buf;
