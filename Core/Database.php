<?php

class Database{
    private static $_instance = null;
    protected $_pdo,
            $_query,
            $_error = false,
            $_results,
            $_count = 0,
            $_lastInsertId = null;
            
    private function __construct(){
        try{
            $this->_pdo = new PDO('mysql:host='.Config::get('mysql/host').';dbname='.Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));
        }catch(PDOException $e){
            die($e->getMessage());
        }
    }

    public static function getInstance(){
        if(!isset(self::$_instance)){
            self::$_instance = new Database();
        }
        return self::$_instance;
    }

    public function count(){
        return $this->_count;
    }

    public function results(){
        return $this->_results;
    }

    public function first(){
        if($this->count() > 0){
            return $this->results()[0];
        }
    }

    public function last(){
        return $this->results()[$this->count() - 1];
    }

    public function lastInsertId(){
        return $this->_lastInsertId;
    }

    public function error(){
        return $this->_error;
    }

    public function query($sql, $params = []){
        $this->_error = false;
        if($this->_query = $this->_pdo->prepare($sql)){
            $x = 1;
            if(count($params)){
                foreach($params as $param){
                    $this->_query->bindValue($x, $param);
                    $x++;
                }
            }
            if($this->_query->execute()){
                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();
                $this->_lastInsertId = $this->_pdo->lastInsertId();
            }else{
                $this->_error = true;
            }
        }
        return $this;
    }

    public function insert($table, $fields = []){
        $fieldString = '';
        $valueString = '';
        $values = [];

        foreach($fields as $field => $value){
            $fieldString .= '`' . $field . '`,';
            $valueString .= '?,';
            $values[] = $value;
        }

        $fieldString = rtrim($fieldString, ',');
        $valueString = rtrim($valueString, ',');

        $sql = "INSERT INTO {$table} ({$fieldString}) VALUES ({$valueString})";

        if(!$this->query($sql, $values)->error()){
            return true;
        }
        return false;
    }

    public function update($table, $primaryKey, $id, $fields = []){
        $fieldString = '';
        $values = [];

        foreach($fields as $field => $value){
            $fieldString .= ' ' . $field . ' = ?,';
            $values[] = $value;
        }

        $fieldString = trim($fieldString);
        $fieldString = rtrim($fieldString, ',');

        $sql = "UPDATE {$table} SET {$fieldString} WHERE {$primaryKey} = {$id}";

        if(!$this->query($sql, $values)->error()){
            return true;
        }
        return false;
    }

    public function delete($table, $primaryKey, $id){
        $sql = "DELETE FROM {$table} WHERE {$primaryKey} = {$id}";

        if(!$this->query($sql)->error()){
            return true;
        }

        return false;
    }

    public function deleteAll($table){
        $sql = "DELETE FROM {$table}";

        if(!$this->query($sql)->error()){
            return true;
        }

        return false;
    }
}