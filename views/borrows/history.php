<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سجل الاستعارات - نظام المكتبة</title>
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
        .late-fee {
            color: #e74c3c;
            font-weight: bold;
        }
        .returned {
            color: #2ecc71;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>سجل الاستعارات</h1>
        
        <a href="index.php?action=borrows" class="btn">الاستعارات الحالية</a>
        
        <table>
            <thead>
                <tr>
                    <th>المستخدم</th>
                    <th>الكتاب</th>
                    <th>تاريخ الاستعارة</th>
                    <th>تاريخ الاستحقاق</th>
                    <th>تاريخ الإعادة</th>
                    <th>الحالة</th>
                    <th>الغرامة</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($borrowHistory as $borrow): ?>
                <tr>
                    <td><?= htmlspecialchars($borrow['user_name']) ?></td>
                    <td><?= htmlspecialchars($borrow['book_title']) ?></td>
                    <td><?= htmlspecialchars($borrow['borrow_date']) ?></td>
                    <td><?= htmlspecialchars($borrow['due_date']) ?></td>
                    <td><?= htmlspecialchars($borrow['return_date'] ?? 'لم يتم الإعادة بعد') ?></td>
                    <td class="<?= $borrow['status'] === 'returned' ? 'returned' : '' ?>">
                        <?= htmlspecialchars($borrow['status']) ?>
                    </td>
                    <td class="late-fee"><?= htmlspecialchars($borrow['late_fee']) ?> $</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>