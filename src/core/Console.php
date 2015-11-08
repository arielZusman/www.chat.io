<?php

class Console
{
	/**
	 * Display last socket error with custom message
	 * @param  string $msg custom message
	 * @return string      last error with custom message
	 */
    public static function socketError($msg = '')
    {
        $errorCode = socket_last_error() || '';
        $errorMsg = socket_strerror($errorCode) || '';

        echo "$msg: [$errorCode] $errorMsg \r\n";
    }
}