<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة كتاب - نظام المكتبة</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; margin: 0; padding: 20px; background-color: #f5f5f5; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, textarea { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        .btn { padding: 10px 15px; background: #3498db; color: white; border: none; border-radius: 4px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="container">
        <h1>إضافة كتاب جديد</h1>
        
        <form method="POST" action="index.php?action=books_store">
            <div class="form-group">
                <label>العنوان:</label>
                <input type="text" name="title" required>
            </div>
            
            <div class="form-group">
                <label>المؤلف:</label>
                <input type="text" name="author" required>
            </div>
            
            <div class="form-group">
                <label>رقم ISBN:</label>
                <input type="text" name="isbn" required>
            </div>
            
            <div class="form-group">
                <label>سنة النشر:</label>
                <input type="number" name="published_year" required>
            </div>
            
            <div class="form-group">
                <label>عدد النسخ:</label>
                <input type="number" name="total_copies" required>
            </div>
            
            <button type="submit" class="btn">حفظ</button>
            <a href="index.php?action=books" class="btn">رجوع</a>
        </form>
    </div>
</body>
</html>