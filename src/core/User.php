<?php
/**
 * 
 */

// require_once 'DB.php';
class User
{
	private $db,
			$socketID,
			$isLogin;	

	function __construct()
	{
		$this->db = DB::dbHandle();
	}
	
	
	public function login($username="")
	{
		if (strlen($username) > 0 ){
			$this->isLogin = 1;
			echo "Login in:" . $username;
			
		}
		
		
	}
}