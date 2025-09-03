<?php
require_once 'vendor/autoload.php';
require_once 'config/database.php';

use App\Core\Database;

try {
    $db = new Database();
    echo "اتصال ناجح بقاعدة البيانات!<br>";
    
    // اختبار استعلام
    $db->query("SELECT * FROM users");
    $users = $db->resultSet();
    echo "عدد المستخدمين: " . count($users);
} catch (Exception $e) {
    echo "خطأ في الاتصال: " . $e->getMessage();
}
?>