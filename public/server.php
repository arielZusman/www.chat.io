<?php
/**
 * Created by www.chat.io.
 * User: ariel.zusman
 * Date: 18/10/2015
 * Time: 08:03
 */
class User {
    public  $isConnected,
            $handle;

    public function __construct($handle)
    {

    }
}

class WebSocket {

    private $sock,
            $errorCode,
            $errorMsg,
            $clients;

    public function __construct()
    {
        if ( !($this->sock = socket_create(AF_INET, SOCK_STREAM,SOL_TCP))){
            $this->errorCode = socket_last_error();
            $this->errorMsg = socket_strerror($errorcode);

            die("Couldn't create socket: [$this->errorCode] $this->errorMsg \n");
        }
        echo "Socket created \n";

        if( !socket_bind($this->sock, "127.0.0.1", 5000)){
            $this->errorCode = socket_last_error();
            $this->errorMsg = socket_strerror($errorcode);

            die("Couldn't bind socket: [$this->errorCode] $this->errorMsg \n");
        }

        echo "Socket bind OK \n";

        //listen
        if( !socket_listen($this->sock, 10)){
            $this->errorCode = socket_last_error();
            $this->errorMsg = socket_strerror($errorcode);

            die("Couldn't listen on socket: [$this->errorCode] $this->errorMsg \n");
        }

        echo "Socket listen OK \n";
        echo "Waiting... \n";

        $this->main();
    }

    private function parse_header( $header = "")
    {
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

    private function handshake($client, $buffer){
        $response = "";
        $header = $this->parse_header($buffer);
        if (array_key_exists('Sec-WebSocket-Key', $header)) {
            $wsAccept = base64_encode(sha1($header['Sec-WebSocket-Key'] . "258EAFA5-E914-47DA-95CA-C5AB0DC85B11", true));

            $response = "HTTP/1.1 101 Switching Protocols\r\n";
            $response .= "Upgrade: websocket\r\n";
            $response .= "Connection: Upgrade\r\n";
            $response .= "Sec-WebSocket-Accept: " . $wsAccept . "\r\n\r\n";
        }

        socket_write($client, $response);
    }

    private function main()
    {
        $write = $except = NULL;
        $this->clients = array($this->sock);

        while(true) {
            $read = $this->clients;

            if( socket_select($read, $write, $except, 0) < 1 ) {
                continue;
            }

            if ( in_array($this->sock, $read)) {
                $this->clients[] = $newSock = socket_accept($this->sock);

                if (socket_getpeername($newSock, $address, $port)) {
                    echo "Client $address : $port is now connected to us. \n";
                }
            }

            $client = socket_accept($this->sock);



            $numBytes = @socket_recv($client, $buffer, 2048, 0);

            if ( $numBytes != 0 && strpos($buffer,"\r\n\r\n")) {
                $this->handshake($client, $buffer);
            }
        }
        socket_close($this->sock);
    }
}

$ws = new webSocket();





















