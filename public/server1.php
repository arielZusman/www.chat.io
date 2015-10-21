<?php
/**
 * Created by www.chat.io.
 * User: ariel.zusman
 * Date: 19/10/2015
 * Time: 20:03
 */
function parse_header( $header = "") {
    $headerArr = array();
    $header =  explode("\r\n", $header);

    foreach ($header as $i => $line){
        if ($line === '') { continue ;}

        $parts = explode(': ', $line);
        if ( isset($parts[1]) ){
            $headerArr[$parts[0]] = $parts[1];
        } else {
            $headerArr[$i] = $line;
        }

    }
    return $headerArr;
}
function handshake($input){
    $header = parse_header($input);
    if (array_key_exists( 'Sec-WebSocket-Key', $header) ) {
        $wsAccept = base64_encode( sha1( $header['Sec-WebSocket-Key'] . "258EAFA5-E914-47DA-95CA-C5AB0DC85B11", true));

        $response  = "HTTP/1.1 101 Switching Protocols\r\n";
        $response .= "Upgrade: websocket\r\n";
        $response .= "Connection: Upgrade\r\n";
        $response .= "Sec-WebSocket-Accept: " . $wsAccept . "\r\n\r\n";
    }
//    var_dump($response);
    return $response;
}

error_reporting(~E_NOTICE);
set_time_limit (0);

$address = "0.0.0.0";
$port = 5000;
$max_clients = 10;
$str = array();
$header = array();
if(!($sock = socket_create(AF_INET, SOCK_STREAM, 0)))
{
    $errorcode = socket_last_error();
    $errormsg = socket_strerror($errorcode);

    die("Couldn't create socket: [$errorcode] $errormsg \n");
}

echo "Socket created \n";

// Bind the source address
if( !socket_bind($sock, $address , 5000) )
{
    $errorcode = socket_last_error();
    $errormsg = socket_strerror($errorcode);

    die("Could not bind socket : [$errorcode] $errormsg \n");
}

echo "Socket bind OK \n";

if(!socket_listen ($sock , 10))
{
    $errorcode = socket_last_error();
    $errormsg = socket_strerror($errorcode);

    die("Could not listen on socket : [$errorcode] $errormsg \n");
}

echo "Socket listen OK \n";

echo "Waiting for incoming connections... \n";

//array of client sockets
$client_socks = array();

//array of sockets to read
$read = array();

//start loop to listen for incoming connections and process existing connections
while (true)
{
    //prepare array of readable client sockets
    $read = array();

    //first socket is the master socket
    $read[0] = $sock;

    //now add the existing client sockets
    for ($i = 0; $i < $max_clients; $i++)
    {
        if($client_socks[$i] != null)
        {
            $read[$i+1] = $client_socks[$i];
        }
    }

    //now call select - blocking call
    if( ($num = socket_select($read , $write , $except , null)) === false)
    {
        $errorcode = socket_last_error();
        $errormsg = socket_strerror($errorcode);

        die("Could not listen on socket : [$errorcode] $errormsg \n");
    }

    //if ready contains the master socket, then a new connection has come in
    if (in_array($sock, $read))
    {
        for ($i = 0; $i < $max_clients; $i++)
        {
            if ($client_socks[$i] == null)
            {
                $client_socks[$i] = socket_accept($sock);

                //display information about the client who is connected
                if(socket_getpeername($client_socks[$i], $address, $port))
                {
                    echo "Client $address : $port is now connected to us. \n";
                }

                //Send Welcome message to client
                $message = "Welcome to php socket server version 1.0 \n";
                $message .= "Enter a message and press enter, and i shall reply back \n";
                socket_write($client_socks[$i] , $message);
                break;
            }
        }
    }

    //check each client if they send any data
    for ($i = 0; $i < $max_clients; $i++)
    {

        if (in_array($client_socks[$i] , $read))
        {

            $numBytes = @socket_recv($client_socks[$i], $str[$i], 2048, 0);

            if ( $numBytes != 0 && strpos($str[$i],"\r\n\r\n")){
                $header[$i] = handshake($str[$i]);
//                var_dump($header);
                socket_write($client_socks[$i] , $header[$i]);
            }
//            $input = socket_read($client_socks[$i] , 2048 );
//            if ( $input != "\r\n") {
//                $str[$i][] = $input;
//            } else {
//                $output = implode('',$str[$i]);
//                $output = handshake($output);
//                echo "Sending output to client \n";
//                socket_write($client_socks[$i] , $output);
//            }



        }
    }
}