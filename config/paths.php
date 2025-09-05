<?php
// config/paths.php

// المسار الجذري للمشروع
define('ROOT_PATH', dirname(__DIR__));

// مسارات المجلدات
define('MODELS_PATH', ROOT_PATH . '/models');
define('CONTROLLERS_PATH', ROOT_PATH . '/controllers');
define('VIEWS_PATH', ROOT_PATH . '/views');
define('TRAITS_PATH', ROOT_PATH . '/traits');
define('INTERFACES_PATH', ROOT_PATH . '/interfaces');
define('NOTIFICATIONS_PATH', ROOT_PATH . '/notifications');
define('CONFIG_PATH', ROOT_PATH . '/config');

// مسار URL الأساسي (للاستخدام في الروابط)
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];
$script_path = dirname($_SERVER['SCRIPT_NAME']);
define('BASE_URL', $protocol . "://" . $host . $script_path);
?>