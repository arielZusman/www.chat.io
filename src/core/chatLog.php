<?php
/*
	when user start a new chat its registerd in chats table
	when user resumes a chat




*/
require_once 'db.php';


class chatLog
{
	public $db;

	public function __construct($db)
	{
		$this->db = $db;
		$query = "CREATE TABLE IF NOT EXISTS `chats` (
			`chatID`	INTEGER PRIMARY KEY AUTOINCREMENT,
			`user1ID`	INTEGER,
			`user2ID`	INTEGER,
			FOREIGN KEY(`user1ID`) REFERENCES users ( id ),
			FOREIGN KEY(`user2ID`) REFERENCES users ( id )
			);";

		$this->db->query($query);

		$query = "CREATE TABLE IF NOT EXISTS `messages` (
			`chatID`	INTEGER,
			`message`	TEXT,
			`timestamp`	DATETIME DEFAULT CURRENT_TIMESTAMP,
			FOREIGN KEY(`chatID`) REFERENCES chats ( chatID )
			);";

		$this->db->query($query);

		}

		public function newChat($user1, $user2)
		{
			if ((strlen($user1) > 0) && (strlen($user2) > 0)){
				//get user id from db
				$query = "SELECT id FROM users WHERE username IN (?, ?)";
				$this->db->query($query, array($user1, $user2));

				$results = $this->db->results();



				print_r($results[0]->id);
			}
		}
		public function logMessage($value='')
		{
				# code...
		}
}

$db = DB::dbHandle();
$log = new chatLog($db);

$log->newChat('arielz','dani');