<?php
namespace App\Models;

use App\Core\Database;

class Model {
    protected $db;
    protected $table;

    public function __construct() {
        $this->db = new Database();
    }

    public function all() {
        $this->db->query("SELECT * FROM {$this->table}");
        return $this->db->resultSet();
    }

    public function find($id) {
        $this->db->query("SELECT * FROM {$this->table} WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function where($column, $value) {
        $this->db->query("SELECT * FROM {$this->table} WHERE {$column} = :value");
        $this->db->bind(':value', $value);
        return $this->db->resultSet();
    }

    public function create($data) {
        $columns = implode(', ', array_keys($data));
        $values = ':' . implode(', :', array_keys($data));
        
        $this->db->query("INSERT INTO {$this->table} ({$columns}) VALUES ({$values})");
        
        foreach ($data as $key => $value) {
            $this->db->bind(":{$key}", $value);
        }
        
        return $this->db->execute();
    }
    
    public function update($id, $data) {
        $set = '';
        foreach ($data as $key => $value) {
            $set .= "{$key} = :{$key}, ";
        }
        $set = rtrim($set, ', ');
        
        $this->db->query("UPDATE {$this->table} SET {$set} WHERE id = :id");
        $this->db->bind(':id', $id);
        
        foreach ($data as $key => $value) {
            $this->db->bind(":{$key}", $value);
        }
        
        return $this->db->execute();
    }
    
    public function delete($id) {
        $this->db->query("DELETE FROM {$this->table} WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
?>