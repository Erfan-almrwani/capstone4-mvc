<?php
namespace App\Core;

class Request {
    public function getUrl() {
        // الحصول على URL من query parameter
        $url = $_GET['url'] ?? '';
        
        // إذا كان URL فارغاً، حاول الحصول من PATH_INFO
        if (empty($url) && isset($_SERVER['PATH_INFO'])) {
            $url = ltrim($_SERVER['PATH_INFO'], '/');
        }
        
        // إذا كان لا يزال فارغاً، حاول من REQUEST_URI
        if (empty($url) && isset($_SERVER['REQUEST_URI'])) {
            $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $url = ltrim($url, '/');
            
            // إزالة public/ إذا existed
            if (strpos($url, 'public/') === 0) {
                $url = substr($url, 7);
            }
        }
        
        return rtrim($url, '/');
    }

    public function getMethod() {
        $method = $_SERVER['REQUEST_METHOD'];
        return $method;
    }

    public function isPost() {
        return $this->getMethod() === 'POST';
    }

    public function isGet() {
        return $this->getMethod() === 'GET';
    }
}
?>