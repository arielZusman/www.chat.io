<?php
/**
 * 
 */

// require_once 'DB.php';
class User
{
	public $socketID,
				$username;

	function __construct($username, $socketID)
	{
		$this->username = $username;
		$this->socketID = $socketID;
	}
	
}