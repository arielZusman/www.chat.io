<?php
/**
 * 
 */
class User
{
	public 	$userId,
			$sock;
			
			

	function __construct($userId, $sock)
	{
		$this->userId = $userId;
		$this->sock = $sock;
	}
}