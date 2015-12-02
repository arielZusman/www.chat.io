<?php

/**
* 
*/
class ChatApp extends Server
{
	public 	$db,
			$readSock;

	/**
     * start the server
     * 
     */
    public function __construct($db){
		$this->db = $db;
        parent::__construct("127.0.0.1", 5000);


	}

    /**
     * simple controller to handle the message sent by the browser
     * message is sent by the browser as an array [method, param1, param2 ]
     * @param socket $readSock socket resource id
     * @param string $lastMsg  the message recived from the browser
     */
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
            // set an array of params
			$params = $action ? array_values($action) : [];

			call_user_func_array([$this, $method], $params);
		}
    }

    /**
     * Login or register user in DB and then add to users array
     * @param  string $username
     * @return boolean t
     *
     * @todo Check if user is in users
     * @todo register user in users table
     */
    public function login($username)
    {
    	// update user as loged in db
    	$query = "UPDATE users
                SET session = 1
                WHERE username = ?";

        $this->db->query($query, array($username));

        if ($this->db->count() > 0) {
            // get user data
            $query = "SELECT * FROM users WHERE username = ? LIMIT 1";
            $this->db->query($query, array($username));

            $user = $this->db->results()[0];

            //create a new user object and it to active users array

            $user = new User($user->username, $user->id, $this->readSock);

            $this->updateUsers('add', $user);

            echo 'Login: ' . $username . "\n";

            //send user data to browser
            $msg = array (
                    'login' => 'success',
                    'username' => $user->username,
                    'userID' => $user->userID
                    );
            $this->send($this->readSock,json_encode($msg));
        }




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
		foreach ($this->users as $user) {
			if ($user->username == $username) {
				$sendTo = $user;
				break;
			}
		}
    	var_dump($sendTo);
    	$this->send($sendTo->socketID, $msg);
    }

    /**
     * updates the users array and send an updated user list to all clients
     */
    public function updateUsers($action = '', User $user)
    {
        if ($action == 'add') {
            $this->users[] = $user;
        }
        $msg = array();
        foreach ($this->users as $user) {
            $msg[] = get_object_vars($user);
        }


        $msg = json_encode($msg);
        var_dump($msg);
        foreach ($this->users as $user) {
            $this->send($user->getSocketID(), $msg);
        }



    }
    /**
     * get users that have active connection to the server
     * @return [type] [description]
     */
    public function getOnlineUsers()
    {
    	$users;
    	// $this->send($this->readSock,)
    }
}