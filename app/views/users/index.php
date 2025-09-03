<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['title']; ?></title>
<link rel="stylesheet" href="/assets/css/style.css"></head>
<body>
    <div class="container">
        <h1><?php echo $data['title']; ?></h1>
        
        <?php if (!empty($data['users'])) : ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>الاسم</th>
                        <th>البريد الإلكتروني</th>
                        <th>تاريخ التسجيل</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['users'] as $user) : ?>
                        <tr>
                            <td><?php echo $user->id; ?></td>
                            <td><?php echo htmlspecialchars($user->name); ?></td>
                            <td><?php echo htmlspecialchars($user->email); ?></td>
                            <td><?php echo $user->created_at; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>لا يوجد مستخدمين لعرضهم</p>
        <?php endif; ?>
        
        <a href="<?php echo URLROOT; ?>/home/index" class="back-link">العودة إلى الرئيسية</a>
    </div>
</body>
</html>