<?php
namespace App\Controllers;

use App\Models\User;

class UsersController extends BaseController {
    private $userModel;
    
    public function __construct() {
        parent::__construct();
        $this->userModel = new User();
    }
    
    public function index() {
        // التحقق من تسجيل الدخول
        $this->requireLogin();
        
        // جلب بيانات المستخدمين من قاعدة البيانات
        $users = $this->userModel->getUsers();
        
        $data = [
            'title' => 'إدارة المستخدمين',
            'users' => $users
        ];
        
        $this->view('users/index', $data);
    }
}
?>