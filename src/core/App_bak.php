<?php
require_once 'DB.php';
/**
* 
*/
class App
{
	
	private $db;		

	public function __construct()
	{
		$this->db = DB::dbHandle();
		$query = "CREATE TABLE IF NOT EXISTS`users` (
					`id`	INTEGER PRIMARY KEY AUTOINCREMENT,
					`username`	TEXT NOT NULL UNIQUE,
					`session`	TEXT
				);";		
		$this->db->query($query);
	}

	/**
	 * [action description]
	 * @param  array  $cmd [description]
	 * @return [type]      [description]
	 */
	public function action($cmd = array('action'=>'','args' => '') )
	{
		if (is_array($cmd) && array_key_exists('action', $cmd)) {
			$methods = get_class_methods(__CLASS__);
			if (in_array($cmd['action'], $methods)) {
				return call_user_func_array([__CLASS__, $cmd['action']], array($cmd['args']));
			}
		}
	}

	/**
	 * [login description]
	 * @param  string $username [description]
	 * @return [type]           [description]
	 */
	private  function login($username = '')
	{
		// $args = func_get_args();
		// var_export($args);
		echo "Login";
	}

	private  function logout($username = '')
	{
		echo "Logout";
	}

	private  function sendTo($to = '', $msg = '')
	{
		echo "sendTo";
	}
	private function getActiveUsers($value='')
	{
		echo "activeUsers<br/>" ;
		$query = "SELECT * FROM `users` WHERE  `session` != ''";
		$this->db->query($query);
		return $this->db->results();
	}
}

$app = new App;
$action = array('action'=>'getActiveUsers','args' => '');
var_dump($app->action($action));