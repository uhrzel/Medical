<?php

class Model {
    protected $db, $table, $primaryKey;

    public function __construct($table, $primaryKey) {
        $this->db = Database::getInstance();
        $this->table = $table;
        $this->primaryKey = $primaryKey;
    }

    public function all($sort = 'ASC') {
        return $this->db->query("SELECT * FROM {$this->table} ORDER BY {$this->primaryKey} {$sort}")->results();
    }

    public function find($params = []) {
        $conditions = '';
        $bind = [];
        $order = '';
        $limit = '';

        if(isset($params['conditions'])) {
            $conditions = ' WHERE ' . $params['conditions'];
        }

        if(array_key_exists('bind', $params)) {
            $bind = $params['bind'];
        }

        if(isset($params['order'])) {
            $order = ' ORDER BY ' . $params['order'];
        }

        if(isset($params['limit'])) {
            $limit = ' LIMIT ' . $params['limit'];
        }

        return $this->db->query("SELECT * FROM {$this->table}{$conditions}{$order}{$limit}", $bind)->results();
    }

    public function findBy($field, $value) {
        return $this->db->query("SELECT * FROM {$this->table} WHERE {$field} = ?", [$value])->results();
    }

    public function findFirst($field, $value) {
        return $this->db->query("SELECT * FROM {$this->table} WHERE {$field} = ?", [$value])->first();
    }

    public function create($fields = []) {
        $this->db->insert($this->table, $fields);
        return $this->db->lastInsertId();
    }

    public function update($id, $fields = []) {
        $this->db->update($this->table, $this->primaryKey, $id, $fields);
        return $this->db->lastInsertId();
    }

    public function delete($id){
        return $this->db->delete($this->table, $this->primaryKey, $id);
    }

    public function deleteAll(){
        return $this->db->deleteAll($this->table);
    }

    public function exists($id) {
        return $this->db->query("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?", [$id])->count() ? true : false;
    }

    public function lastInsertId() {
        return $this->db->lastInsertId();
    }
}