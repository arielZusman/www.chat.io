<?php
/**
 * 
 */

// require_once 'DB.php';
class User implements \SplSubject
{
	private $db;	

	function __construct()
	{
		$this->db = DB::dbHandle();
	}
	
	
	public function login($username="")
	{
		if (strlen($username) > 0 ){

			
		}
		
		echo "Login in:" . $username;
	}
}