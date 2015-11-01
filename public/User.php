<?php
/**
 * 
 */
class User
{
	public 	$userId,
			$userName,
			$sock,
			$sendBuf,
			$reciveBuf;

	function __construct($userId, $sock)
	{
		$this->userId = $userId;
		$this->sock = $sock;
	}
}