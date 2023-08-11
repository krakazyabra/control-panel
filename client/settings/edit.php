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

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form id="editForm">
                <div class="form-group mb-3">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="form-group mb-3">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" name="username" disabled>
                </div>
                <div class="form-group mb-3">
                    <label for="creationDate">Account Creation Date:</label>
                    <input type="text" class="form-control" name="creationDate" disabled>
                </div>
                <div class="form-group mb-3">
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                        data-bs-target="#changePasswordModal">Change Password</button>
                </div>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
            <div class="mt-3" id="message"></div>
        </div>
    </div>

    <!-- Modal for password change -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="changePasswordForm">
                        <div class="form-group mb-3">
                            <label for="currentPassword">Current Password:</label>
                            <input type="password" class="form-control" name="currentPassword" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="newPassword">New Password:</label>
                            <input type="password" class="form-control" name="newPassword" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="confirmPassword">Confirm New Password:</label>
                            <input type="password" class="form-control" name="confirmPassword" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Change Password</button>
                    </form>
                    <div class="mt-3" id="passwordMessage"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // Запрос данных пользователя при загрузке страницы
            $.ajax({
                type: "POST",
                url: "/router.php",
                data: {
                    action: 'getUserData',
                    username: '<?php echo $_SESSION['username']; ?>'
                },
                dataType: 'json'
            }).done(function (data) {
                if (data) {
                    $('input[name="email"]').val(data.email);
                    $('input[name="username"]').val(data.username);
                    $('input[name="creationDate"]').val(data.date_joined);
                } else {
                    $('#message').text('Unable to fetch user data.').addClass('alert alert-danger');
                }
            }).fail(function () {
                $('#message').text('Error during the request. Try again later.').addClass('alert alert-danger');
            });

            // Обработка отправки формы
            $('#editForm').on('submit', function (e) {
                e.preventDefault();

                $.ajax({
                    type: "POST",
                    url: "/router.php",
                    data: {
                        action: 'updateSettings',  // Добавьте это
                        email: $('input[name="email"]').val(),  // И это
                        username: '<?php echo $_SESSION['username']; ?>'
                    },
                    dataType: 'json'
                }).done(function (data) {
                    if (data.status === 'success') {
                        $('#message').text(data.message).removeClass('alert-danger').addClass('alert alert-success');
                    } else {
                        $('#message').text(data.message).removeClass('alert-success').addClass('alert alert-danger');
                    }
                }).fail(function () {
                    $('#message').text('Error during the request. Try again later.').removeClass('alert-success').addClass('alert alert-danger');
                });
            });

            // Handling the change password form submission
            $('#changePasswordForm').on('submit', function (e) {
                e.preventDefault();

                // Basic client-side check to ensure passwords match
                if ($('input[name="newPassword"]').val() !== $('input[name="confirmPassword"]').val()) {
                    $('#passwordMessage').text('Passwords do not match!').addClass('alert alert-danger');
                    return;
                }

                $.ajax({
                    type: "POST",
                    url: "/router.php",
                    data: {
                        action: 'changePassword',
                        username: '<?php echo $_SESSION['username']; ?>',
                        currentPassword: $('input[name="currentPassword"]').val(),
                        newPassword: $('input[name="newPassword"]').val()
                    },
                    dataType: 'json'
                }).done(function (data) {
                    if (data.status === 'success') {
                        $('#passwordMessage').text(data.message).removeClass('alert-danger').addClass('alert alert-success');
                    } else {
                        $('#passwordMessage').text(data.message).removeClass('alert-success').addClass('alert alert-danger');
                    }
                }).fail(function () {
                    $('#passwordMessage').text('Error during the request. Try again later.').removeClass('alert-success').addClass('alert alert-danger');
                });
            });
        });
    </script>

    </body>

    </html>