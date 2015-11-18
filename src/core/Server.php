<?php
// error_reporting(~E_NOTICE);
// set_time_limit(0);



/**
 * 
 */
class Server
{
    protected   $sock,
                $users = array(),        
                $lastMsg;
    
    function __construct($address = "127.0.0.1", $port = 5000)
    {
        
        if (!($this->sock = socket_create(AF_INET, SOCK_STREAM, 0))) {
            die(Console::socketError("Couldn't create socket"));
        }
        socket_set_option($this->sock, SOL_SOCKET, SO_REUSEADDR, 1);
        echo "Socket created \n";
        
        // Bind the source address
        if (!socket_bind($this->sock, $address, 5000)) {
            die(Console::socketError("Couldn't bind socket"));
        }
        
        echo "Socket bind OK \n";
        
        if (!socket_listen($this->sock, 10)) {
            die(Console::socketError("Couldn't listen on socket"));
        }
        
        echo "Socket listen OK \n";
        echo "Waiting for incoming connections... \n";
        $this->main();
    }
    
    /**
     * convert header string to array  
     * @param  string $header header received from browser
     * @return array  the header as an array                
     */
    private function parseHeader($header = "")
    {
        $headerArr = array();
        $header    = explode("\r\n", $header);
        
        foreach ($header as $i => $line) {
            if ($line === '') {
                continue;
            }
            
            $parts = explode(': ', $line);
            if (isset($parts[1])) {
                $headerArr[$parts[0]] = $parts[1];
            } else {
                $headerArr[$i] = $line;
            }
            
        }        
        return $headerArr;
    }
    
    private function handshake($client, $buffer)
    {
        $response = "";
        $header   = $this->parseHeader($buffer);
        if (array_key_exists('Sec-WebSocket-Key', $header)) {
            $wsAccept = base64_encode(sha1($header['Sec-WebSocket-Key'] . "258EAFA5-E914-47DA-95CA-C5AB0DC85B11", true));
            
            $response = "HTTP/1.1 101 Switching Protocols\r\n";
            $response .= "Upgrade: websocket\r\n";
            $response .= "Connection: Upgrade\r\n";
            $response .= "Sec-WebSocket-Accept: " . $wsAccept . "\r\n\r\n";
        }
        
        if (socket_write($client, $response) !== false) {
            return true;
        }
        return false;
    }
    
    /**
     * [unmask description]
     * @param  [type] $text [description]
     * @return [type]       [description]
     */
    private function unmask($text)
    {
        $length = ord($text[1]) & 127;
        if ($length == 126) {
            $masks = substr($text, 4, 4);
            $data  = substr($text, 8);
        } elseif ($length == 127) {
            $masks = substr($text, 10, 4);
            $data  = substr($text, 14);
        } else {
            $masks = substr($text, 2, 4);
            $data  = substr($text, 6);
        }
        $text = "";
        for ($i = 0; $i < strlen($data); ++$i) {
            $text .= $data[$i] ^ $masks[$i % 4];
        }
        return $text;
    }
    
    /**
     * [mask description]
     * @param  [type] $text [description]
     * @return [type]       [description]
     */
    private function mask($text)
    {
        $b1     = 0x80 | (0x1 & 0x0f);
        $length = strlen($text);
        
        if ($length <= 125)
            $header = pack('CC', $b1, $length);
        elseif ($length > 125 && $length < 65536)
            $header = pack('CCn', $b1, 126, $length);
        elseif ($length >= 65536)
            $header = pack('CCNN', $b1, 127, $length);
        return $header . $text;
    }
    
    private function send($sendTo, $msg)
    {
        $msg = $this->mask($msg);
        socket_write($sendTo, $msg, strlen($msg));
    }

    /**
     * [main description]
     * @return [type] [description]
     */
    public function main()
    {
        // create a list of all the clients that will be connected to us..
        // add the listening socket to this list
        $clients = array($this->sock);
        $null    = null;
        while (true) {
            // create a copy, so $clients doesn't get modified by socket_select()
            $read = $clients;
            
            // get a list of all the clients that have data to be read from
            // if there are no clients with data, go to next iteration
            if (socket_select($read, $null, $null, 0) < 1)
                continue;
            
            // check if there is a client trying to connect
            if (in_array($this->sock, $read)) {
                // accept the client, and add him to the $clients array
                $clients[] = $newsock = socket_accept($this->sock);
                
                $header = socket_read($newsock, 1024); //read data sent by the socket
                
                if($this->handshake($newsock, $header)) {
                    $msg = "hi there";
                    $this->send($newsock, $msg);
                }
                
                if (socket_getpeername($newsock, $address, $port)) {
                    echo "Client $address : $port is now connected to us. \n";
                }
                
                // remove the listening socket from the clients-with-data array
                $key = array_search($sock, $read);
                unset($read[$key]);
            }
            
            // loop through all the clients that have data to read from
            
            foreach ($read as $read_sock) {
                $numBytes = @socket_recv($read_sock, $buffer, 1024, 0);
                if ($numBytes === false) {
                    echo Console::socketError('Unusual disconnection');
                } elseif ($numBytes == 0) {
                    // TODO normal disconnection
                } else {
                    $this->setLastMsg($this->unmask($buffer));
                    
                    // $this->app->action($this->unmask($buffer), $read_sock);
                }
                
                
            } // end of reading foreach
            
        }
    }
    
    public function setLastMsg($lastMsg){
        $this->lastMsg = $lastMsg;
    }
    
}

// $server = new Server;
// $server->main();