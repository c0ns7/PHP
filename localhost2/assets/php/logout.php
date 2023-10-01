<?php
    // Проверка, установлен ли пользовательский cookie
    if (!isset($_COOKIE['user'])) {
        header('Location: /');
        exit();
    }

    setcookie('user', $user['name'], time() - 3600 / 24, "/");

    header('Location: /');
    exit();
?>