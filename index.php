<?php
// Front Controller
session_start();

// تحميل ملف المسارات
require_once 'config/paths.php';

// Autoloading for classes
spl_autoload_register(function ($class_name) {
    $directories = [
        MODELS_PATH . '/',
        CONTROLLERS_PATH . '/',
        TRAITS_PATH . '/',
        INTERFACES_PATH . '/',
        NOTIFICATIONS_PATH . '/'
    ];
    
    foreach ($directories as $directory) {
        $file = $directory . $class_name . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Error handling
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Route handling
$action = $_GET['action'] ?? 'home';

switch ($action) {
    case 'books':
        $controller = new BookController();
        $controller->index();
        break;
        
    case 'books_create':
        $controller = new BookController();
        $controller->create();
        break;
        
    case 'books_store':
        $controller = new BookController();
        $controller->store();
        break;
        
    case 'books_edit':
        $controller = new BookController();
        $controller->edit($_GET['id']);
        break;
        
    case 'books_update':
        $controller = new BookController();
        $controller->update($_GET['id']);
        break;
        
    case 'books_delete':
        $controller = new BookController();
        $controller->delete($_GET['id']);
        break;
        
    case 'users':
        $controller = new UserController();
        $controller->index();
        break;
        
    case 'users_create':
        $controller = new UserController();
        $controller->create();
        break;
        
    case 'users_store':
        $controller = new UserController();
        $controller->store();
        break;
        
    case 'users_edit':
        $controller = new UserController();
        $controller->edit($_GET['id']);
        break;
        
    case 'users_update':
        $controller = new UserController();
        $controller->update($_GET['id']);
        break;
        
    case 'users_delete':
        $controller = new UserController();
        $controller->delete($_GET['id']);
        break;
        
    case 'borrows':
        $controller = new BorrowController();
        $controller->index();
        break;
        
    case 'borrow_book':
        $controller = new BorrowController();
        $controller->borrow();
        break;
        
    case 'borrow_store':
        $controller = new BorrowController();
        $controller->store();
        break;
        
    case 'return_book':
        $controller = new BorrowController();
        $controller->returnBook($_GET['id']);
        break;
        
    case 'borrow_history':
        $controller = new BorrowController();
        $controller->history();
        break;
        
    default:
        // Home page 
        echo "<!DOCTYPE html>
        <html lang='ar' dir='rtl'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>نظام إدارة المكتبة</title>
            <style>
                * {
                    margin: 0;
                    padding: 0;
                    box-sizing: border-box;
                }
                
                body {
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    min-height: 100vh;
                    padding: 20px;
                    color: #333;
                }
                
                .container {
                    max-width: 1000px;
                    margin: 0 auto;
                    background: white;
                    border-radius: 15px;
                    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
                    overflow: hidden;
                }
                
                .header {
                    background: #2c3e50;
                    color: white;
                    padding: 30px;
                    text-align: center;
                }
                
                .header h1 {
                    font-size: 2.5em;
                    margin-bottom: 10px;
                }
                
                .header p {
                    opacity: 0.8;
                    font-size: 1.1em;
                }
                
                .content {
                    padding: 40px;
                }
                
                .section {
                    margin-bottom: 40px;
                }
                
                .section h2 {
                    color: #2c3e50;
                    border-bottom: 3px solid #3498db;
                    padding-bottom: 10px;
                    margin-bottom: 20px;
                    font-size: 1.8em;
                }
                
                .nav-grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                    gap: 20px;
                    margin-top: 20px;
                }
                
                .nav-card {
                    background: #f8f9fa;
                    border-radius: 10px;
                    padding: 25px;
                    text-align: center;
                    transition: transform 0.3s ease, box-shadow 0.3s ease;
                    border: 1px solid #e9ecef;
                }
                
                .nav-card:hover {
                    transform: translateY(-5px);
                    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
                    background: #e3f2fd;
                }
                
                .nav-card h3 {
                    color: #2c3e50;
                    margin-bottom: 15px;
                    font-size: 1.3em;
                }
                
                .nav-card p {
                    color: #6c757d;
                    margin-bottom: 20px;
                    line-height: 1.5;
                }
                
                .btn {
                    display: inline-block;
                    padding: 12px 25px;
                    background: #3498db;
                    color: white;
                    text-decoration: none;
                    border-radius: 25px;
                    transition: background 0.3s ease;
                    font-weight: 500;
                }
                
                .btn:hover {
                    background: #2980b9;
                }
                
                .stats-section {
                    background: #e8f4fd;
                    border-radius: 10px;
                    padding: 20px;
                    margin-top: 30px;
                }
                
                .stats-grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                    gap: 15px;
                    margin-top: 15px;
                }
                
                .stat-card {
                    background: white;
                    padding: 15px;
                    border-radius: 8px;
                    text-align: center;
                    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
                }
                
                .stat-number {
                    font-size: 2em;
                    font-weight: bold;
                    color: #3498db;
                    margin-bottom: 5px;
                }
                
                .stat-label {
                    color: #6c757d;
                    font-size: 0.9em;
                }
                
                @media (max-width: 768px) {
                    .nav-grid {
                        grid-template-columns: 1fr;
                    }
                    
                    .stats-grid {
                        grid-template-columns: 1fr 1fr;
                    }
                    
                    .header h1 {
                        font-size: 2em;
                    }
                    
                    .content {
                        padding: 20px;
                    }
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>📚 نظام إدارة المكتبة</h1>
                    <p>نظام متكامل لإدارة الكتب والمستخدمين والاستعارات</p>
                </div>
                
                <div class='content'>
                    <div class='section'>
                        <h2>🧭 التنقل السريع</h2>
                        <div class='nav-grid'>
                            <div class='nav-card'>
                                <h3>📖 إدارة الكتب</h3>
                                <p>عرض وإضافة وتعديل الكتب في المكتبة</p>
                                <a href='index.php?action=books' class='btn'>الدخول</a>
                            </div>
                            
                            <div class='nav-card'>
                                <h3>👥 إدارة المستخدمين</h3>
                                <p>إدارة مستخدمي النظام وإضافة مستخدمين جدد</p>
                                <a href='index.php?action=users' class='btn'>الدخول</a>
                            </div>
                            
                            <div class='nav-card'>
                                <h3>🔄 الاستعارات الحالية</h3>
                                <p>عرض وإدارة عمليات استعارة الكتب الجارية</p>
                                <a href='index.php?action=borrows' class='btn'>الدخول</a>
                            </div>
                            
                            <div class='nav-card'>
                                <h3>➕ استعارة جديدة</h3>
                                <p>تسجيل استعارة كتاب جديد للمستخدمين</p>
                                <a href='index.php?action=borrow_book' class='btn'>الدخول</a>
                            </div>
                            
                            <div class='nav-card'>
                                <h3>📋 سجل الاستعارات</h3>
                                <p>عرض التاريخ الكامل للاستعارات والإرجاعات</p>
                                <a href='index.php?action=borrow_history' class='btn'>الدخول</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class='section'>
                        <h2>📊 إحصائيات النظام</h2>
                        <div class='stats-section'>";
        
        try {
            // تحميل النماذج لعرض الإحصائيات
            $bookModel = new Book();
            $userModel = new User();
            $borrowModel = new Borrow();
            
            $total_books = count($bookModel->getAll());
            $total_users = count($userModel->getAll());
            $borrowed_books = count($borrowModel->getBorrowedBooks());
            $available_books = array_sum(array_column($bookModel->getAll(), 'available_copies'));
            
            echo "<div class='stats-grid'>
                    <div class='stat-card'>
                        <div class='stat-number'>$total_books</div>
                        <div class='stat-label'>إجمالي الكتب</div>
                    </div>
                    <div class='stat-card'>
                        <div class='stat-number'>$available_books</div>
                        <div class='stat-label'>كتب متاحة</div>
                    </div>
                    <div class='stat-card'>
                        <div class='stat-number'>$borrowed_books</div>
                        <div class='stat-label'>كتب مستعارة</div>
                    </div>
                    <div class='stat-card'>
                        <div class='stat-number'>$total_users</div>
                        <div class='stat-label'>مستخدمين</div>
                    </div>
                </div>";
                
        } catch (Exception $e) {
            echo "<p style='color: red; text-align: center;'>تعذر تحميل الإحصائيات: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
        
        echo "</div>
                </div>
            </div>
        </body>
        </html>";
        break;
}
?>