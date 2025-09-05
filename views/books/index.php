<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة الكتب - نظام المكتبة</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
            color: #333;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 12px;
            text-align: right;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #3498db;
            color: white;
        }
        .btn {
            display: inline-block;
            padding: 8px 16px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin: 5px;
        }
        .btn-success {
            background-color: #2ecc71;
        }
        .btn-danger {
            background-color: #e74c3c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>إدارة الكتب</h1>
        
        <?php if (isset($_GET['message'])): ?>
            <div style="color: green; padding: 10px; background: #eaf7ea; margin-bottom: 15px;">
                <?= htmlspecialchars($_GET['message']) ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_GET['error'])): ?>
            <div style="color: red; padding: 10px; background: #fbe7e7; margin-bottom: 15px;">
                <?= htmlspecialchars($_GET['error']) ?>
            </div>
        <?php endif; ?>
        
        <a href="index.php?action=books_create" class="btn btn-success">إضافة كتاب جديد</a>
        
        <table>
            <thead>
                <tr>
                    <th>العنوان</th>
                    <th>المؤلف</th>
                    <th>سنة النشر</th>
                    <th>النسخ المتاحة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($books as $book): ?>
                <tr>
                    <td><?= htmlspecialchars($book['title']) ?></td>
                    <td><?= htmlspecialchars($book['author']) ?></td>
                    <td><?= htmlspecialchars($book['published_year']) ?></td>
                    <td><?= htmlspecialchars($book['available_copies']) ?> / <?= htmlspecialchars($book['total_copies']) ?></td>
                    <td>
                        <a href="index.php?action=books_edit&id=<?= $book['id'] ?>" class="btn">تعديل</a>
                        <a href="index.php?action=books_delete&id=<?= $book['id'] ?>" class="btn btn-danger" onclick="return confirm('هل أنت متأكد من الحذف؟')">حذف</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>