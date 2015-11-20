<?php
/**
 *
 */

// require_once 'DB.php';
class User
{
	public 	$username,
			$userID;

	protected $socketID;

	function __construct($username, $userID, $socketID)
	{
		$this->username = $username;
		$this->userID = $userID;
		$this->socketID = $socketID;
	}

	function getSocketID(){
		return $this->socketID;
	}
}