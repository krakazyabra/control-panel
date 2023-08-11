<?php
session_start();

$request = $_SERVER['REQUEST_URI']; // Получаем URI

switch ($request) {
    case '':
    case '/':
        require __DIR__ . '/home.php';
        break;
    case '/client':
        require __DIR__ . '/client/index.php';
        break;
    case '/client/settings':
        require __DIR__ . '/client/settings/index.php';
        break;
    case 'logout':
    case '/client/logout':
        require __DIR__ . '/logout.php';
        break;
    // ... другие пути и их соответствующие файлы
    default:
        // Можете обработать 404 ошибку, например:
        header("HTTP/1.0 404 Not Found");
        require __DIR__ . '/404.php';
        break;
}
?>