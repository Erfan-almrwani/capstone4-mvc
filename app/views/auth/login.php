<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول</title>
<link rel="stylesheet" href="/assets/css/style.css"></head>
<body>
    <div class="container">
        <h2>تسجيل الدخول</h2>
        
        <?php if (!empty($data['error'])): ?>
            <div class="error">
                <?php echo $data['error']; ?>
            </div>
        <?php endif; ?>
        
        <form action="<?php echo URLROOT; ?>/auth/login" method="post">
            <div class="form-group">
                <label for="email">البريد الإلكتروني:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($data['email'] ?? ''); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="password">كلمة المرور:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit">تسجيل الدخول</button>
        </form>
        
        <p>ليس لديك حساب؟ <a href="<?php echo URLROOT; ?>/auth/register">إنشاء حساب</a></p>
    </div>
</body>
</html>