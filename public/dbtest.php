<?php
require_once '../config/database.php';

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "تم الاتصال بقاعدة البيانات بنجاح!<br>";
    
    // اختبار استعلام
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
    $result = $stmt->fetch();
    echo "عدد المستخدمين: " . $result['count'];
} catch (PDOException $e) {
    echo "خطأ في الاتصال: " . $e->getMessage();
}
?>