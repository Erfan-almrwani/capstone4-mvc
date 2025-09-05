<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الاستعارات الحالية - نظام المكتبة</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 1400px;
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
        .btn-warning {
            background-color: #f39c12;
        }
        .late {
            color: #e74c3c;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>الاستعارات الحالية</h1>
        
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
        
        <a href="index.php?action=borrow_book" class="btn btn-success">استعارة جديدة</a>
        <a href="index.php?action=borrow_history" class="btn">سجل الاستعارات</a>
        
        <table>
            <thead>
                <tr>
                    <th>المستخدم</th>
                    <th>الكتاب</th>
                    <th>تاريخ الاستعارة</th>
                    <th>تاريخ الاستحقاق</th>
                    <th>الحالة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($borrowedBooks as $borrow): ?>
                <?php
                    $dueDate = new DateTime($borrow['due_date']);
                    $today = new DateTime();
                    $isLate = $today > $dueDate;
                ?>
                <tr>
                    <td><?= htmlspecialchars($borrow['user_name']) ?></td>
                    <td><?= htmlspecialchars($borrow['book_title']) ?></td>
                    <td><?= htmlspecialchars($borrow['borrow_date']) ?></td>
                    <td class="<?= $isLate ? 'late' : '' ?>">
                        <?= htmlspecialchars($borrow['due_date']) ?>
                        <?= $isLate ? ' (متأخر)' : '' ?>
                    </td>
                    <td><?= htmlspecialchars($borrow['status']) ?></td>
                    <td>
                        <a href="index.php?action=return_book&id=<?= $borrow['id'] ?>" class="btn">إعادة الكتاب</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>