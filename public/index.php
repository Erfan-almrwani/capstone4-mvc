<?php
// تحميل autoload من Composer
require_once __DIR__ . '/../vendor/autoload.php';

// بدء الجلسة
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// تعريف الثوابت 
define('ROOT', dirname(__DIR__));
define('URLROOT', 'http://localhost:8000'); 

// تحميل إعدادات قاعدة البيانات
require_once ROOT . '/config/database.php';

// تهيئة التطبيق
$app = new App\Core\App();
$app->run();
?>