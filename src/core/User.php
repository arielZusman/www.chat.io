<?php
/**
 * 
 */

// require_once 'DB.php';
class User
{
	private $db;	

	function __construct()
	{
		$this->db = DB::dbHandle();
	}
	
	
	public function login($username="")
	{
		var_dump($this->db);
		echo "Login in:" . $username;
	}
}