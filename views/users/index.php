<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة المستخدمين - نظام المكتبة</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; margin: 0; padding: 20px; background-color: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { padding: 12px; text-align: right; border-bottom: 1px solid #ddd; }
        th { background-color: #3498db; color: white; }
        .btn { display: inline-block; padding: 8px 16px; background-color: #3498db; color: white; text-decoration: none; border-radius: 4px; margin: 5px; }
        .btn-success { background-color: #2ecc71; }
        .btn-danger { background-color: #e74c3c; }
    </style>
</head>
<body>
    <div class="container">
        <h1>إدارة المستخدمين</h1>
        
        <a href="index.php?action=users_create" class="btn btn-success">إضافة مستخدم جديد</a>
        
        <table>
            <thead>
                <tr>
                    <th>الاسم</th>
                    <th>البريد الإلكتروني</th>
                    <th>الهاتف</th>
                    <th>العنوان</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['name']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['phone']) ?></td>
                    <td><?= htmlspecialchars($user['address']) ?></td>
                    <td>
                        <a href="index.php?action=users_edit&id=<?= $user['id'] ?>" class="btn">تعديل</a>
                        <a href="index.php?action=users_delete&id=<?= $user['id'] ?>" class="btn btn-danger" onclick="return confirm('هل أنت متأكد من الحذف؟')">حذف</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>