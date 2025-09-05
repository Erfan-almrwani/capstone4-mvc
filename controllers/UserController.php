<?php
// controllers/UserController.php

// تحميل ملف المسارات أولاً
require_once __DIR__ . '/../config/paths.php';

// ثم تحميل الملفات الأخرى باستخدام الثوابت المعرفة
require_once MODELS_PATH . '/Database.php';
require_once MODELS_PATH . '/User.php';

class UserController {
    private $userModel;
    
    public function __construct() {
        $this->userModel = new User();
    }
    
    public function index() {
        $users = $this->userModel->getAll();
        require_once VIEWS_PATH . '/users/index.php';
    }
    
    public function create() {
        require_once VIEWS_PATH . '/users/create.php';
    }
    
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                ':name' => $_POST['name'],
                ':email' => $_POST['email'],
                ':phone' => $_POST['phone'],
                ':address' => $_POST['address']
            ];
            
            try {
                $this->userModel->create($data);
                header('Location: index.php?action=users&message=تم إضافة المستخدم بنجاح');
                exit;
            } catch (Exception $e) {
                header('Location: index.php?action=users_create&error=خطأ في إضافة المستخدم');
                exit;
            }
        }
    }
    
    public function edit($id) {
        $user = $this->userModel->getById($id);
        require_once VIEWS_PATH . '/users/edit.php';
    }
    
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                ':name' => $_POST['name'],
                ':email' => $_POST['email'],
                ':phone' => $_POST['phone'],
                ':address' => $_POST['address']
            ];
            
            try {
                $this->userModel->update($id, $data);
                header('Location: index.php?action=users&message=تم تحديث المستخدم بنجاح');
                exit;
            } catch (Exception $e) {
                header('Location: index.php?action=users_edit&id=' . $id . '&error=خطأ في تحديث المستخدم');
                exit;
            }
        }
    }
    
    public function delete($id) {
        try {
            $this->userModel->delete($id);
            header('Location: index.php?action=users&message=تم حذف المستخدم بنجاح');
            exit;
        } catch (Exception $e) {
            header('Location: index.php?action=users&error=خطأ في حذف المستخدم');
            exit;
        }
    }

    // ==================== API METHODS ====================
    
    public function getAllAPI() {
        try {
            $users = $this->userModel->getAll();
            return ['success' => true, 'data' => $users, 'count' => count($users)];
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
    
    public function getByIdAPI($id) {
        try {
            $user = $this->userModel->getById($id);
            if ($user) {
                return ['success' => true, 'data' => $user];
            } else {
                return ['success' => false, 'error' => 'المستخدم غير موجود'];
            }
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
    
    public function createAPI($data) {
        try {
            $formattedData = [
                ':name' => $data['name'],
                ':email' => $data['email'],
                ':phone' => $data['phone'],
                ':address' => $data['address']
            ];
            
            $id = $this->userModel->create($formattedData);
            return [
                'success' => true, 
                'message' => 'تم إضافة المستخدم بنجاح', 
                'id' => $id,
                'data' => $this->userModel->getById($id)
            ];
        } catch (Exception $e) {
            return ['success' => false, 'error' => 'خطأ في إضافة المستخدم: ' . $e->getMessage()];
        }
    }
    
    public function updateAPI($id, $data) {
        try {
            $formattedData = [
                ':name' => $data['name'],
                ':email' => $data['email'],
                ':phone' => $data['phone'],
                ':address' => $data['address']
            ];
            
            $result = $this->userModel->update($id, $formattedData);
            return [
                'success' => true, 
                'message' => 'تم تحديث المستخدم بنجاح', 
                'affected_rows' => $result,
                'data' => $this->userModel->getById($id)
            ];
        } catch (Exception $e) {
            return ['success' => false, 'error' => 'خطأ في تحديث المستخدم: ' . $e->getMessage()];
        }
    }
    
    public function deleteAPI($id) {
        try {
            // الحصول على بيانات المستخدم قبل الحذف
            $user = $this->userModel->getById($id);
            
            $result = $this->userModel->delete($id);
            return [
                'success' => true, 
                'message' => 'تم حذف المستخدم بنجاح', 
                'affected_rows' => $result,
                'deleted_data' => $user
            ];
        } catch (Exception $e) {
            return ['success' => false, 'error' => 'خطأ في حذف المستخدم: ' . $e->getMessage()];
        }
    }
    
    public function searchAPI($searchTerm) {
        try {
            $users = $this->userModel->searchUsers($searchTerm);
            return ['success' => true, 'data' => $users, 'count' => count($users)];
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
?>