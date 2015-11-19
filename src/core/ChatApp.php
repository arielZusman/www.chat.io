<?php 

/**
* 	
*/
class ChatApp extends Server
{
	public 	$db,
			$readSock;

	public function __construct($db){
		parent::__construct("127.0.0.1", 5000);
		$this->db;
	}

	public function setLastMsg($readSock, $lastMsg){
        $this->lastMsg = $lastMsg;
        $this->readSock = $readSock;

        $action = json_decode($lastMsg);

        // method
		If(isset($action[0])){
			if(method_exists($this, $action[0])){
				$method = $action[0];
				unset($action[0]);
			}

			$params = $action ? array_values($action) : [];

			call_user_func_array([$this, $method], $params);
		}

		

    }

    /**
     * Login or register user and then add to users array
     * @param  string $username 
     * @return boolean t
     * 
     * @todo Check if user is in users
     * @todo register user in users table
     */
    public function login($username)
    {
    	
    	$this->users[] = new User($username, $this->readSock);
    	echo 'Login: ' . $username;
    	print_r($this->users);
    }

    public function logout($username)
    {
    	$this->users = array_filter($this->users, function($user){
    		return ($user->socketID != $this->readSock) ? true : false;
    	});

    	var_dump($this->users[0]);

    	
    	echo 'Logout: ' . $username;
    }

    public function sendTo($username, $msg)
    {
		var_dump($this->users);
		$user = array_filter($this->users, function($val){
    		return ($val->username == $username) ? true : false;
    	});
    	var_dump($user);
    	// $this->send($user[0]->socketID, $msg);
    }
}