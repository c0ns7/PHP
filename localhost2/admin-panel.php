<?php
// Подключение к базе данных
include './assets/php/bd.php';

// Проверка наличия соединения с базой данных
if ($mysql->connect_errno) {
    echo 'Ошибка подключения к базе данных: ' . $mysql->connect_error;
    exit();
}

// Проверка наличия авторизованного пользователя с атрибутом 'admin' равным 1
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Изучение JavaScript</title>

    <!-- CSS Only -->
    <link rel="stylesheet" href="./assets/css/main.css">

    <!-- JS Only -->
    <script src="https://kit.fontawesome.com/58ffb778bb.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php include './assets/components/admheader.php' ?>



    <div class="follow-cursor"></div>

    <script src="./assets/js/app.js"></script>
    <script src="./assets/js/cursor.js"></script>
</body>
</html>