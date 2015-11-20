<?php
// require_once 'db.php';


class chatLog
{
    public $db;
    
    public function __construct($db)
    {
        $this->db = $db;
        $query    = "CREATE TABLE IF NOT EXISTS `conversation` (
			`id`	INTEGER PRIMARY KEY AUTOINCREMENT,
			`fromUserID`	INTEGER,
			`toUserID`	INTEGER,
			`message`	TEXT,
			`timestamp`	DATETIME DEFAULT CURRENT_TIMESTAMP,
			FOREIGN KEY(`fromUserID`) REFERENCES users ( id ),
			FOREIGN KEY(`toUserID`) REFERENCES users ( id )
		);";
        
        $this->db->query($query);
        
    }
    
    /**
     * insert new message to conversation table
     * @param  int $from    user id
     * @param  int $to      user id
     * @param  string $message the message
     * @return int          number of rows affected
     */
    public function newMessage($from, $to, $message)
    {
        if (strlen($message)>0){
        	$query = "INSERT INTO `conversation` (`fromUserID`, `toUserID`, `message`)  values(?,?,?)";

        	$this->db->query($query, array($from, $to, $message));

        	return $this->db->count();
        }
        return false;
    }
    /**
     * Get messages between users 
     * @param  int  $user1 user id
     * @param  int  $user2 user id
     * @param  integer $limit 	number of messages to retrieve 
     * @return [type]         [description]
     */
    public function getConversation($user1, $user2, $limit = 20)
    {
    	$query = "SELECT *
				FROM conversation
				WHERE (fromUserID = ? AND toUserID = ?)
				  OR (fromUserID = ? AND toUserID = ?)
				ORDER BY timestamp LIMIT {$limit}";

		$this->db->query($query, array($user1, $user2, $user2, $user1));

		return $this->db->results();
    }
}

// $db  = DB::dbHandle();
// $log = new chatLog($db);

// $log->newMessage(1,2,"hi ?");
// $log->newMessage(3,2,"how are you");
// $log->newMessage(1,2,"are you here");
// $log->newMessage(3,1,"no way");
// $log->newMessage(1,2,"are you sure");
// $log->newMessage(3,1,"lorem i");
// $log->newMessage(1,3,"stop it");
// $log->newMessage(2,1,"yesy");
// $log->newMessage(2,1,"jkjkl");

// print_r($log->getConversation(1,2));