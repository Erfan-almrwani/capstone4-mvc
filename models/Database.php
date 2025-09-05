<?php
// models/Database.php

require_once CONFIG_PATH . '/paths.php';
require_once CONFIG_PATH . '/database.php';

class Database {
    private static $instance = null;
    private $pdo;
    
    private function __construct() {
        $config = new DatabaseConfig();
        
        try {
            $this->pdo = new PDO(
                $config->getDSN(),
                $config->getUsername(),
                $config->getPassword(),
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (PDOException $e) {
            error_log("فشل الاتصال بقاعدة البيانات: " . $e->getMessage());
            throw new Exception("خطأ في الاتصال بقاعدة البيانات");
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->pdo;
    }
}
?>