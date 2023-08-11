<?php

// Централизованные настройки базы данных
$dsn = 'pgsql:host=localhost;dbname=vps_sale';
$user = 'vps_user';
$pass = 'vps_password';

function loginUser($username, $password)
{
    global $dsn, $user, $pass;

    try {
        $db = new PDO($dsn, $user, $pass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $db->prepare("SELECT * FROM users WHERE LOWER(username) = :username");
        $lowercaseUsername = strtolower($username);
        $stmt->bindParam(':username', $lowercaseUsername);

        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Храните только необходимую информацию в сессии
            $_SESSION['username'] = $user['username'];
            $_SESSION['authenticated'] = true;
            return ['status' => 'success', 'message' => 'Successfully logged in.'];
        } else {
            return ['status' => 'error', 'message' => 'Invalid credentials.'];
        }
    } catch (PDOException $e) {
        return ['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()];
    }
}

function getUserData($username)
{
    global $dsn, $user, $pass;

    try {
        $db = new PDO($dsn, $user, $pass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return false;
    }
}

function updateUserSettings($email, $username)
{
    global $dsn, $user, $pass;

    try {
        $db = new PDO($dsn, $user, $pass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $db->prepare("UPDATE users SET email = :email WHERE username = :username");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return ['status' => 'success', 'message' => 'Settings updated successfully.'];
        } else {
            return ['status' => 'error', 'message' => 'No changes were made.'];
        }
    } catch (PDOException $e) {
        return ['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()];
    }
}

function changePassword($username, $currentPassword, $newPassword)
{
    global $dsn, $user, $pass;

    try {
        $db = new PDO($dsn, $user, $pass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Сначала проверим, правильный ли текущий пароль
        $stmt = $db->prepare("SELECT password FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($currentPassword, $user['password'])) {
            // Если текущий пароль верный, обновим его
            $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $db->prepare("UPDATE users SET password = :newPassword WHERE username = :username");
            $stmt->bindParam(':newPassword', $newPasswordHash);
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return ['status' => 'success', 'message' => 'Password updated successfully.'];
            } else {
                return ['status' => 'error', 'message' => 'No changes were made.'];
            }
        } else {
            return ['status' => 'error', 'message' => 'Current password is incorrect.'];
        }
    } catch (PDOException $e) {
        return ['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()];
    }
}

?>