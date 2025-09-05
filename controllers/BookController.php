<?php
// controllers/BookController.php

// تحميل ملف المسارات أولاً
require_once __DIR__ . '/../config/paths.php';

// ثم تحميل الملفات الأخرى باستخدام الثوابت المعرفة
require_once MODELS_PATH . '/Database.php';
require_once MODELS_PATH . '/Book.php';

class BookController {
    private $bookModel;
    
    public function __construct() {
        $this->bookModel = new Book();
    }
    
    public function index() {
        $books = $this->bookModel->getAll();
        require_once VIEWS_PATH . '/books/index.php';
    }
    
    public function create() {
        require_once VIEWS_PATH . '/books/create.php';
    }
    
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                ':title' => $_POST['title'],
                ':author' => $_POST['author'],
                ':isbn' => $_POST['isbn'],
                ':published_year' => $_POST['published_year'],
                ':total_copies' => $_POST['total_copies'],
                ':available_copies' => $_POST['total_copies'] // Initially all copies are available
            ];
            
            try {
                $this->bookModel->create($data);
                header('Location: index.php?action=books&message=تم إضافة الكتاب بنجاح');
                exit;
            } catch (Exception $e) {
                header('Location: index.php?action=books_create&error=خطأ في إضافة الكتاب');
                exit;
            }
        }
    }
    
    public function edit($id) {
        $book = $this->bookModel->getById($id);
        require_once VIEWS_PATH . '/books/edit.php';
    }
    
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                ':title' => $_POST['title'],
                ':author' => $_POST['author'],
                ':isbn' => $_POST['isbn'],
                ':published_year' => $_POST['published_year'],
                ':total_copies' => $_POST['total_copies'],
                ':available_copies' => $_POST['available_copies']
            ];
            
            try {
                $this->bookModel->update($id, $data);
                header('Location: index.php?action=books&message=تم تحديث الكتاب بنجاح');
                exit;
            } catch (Exception $e) {
                header('Location: index.php?action=books_edit&id=' . $id . '&error=خطأ في تحديث الكتاب');
                exit;
            }
        }
    }
    
    public function delete($id) {
        try {
            $this->bookModel->delete($id);
            header('Location: index.php?action=books&message=تم حذف الكتاب بنجاح');
            exit;
        } catch (Exception $e) {
            header('Location: index.php?action=books&error=خطأ في حذف الكتاب');
            exit;
        }
    }
    
    
    public function getAllAPI() {
        try {
            $books = $this->bookModel->getAll();
            return ['success' => true, 'data' => $books, 'count' => count($books)];
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
    
    public function getByIdAPI($id) {
        try {
            $book = $this->bookModel->getById($id);
            if ($book) {
                return ['success' => true, 'data' => $book];
            } else {
                return ['success' => false, 'error' => 'الكتاب غير موجود'];
            }
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
    
    public function createAPI($data) {
        try {
            $formattedData = [
                ':title' => $data['title'],
                ':author' => $data['author'],
                ':isbn' => $data['isbn'],
                ':published_year' => $data['published_year'],
                ':total_copies' => $data['total_copies'],
                ':available_copies' => $data['total_copies']
            ];
            
            $id = $this->bookModel->create($formattedData);
            return [
                'success' => true, 
                'message' => 'تم إضافة الكتاب بنجاح', 
                'id' => $id,
                'data' => $this->bookModel->getById($id)
            ];
        } catch (Exception $e) {
            return ['success' => false, 'error' => 'خطأ في إضافة الكتاب: ' . $e->getMessage()];
        }
    }
    
    public function updateAPI($id, $data) {
        try {
            $formattedData = [
                ':title' => $data['title'],
                ':author' => $data['author'],
                ':isbn' => $data['isbn'],
                ':published_year' => $data['published_year'],
                ':total_copies' => $data['total_copies'],
                ':available_copies' => $data['available_copies']
            ];
            
            $result = $this->bookModel->update($id, $formattedData);
            return [
                'success' => true, 
                'message' => 'تم تحديث الكتاب بنجاح', 
                'affected_rows' => $result,
                'data' => $this->bookModel->getById($id)
            ];
        } catch (Exception $e) {
            return ['success' => false, 'error' => 'خطأ في تحديث الكتاب: ' . $e->getMessage()];
        }
    }
    
    public function deleteAPI($id) {
        try {
            // الحصول على بيانات الكتاب قبل الحذف
            $book = $this->bookModel->getById($id);
            
            $result = $this->bookModel->delete($id);
            return [
                'success' => true, 
                'message' => 'تم حذف الكتاب بنجاح', 
                'affected_rows' => $result,
                'deleted_data' => $book
            ];
        } catch (Exception $e) {
            return ['success' => false, 'error' => 'خطأ في حذف الكتاب: ' . $e->getMessage()];
        }
    }
    
    public function searchAPI($searchTerm) {
        try {
            $books = $this->bookModel->searchBooks($searchTerm);
            return ['success' => true, 'data' => $books, 'count' => count($books)];
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
?>