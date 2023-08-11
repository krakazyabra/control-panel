<?php

session_start();

$data = $_POST;

if (!empty($data['username']) && !empty($data['password'])) {
    include 'backend.php';
    $result = loginUser($data['username'], $data['password']);
    echo json_encode($result);
    return;
}

if (isset($data['action']) && $data['action'] === 'getUserData') {
    include 'backend.php';
    $result = getUserData($data['username']);
    if($result && isset($result['date_joined'])){
        $date = new DateTime($result['date_joined']);
        $result['date_joined'] = $date->format('d F Y, H:i:s');
    }
    echo json_encode($result);
    return;
}


// Предположим, что мы добавляем новый ключ "action", чтобы различать разные типы запросов
if (isset($data['action']) && $data['action'] === 'updateSettings' && isset($data['email'])) {
    include 'backend.php';
    $result = updateUserSettings($data['email'], $data['username']);
    echo json_encode($result);
    return;
}

if (isset($data['action']) && $data['action'] === 'changePassword' && isset($data['currentPassword']) && isset($data['newPassword'])) {
    include 'backend.php';
    $result = changePassword($data['username'], $data['currentPassword'], $data['newPassword']);
    echo json_encode($result);
    return;
}

?>