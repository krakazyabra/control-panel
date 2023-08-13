<?php
session_start();
require_once '../functions.php';

// Проверка авторизации пользователя
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header('Location: /');
    exit();
}

renderHeader("Настройки аккаунта");
?>

<?php
renderFooter();
?>
