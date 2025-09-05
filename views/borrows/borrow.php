<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>استعارة كتاب - نظام المكتبة</title>
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
        select, input {
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
        <h1>استعارة كتاب</h1>
        
        <?php if (isset($_GET['error'])): ?>
            <div style="color: red; padding: 10px; background: #fbe7e7; margin-bottom: 15px;">
                <?= htmlspecialchars($_GET['error']) ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="index.php?action=borrow_store">
            <div class="form-group">
                <label>المستخدم:</label>
                <select name="user_id" required>
                    <option value="">اختر المستخدم</option>
                    <?php foreach ($users as $user): ?>
                    <option value="<?= $user['id'] ?>"><?= htmlspecialchars($user['name']) ?> - <?= htmlspecialchars($user['email']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label>الكتاب:</label>
                <select name="book_id" required>
                    <option value="">اختر الكتاب</option>
                    <?php foreach ($books as $book): ?>
                    <?php if ($book['available_copies'] > 0): ?>
                    <option value="<?= $book['id'] ?>"><?= htmlspecialchars($book['title']) ?> - <?= htmlspecialchars($book['author']) ?> (متاح: <?= $book['available_copies'] ?>)</option>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label>تاريخ الاستحقاق:</label>
                <input type="date" name="due_date" required min="<?= date('Y-m-d', strtotime('+1 day')) ?>">
            </div>
            
            <button type="submit" class="btn">تأكيد الاستعارة</button>
            <a href="index.php?action=borrows" class="btn btn-danger">إلغاء</a>
        </form>
    </div>
</body>
</html>