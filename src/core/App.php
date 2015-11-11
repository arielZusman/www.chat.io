<?php 
/**
* 
*/

require_once 'DB.php';
class App
{
	private $db;
	private $activeUsers;

	public function __construct()
	{
		$this->db = DB::dbHandle();
		$query = "CREATE TABLE IF NOT EXISTS`users` (
					`id`	INTEGER PRIMARY KEY AUTOINCREMENT,
					`username`	TEXT NOT NULL UNIQUE,
					`session`	TEXT
				);";		
		$this->db->query($query);

		$query = "SELECT * FROM `users` WHERE  `session` != ''";
		$this->db->query($query);
	}

	public function getActiveUsers($value='')
	{
		# code...
	}
}
// echo dirname( __FILE__);
$app = new APP;