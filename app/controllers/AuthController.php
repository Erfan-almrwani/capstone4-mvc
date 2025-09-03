<?php
namespace App\Controllers;

use App\Models\User;

class AuthController extends BaseController {
    private $userModel;

    public function __construct() {
        parent::__construct();
        $this->userModel = new User();
    }

    public function login() {
        if ($this->isLoggedIn()) {
            $this->redirect('home/index');
        }

        $data = [
            'error' => ''
        ];
        $this->view('auth/login', $data);
    }

    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            $user = $this->userModel->login($email, $password);
            
            if ($user) {
                $this->session->set('user_id', $user->id);
                $this->session->set('user_name', $user->name);
                $this->session->set('user_email', $user->email);
                
                $this->redirect('home/index');
            } else {
                $data = [
                    'error' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة'
                ];
                $this->view('auth/login', $data);
            }
        }
    }

    public function register() {
        if ($this->isLoggedIn()) {
            $this->redirect('home/index');
        }

        $data = [
            'errors' => []
        ];
        $this->view('auth/register', $data);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'name' => $_POST['name'] ?? '',
                'email' => $_POST['email'] ?? '',
                'password' => $_POST['password'] ?? '',
                'confirm_password' => $_POST['confirm_password'] ?? ''
            ];
            
            // التحقق من صحة البيانات
            $errors = $this->validateRegistration($data);
            
            if (empty($errors)) {
                // إزالة confirm_password من البيانات قبل الحفظ
                unset($data['confirm_password']);
                
                if ($this->userModel->register($data)) {
                    $this->redirect('auth/login');
                } else {
                    $errors[] = 'حدث خطأ أثناء التسجيل';
                    $this->view('auth/register', ['errors' => $errors]);
                }
            } else {
                $this->view('auth/register', ['errors' => $errors]);
            }
        }
    }

    private function validateRegistration($data) {
        $errors = [];
        
        if (empty($data['name'])) {
            $errors[] = 'الاسم مطلوب';
        }
        
        if (empty($data['email'])) {
            $errors[] = 'البريد الإلكتروني مطلوب';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'صيغة البريد الإلكتروني غير صحيحة';
        } elseif ($this->userModel->findByEmail($data['email'])) {
            $errors[] = 'البريد الإلكتروني مستخدم بالفعل';
        }
        
        if (empty($data['password'])) {
            $errors[] = 'كلمة المرور مطلوبة';
        } elseif (strlen($data['password']) < 6) {
            $errors[] = 'كلمة المرور يجب أن تكون على الأقل 6 أحرف';
        }
        
        if ($data['password'] !== $data['confirm_password']) {
            $errors[] = 'كلمات المرور غير متطابقة';
        }
        
        return $errors;
    }

public function logout() {
    $this->session->remove('user_id');
    $this->session->remove('user_name');
    $this->session->remove('user_email');
    $this->session->destroy();
    
    $this->redirect('auth/login');
}
    
}
?>