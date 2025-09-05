<?php
// controllers/BorrowController.php

require_once __DIR__ . '/../config/paths.php';

require_once MODELS_PATH . '/Database.php';
require_once MODELS_PATH . '/Book.php';
require_once MODELS_PATH . '/User.php';
require_once MODELS_PATH . '/Borrow.php';

class BorrowController
{
    private $borrowModel;
    private $bookModel;
    private $userModel;

    public function __construct()
    {
        $this->borrowModel = new Borrow();
        $this->bookModel = new Book();
        $this->userModel = new User();
    }

    public function index()
    {
        $borrowedBooks = $this->borrowModel->getBorrowedBooks();
        require_once VIEWS_PATH . '/borrows/index.php';
    }

    public function borrow()
    {
        $books = $this->bookModel->getAll();
        $users = $this->userModel->getAll();

        require_once VIEWS_PATH . '/borrows/borrow.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_POST['user_id'];
            $bookId = $_POST['book_id'];
            $dueDate = $_POST['due_date'];

            try {
                $this->borrowModel->borrowBook($userId, $bookId, $dueDate);
                header('Location: index.php?action=borrows&message=تمت الاستعارة بنجاح');
                exit;
            } catch (Exception $e) {
                header('Location: index.php?action=borrow_book&error=خطأ في الاستعارة: ' . $e->getMessage());
                exit;
            }
        }
    }

    public function returnBook($borrowId)
    {
        try {
            $lateFee = $this->borrowModel->returnBook($borrowId);
            header('Location: index.php?action=borrows&message=تمت إعادة الكتاب بنجاح. الغرامة: ' . $lateFee . '$');
            exit;
        } catch (Exception $e) {
            header('Location: index.php?action=borrows&error=خطأ في إعادة الكتاب: ' . $e->getMessage());
            exit;
        }
    }

    public function history()
    {
        $borrowHistory = $this->borrowModel->getBorrowHistory();
        require_once VIEWS_PATH . '/borrows/history.php';
    }


    public function getAllAPI()
    {
        try {
            $borrows = $this->borrowModel->getBorrowHistory();
            return ['success' => true, 'data' => $borrows, 'count' => count($borrows)];
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function getByIdAPI($id)
    {
        try {
            $borrow = $this->borrowModel->getById($id);
            if ($borrow) {
                return ['success' => true, 'data' => $borrow];
            } else {
                return ['success' => false, 'error' => 'سجل الاستعارة غير موجود'];
            }
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function getByUserIdAPI($userId)
    {
        try {
            $borrows = $this->borrowModel->getBorrowsByUserId($userId);
            return ['success' => true, 'data' => $borrows, 'count' => count($borrows)];
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function createAPI($data)
    {
        try {
            $userId = $data['user_id'];
            $bookId = $data['book_id'];
            $dueDate = $data['due_date'];

            $borrowId = $this->borrowModel->borrowBook($userId, $bookId, $dueDate);
            return [
                'success' => true,
                'message' => 'تمت الاستعارة بنجاح',
                'id' => $borrowId,
                'data' => $this->borrowModel->getById($borrowId)
            ];
        } catch (Exception $e) {
            return ['success' => false, 'error' => 'خطأ في الاستعارة: ' . $e->getMessage()];
        }
    }

    public function returnAPI($id)
    {
        try {
            $lateFee = $this->borrowModel->returnBook($id);
            return [
                'success' => true,
                'message' => 'تمت إعادة الكتاب بنجاح',
                'late_fee' => $lateFee,
                'data' => $this->borrowModel->getById($id)
            ];
        } catch (Exception $e) {
            return ['success' => false, 'error' => 'خطأ في إعادة الكتاب: ' . $e->getMessage()];
        }
    }

    public function deleteAPI($id)
    {
        try {
            // الحصول على بيانات الاستعارة قبل الحذف
            $borrow = $this->borrowModel->getById($id);

            $result = $this->borrowModel->delete($id);
            return [
                'success' => true,
                'message' => 'تم حذف سجل الاستعارة بنجاح',
                'affected_rows' => $result,
                'deleted_data' => $borrow
            ];
        } catch (Exception $e) {
            return ['success' => false, 'error' => 'خطأ في حذف سجل الاستعارة: ' . $e->getMessage()];
        }
    }

    public function getOverdueAPI()
    {
        try {
            $overdueBorrows = $this->borrowModel->getOverdueBorrows();
            return ['success' => true, 'data' => $overdueBorrows, 'count' => count($overdueBorrows)];
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
    public function updateAPI($id, $data)
    {
        try {
            return [
                'success' => false,
                'error' => 'تحديث سجلات الاستعارة غير مدعوم حالياً'
            ];
        } catch (Exception $e) {
            return ['success' => false, 'error' => 'خطأ في التحديث: ' . $e->getMessage()];
        }
    }
}
