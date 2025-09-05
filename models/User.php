<?php
require_once 'Database.php';
require_once 'traits/SearchableTrait.php';
require_once 'traits/LoggingTrait.php';

class User
{
    use SearchableTrait, LoggingTrait;

    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM users ORDER BY name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO users (name, email, phone, address)
            VALUES (:name, :email, :phone, :address)
        ");

        $stmt->execute($data);
        $this->logAction('User created', $data);
        return $this->db->lastInsertId();
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE users 
            SET name = :name, email = :email, phone = :phone, address = :address
            WHERE id = :id
        ");

        $data['id'] = $id;
        $stmt->execute($data);
        $this->logAction('User updated', $data);
        return $stmt->rowCount();
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $this->logAction('User deleted', ['id' => $id]);
        return $stmt->rowCount();
    }

    public function searchUsers($searchTerm)
    {
        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("
        SELECT * FROM users 
        WHERE name LIKE :search OR email LIKE :search OR phone LIKE :search
    ");

        $searchPattern = "%$searchTerm%";
        $stmt->bindParam(':search', $searchPattern, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
