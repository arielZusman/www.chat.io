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

    private function __construct() {
        try {
            $this->_pdo = new PDO('sqlite:' . dirname( __FILE__) . '/db/ChatApp.db');
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function dbHandle() {
        if(!isset(self::$_handle)) {
            self::$_handle = new DB();
        }
        return self::$_handle;
    }

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

    public function results() {
        return $this->_results;
    }

    public function count()
    {
        return $this->_count;
    }
}
