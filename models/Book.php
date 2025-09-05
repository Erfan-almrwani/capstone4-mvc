<?php
require_once 'Database.php';
require_once 'traits/SearchableTrait.php';
require_once 'traits/LoggingTrait.php';

class Book {
    use SearchableTrait, LoggingTrait;
    
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM books ORDER BY title");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM books WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO books (title, author, isbn, published_year, total_copies, available_copies)
            VALUES (:title, :author, :isbn, :published_year, :total_copies, :available_copies)
        ");
        
        $stmt->execute($data);
        $this->logAction('Book created', $data);
        return $this->db->lastInsertId();
    }
    
    public function update($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE books 
            SET title = :title, author = :author, isbn = :isbn, 
                published_year = :published_year, total_copies = :total_copies, 
                available_copies = :available_copies
            WHERE id = :id
        ");
        
        $data['id'] = $id;
        $stmt->execute($data);
        $this->logAction('Book updated', $data);
        return $stmt->rowCount();
    }
    
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM books WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $this->logAction('Book deleted', ['id' => $id]);
        return $stmt->rowCount();
    }
    
    public function searchBooks($searchTerm) {
        return $this->search('books', ['title', 'author', 'isbn'], $searchTerm);
    }
    
    public function updateAvailableCopies($bookId, $change) {
        $stmt = $this->db->prepare("
            UPDATE books 
            SET available_copies = available_copies + :change 
            WHERE id = :book_id AND available_copies + :change >= 0
        ");
        
        $stmt->bindParam(':change', $change, PDO::PARAM_INT);
        $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>