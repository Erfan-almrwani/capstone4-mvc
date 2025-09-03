<?php
namespace App\Controllers;

class HomeController extends BaseController {
    public function index() {
        // التحقق من تسجيل الدخول
        if (!$this->isLoggedIn()) {
            $this->redirect('auth/login');
            return;
        }
        
        $data = [
            'title' => 'الصفحة الرئيسية',
            'welcome' => 'مرحباً بك في تطبيقنا',
            'user_name' => $this->session->get('user_name') ?? 'زائر' 
        ];
        
        $this->view('home', $data);
    }
}
?>