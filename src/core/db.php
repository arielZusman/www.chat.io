<?php
/**
 * Created by PhpStorm.
 * User: ariel.zusman
 * Date: 23/09/2015
 * Time: 22:49
 */

class DB {
    private static $_handle = null;

    public $_pdo,
        $_query,
        $_error = false,
        $_results,
        $_count = 0;

    /**
     * create db handle for our database
     */
    private function __construct() {
        try {
            $this->_pdo = new PDO('sqlite:' . dirname( __FILE__) . '/db/ChatApp.db');
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    /**
     * Singleton for db handle
     * @return DB db handle
     */
    public static function dbHandle() {
        if(!isset(self::$_handle)) {
            self::$_handle = new DB();
        }
        return self::$_handle;
    }
    /**
     * prepare and run query store results and row count
     * @param  string $sql    the sql query we ned to run as
     * @param  array  $params the params passed to prepare the sql
     * @return [type]         [description]
     */
    public function query($sql, $params = array()) {
        $this->_error = false;
        if($this->_query = $this->_pdo->prepare($sql)){
            $x = 1;
            if(count($params)) {
                foreach ($params as $param) {
                    $this->_query->bindValue($x, $param);
                    $x++;
                }

            }

            if($this->_query->execute()){
                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count= $this->_query->rowCount();
            } else {
                $this->_error = true;
            }
        }

        return $this;
    }
    /**
     * get the last query results
     * @return object the last query result
     */
    public function results() {
        return $this->_results;
    }
    /**
     * last query affected rows
     * @return int affected rows
     */
    public function count()
    {
        return $this->_count;
    }
}
