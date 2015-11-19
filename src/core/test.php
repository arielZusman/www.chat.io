<?php

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

$users[] = new User('arielz',1);
$users[] = new User('dani',1);
$users[] = new User('sage',1);

$user = array_filter($users, function($val){
	return ($val->username == 'arielz') ? true : false;
});
var_dump($user[0]->socketID);
