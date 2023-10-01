<?php
    // Подключение к базе данных
    include '../php/bd.php';

    // Проверка наличия соединения с базой данных
    if ($mysql->connect_errno) {
        echo 'Ошибка подключения к базе данных: ' . $mysql->connect_error;
        exit();
    }

    if (isset($_COOKIE['user'])) {
        $encryptedName = $_COOKIE['user'];
        // Расшифровка данных из cookie
        $encryption_key = "bndcFvq11ge5q0Bj75KcCyGQBYx8S5QDGDkS2vRj";
        $username = openssl_decrypt($encryptedName, "AES-128-ECB", $encryption_key);
    
        $stmt = $mysql->prepare("SELECT * FROM users WHERE username = ? AND admin = 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
    
        $result = $stmt->get_result();
    
        if ($result->num_rows === 0) {
            // Пользователь не является админом
            $stmt->close();
            $mysql->close();
            header('Location: /');
            exit(); // Добавлен выход из скрипта после перенаправления
        } 
    
        $stmt->close();
    } else {
        // Пользователь не авторизован
        $mysql->close();
        header('Location: login.php');
        exit(); // Добавлен выход из скрипта после перенаправления
    }

    // Получение идентификатора пользователя из параметра запроса
    $userID = $_GET['id'];

    // Проверка наличия идентификатора пользователя
    if (empty($userID)) {
        echo 'Идентификатор пользователя не указан';
        exit();
    }

    // Подготовленный запрос на удаление пользователя по идентификатору
    $stmt = $mysql->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $userID);
    $stmt->execute();

    // Проверка успешного удаления пользователя
    if ($stmt->affected_rows === 1) {
        echo 'Пользователь успешно удален';
    } else {
        echo 'Не удалось удалить пользователя';
    }

    // Удаление куки у пользователя, которому удалили аккаунт
    if (isset($_COOKIE['user']) && $_COOKIE['user'] === $encryptedName) {
        setcookie('user', '', time() - 3600, '/');
    }

    // Закрытие подготовленного запроса и соединения с базой данных
    $stmt->close();
    $mysql->close();

    header('Location: users.php');
?>