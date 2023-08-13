<?php

function renderHeader($pageTitle)
{
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
            <?php echo htmlspecialchars($pageTitle); ?>
        </title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
        <!-- Подключаем Bootstrap JS и jquery -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
            integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
            integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
            crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    </head>

    <body>
        <?php
        displayMainMenu();
}

function displayMainMenu()
{
    ?>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <!-- Первый элемент: navbar-brand -->
            <div class="col-lg-2 d-flex justify-content-center align-items-center">
                <a class="navbar-brand" href="/client">Cloud</a>
            </div>

            <!-- Второй элемент: Дашборд и Messages -->
            <div class="col-lg-8 text-center">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 justify-content-center">
                    <li class="nav-item">
                        <a class="nav-link" href="/client/dashboard">Дашборд</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/client/messages">Messages</a>
                    </li>
                </ul>
            </div>

            <!-- Третий элемент: имя пользователя -->
            <div class="col-lg-2 d-flex justify-content-center align-items-center">
                <div class="dropdown">
                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo htmlspecialchars($_SESSION['username']); ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
                        <li><a class="dropdown-item" href="/client/settings/edit.php">Edit Profile</a></li>
                        <li><a class="dropdown-item" href="/logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <script>
            let dropdowns = document.querySelectorAll('.dropdown-toggle')
            dropdowns.forEach((dd) => {
                dd.addEventListener('click', function (e) {
                    e.stopPropagation(); // Добавлено, чтобы предотвратить закрытие меню при клике на него
                    var el = this.nextElementSibling
                    el.style.display = el.style.display === 'block' ? 'none' : 'block'
                })
            });

            document.body.addEventListener('click', function (e) {
                if (!e.target.matches('.dropdown-toggle')) {
                    let dropdowns = document.querySelectorAll('.dropdown-menu');
                    dropdowns.forEach(function (dropdown) {
                        dropdown.style.display = 'none';
                    });
                }
            });
        </script>
        <?php
}

function displayLeftMenu()
{
    $service_id = "123";
    ?>
        <ul class="list-unstyled">
            <li class="text-nowrap mb-2"><i class="fas fa-wrench"></i> Сервис
                <?php echo htmlspecialchars($service_id); ?>
            </li>
            <li class="text-nowrap mb-2"><a href="/client/services/add.php"><i class="fas fa-plus-square"></i> Добавить сервис</a></li>
            <hr>
            <li class="text-nowrap mb-2"><i class="fas fa-cloud"></i> Облачные серверы</li>
            <li class="text-nowrap mb-2"><i class="fas fa-server"></i> Выделенные серверы</li>
            <hr>
            <li class="text-nowrap mb-2"><i class="fas fa-book"></i> Документация</li>
        </ul>
        <?php
}

function renderFooter()
{
    ?>
    </body>

    </html>
    <?php
}

?>