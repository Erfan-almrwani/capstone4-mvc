<?php
namespace App\Controllers;

use App\Core\Session;

class BaseController {
    protected $session;

    public function __construct() {
        $this->session = new Session();
    }

    protected function view($view, $data = []) {
        extract($data);
        
        $viewPath = '../app/views/' . $view . '.php';
        
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            throw new \Exception("View file {$viewPath} not found");
        }
    }

    protected function redirect($url) {
        header("Location: " . URLROOT . "/{$url}");
        exit;
    }

    protected function isLoggedIn() {
        return $this->session->get('user_id') !== null;
    }

    protected function requireLogin() {
        if (!$this->isLoggedIn()) {
            $this->redirect('auth/login');
            exit;
        }
    }
}
?>