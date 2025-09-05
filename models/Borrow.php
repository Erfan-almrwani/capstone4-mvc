<?php
require_once 'Database.php';
require_once 'traits/LoggingTrait.php';
require_once 'interfaces/NotificationInterface.php';

class Borrow
{
    use LoggingTrait;

    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function borrowBook($userId, $bookId, $dueDate)
    {
        $this->db->beginTransaction();

        try {
            // Check if book is available
            $bookStmt = $this->db->prepare("SELECT available_copies FROM books WHERE id = :book_id FOR UPDATE");
            $bookStmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
            $bookStmt->execute();
            $book = $bookStmt->fetch(PDO::FETCH_ASSOC);

            if (!$book || $book['available_copies'] <= 0) {
                throw new Exception("Book not available for borrowing");
            }

            // Create borrow record
            $borrowStmt = $this->db->prepare("
                INSERT INTO borrows (user_id, book_id, borrow_date, due_date, status)
                VALUES (:user_id, :book_id, NOW(), :due_date, 'borrowed')
            ");

            $borrowStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $borrowStmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
            $borrowStmt->bindParam(':due_date', $dueDate);
            $borrowStmt->execute();

            // Update available copies
            $updateStmt = $this->db->prepare("
                UPDATE books SET available_copies = available_copies - 1 WHERE id = :book_id
            ");
            $updateStmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
            $updateStmt->execute();

            $this->db->commit();

            $this->logAction('Book borrowed', [
                'user_id' => $userId,
                'book_id' => $bookId,
                'due_date' => $dueDate
            ]);

            return $this->db->lastInsertId();
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Borrow transaction failed: " . $e->getMessage());
            throw $e;
        }
    }

    public function returnBook($borrowId)
    {
        $this->db->beginTransaction();

        try {
            // Get borrow details
            $borrowStmt = $this->db->prepare("SELECT * FROM borrows WHERE id = :id");
            $borrowStmt->bindParam(':id', $borrowId, PDO::PARAM_INT);
            $borrowStmt->execute();
            $borrow = $borrowStmt->fetch(PDO::FETCH_ASSOC);

            if (!$borrow) {
                throw new Exception("Borrow record not found");
            }

            // Update borrow record
            $updateBorrowStmt = $this->db->prepare("
                UPDATE borrows 
                SET return_date = NOW(), status = 'returned', late_fee = :late_fee
                WHERE id = :id
            ");

            $lateFee = $this->calculateLateFee($borrow['due_date']);
            $updateBorrowStmt->bindParam(':late_fee', $lateFee, PDO::PARAM_STR);
            $updateBorrowStmt->bindParam(':id', $borrowId, PDO::PARAM_INT);
            $updateBorrowStmt->execute();

            // Update available copies
            $updateBookStmt = $this->db->prepare("
                UPDATE books SET available_copies = available_copies + 1 WHERE id = :book_id
            ");
            $updateBookStmt->bindParam(':book_id', $borrow['book_id'], PDO::PARAM_INT);
            $updateBookStmt->execute();

            $this->db->commit();

            $this->logAction('Book returned', [
                'borrow_id' => $borrowId,
                'late_fee' => $lateFee
            ]);

            return $lateFee;
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Return transaction failed: " . $e->getMessage());
            throw $e;
        }
    }

    public function calculateLateFee($dueDate)
    {
        $due = new DateTime($dueDate);
        $return = new DateTime();

        if ($return <= $due) {
            return 0.00;
        }

        $daysLate = $return->diff($due)->days;
        $feePerDay = 1.00; // $1 per day late
        $lateFee = $daysLate * $feePerDay;

        return number_format($lateFee, 2);
    }

    public function getBorrowedBooks()
    {
        $stmt = $this->db->query("
            SELECT b.*, u.name as user_name, bk.title as book_title
            FROM borrows b
            JOIN users u ON b.user_id = u.id
            JOIN books bk ON b.book_id = bk.id
            WHERE b.status = 'borrowed'
            ORDER BY b.due_date
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBorrowHistory()
    {
        $stmt = $this->db->query("
            SELECT b.*, u.name as user_name, bk.title as book_title
            FROM borrows b
            JOIN users u ON b.user_id = u.id
            JOIN books bk ON b.book_id = bk.id
            ORDER BY b.borrow_date DESC
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getById($id)
    {
        $stmt = $this->db->prepare("
        SELECT b.*, u.name as user_name, bk.title as book_title
        FROM borrows b
        JOIN users u ON b.user_id = u.id
        JOIN books bk ON b.book_id = bk.id
        WHERE b.id = :id
    ");

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getBorrowsByUserId($userId)
    {
        $stmt = $this->db->prepare("
        SELECT b.*, u.name as user_name, bk.title as book_title
        FROM borrows b
        JOIN users u ON b.user_id = u.id
        JOIN books bk ON b.book_id = bk.id
        WHERE b.user_id = :user_id
        ORDER BY b.borrow_date DESC
    ");

        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOverdueBorrows()
    {
        $stmt = $this->db->query("
        SELECT b.*, u.name as user_name, bk.title as book_title
        FROM borrows b
        JOIN users u ON b.user_id = u.id
        JOIN books bk ON b.book_id = bk.id
        WHERE b.status = 'borrowed' AND b.due_date < CURDATE()
        ORDER BY b.due_date
    ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM borrows WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount();
    }


    public function getOverdueCount()
    {
        $stmt = $this->db->prepare("
        SELECT COUNT(*) as count 
        FROM borrows 
        WHERE status = 'borrowed' AND due_date < CURDATE()
    ");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("
        UPDATE borrows 
        SET due_date = :due_date, status = :status
        WHERE id = :id
    ");

        $stmt->bindParam(':due_date', $data['due_date']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount();
    }
}
