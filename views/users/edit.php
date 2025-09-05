<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل مستخدم - نظام المكتبة</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input, textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .btn {
            padding: 10px 15px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 10px;
        }
        .btn-danger {
            background: #e74c3c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>تعديل مستخدم</h1>
        
        <?php if (isset($_GET['error'])): ?>
            <div style="color: red; padding: 10px; background: #fbe7e7; margin-bottom: 15px;">
                <?= htmlspecialchars($_GET['error']) ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="index.php?action=users_update&id=<?= $user['id'] ?>">
            <div class="form-group">
                <label>الاسم:</label>
                <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
            </div>
            
            <div class="form-group">
                <label>البريد الإلكتروني:</label>
                <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>
            
            <div class="form-group">
                <label>الهاتف:</label>
                <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>">
            </div>
            
            <div class="form-group">
                <label>العنوان:</label>
                <textarea name="address" rows="3"><?= htmlspecialchars($user['address']) ?></textarea>
            </div>
            
            <button type="submit" class="btn">حفظ التعديلات</button>
            <a href="index.php?action=users" class="btn btn-danger">إلغاء</a>
        </form>
    </div>
</body>
</html>