<?php
session_start();
require_once 'functions.php';

// Проверка, авторизован ли пользователь. Если нет - редирект на главную страницу
if (!isset($_SESSION['authenticated']) || !$_SESSION['authenticated']) {
    header('Location: /');
    exit;
}

renderHeader("Панель управления");
?>

<div class="container mt-5">
    <div class="row">
        <!-- Левое меню -->
        <div class="col-md-2 left-menu">
            <?php displayLeftMenu(); ?>
        </div>
        <!-- Основной контент -->
        <div class="col-md-9 ms-3">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    <h2 class="card-title">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></h2>
                    <p class="card-text">Your client details and actions can be managed here.</p>
                    <!-- Можете добавить дополнительные детали или действия для пользователя -->
                </div>
            </div>
        </div>
    </div>
</div>

<?php
renderFooter();
?>
