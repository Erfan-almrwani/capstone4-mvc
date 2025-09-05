<?php
class DatabaseConfig {
    private $host = 'localhost';
    private $dbname = 'library_db';
    private $username = 'root';
    private $password = '';
    
    public function getDSN() {
        return "mysql:host={$this->host};dbname={$this->dbname};charset=utf8";
    }
    
    public function getUsername() {
        return $this->username;
    }
    
    public function getPassword() {
        return $this->password;
    }
}
?>