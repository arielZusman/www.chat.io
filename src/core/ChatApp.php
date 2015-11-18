<?php 

/**
* 	
*/
class ChatApp extends Server
{
	public $db;

	public function __construct($db){
		parent::__construct("127.0.0.1", 5000);
		$this->db;
	}

	public function setLastMsg($lastMsg){
        $this->lastMsg = $lastMsg;
        var_dump($this->lastMsg);
        echo  "msg set\n";
    }
}