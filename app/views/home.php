<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['title']; ?></title>
<link rel="stylesheet" href="/assets/css/style.css"></head>
<body>
    <div class="container">
        <h1>تطبيق وفق هيكل MVC</h1>
        
        <div class="welcome">
            <h2><?php echo $data['welcome']; ?></h2>
            <p>مرحباً <?php echo htmlspecialchars($data['user_name']); ?>!</p>
        </div>
        
        <div class="menu">
            <a href="<?php echo URLROOT; ?>/users/index">عرض المستخدمين</a>
            <a href="<?php echo URLROOT; ?>/auth/logout">تسجيل الخروج</a>
        </div>
    </div>
</body>
</html>