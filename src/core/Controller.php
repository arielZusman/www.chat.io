<?php

/**
* 
*/
class Controller
{
	
	public static function action($cmd)
	{
		if (array_key_exists('action', $cmd) && array_key_exists('msg', $cmd) ) {
			$methods = get_class_methods(__CLASS__);
			if (in_array($cmd->action, $methods)) {
				call_user_func_array([__CLASS__, $cmd->action], array($cmd->msg));
			}
		}
	}

	protected static function login($username = '')
	{
		//check if user exists in DB
		//yes : login user
	}

	protected static function logout($username = '')
	{
		# code...
	}

	protected static function sendTo($to = '', $msg = '')
	{
		# code...
	}
	protected static function getOnlineUsers()
	{
		# code...
	}
}