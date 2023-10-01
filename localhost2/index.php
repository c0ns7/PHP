<?php
    // Проверяем, если пользователь авторизован
    if(isset($_COOKIE['user'])) {
        // Расшифровываем имя пользователя из cookie
        $encryption_key = "bndcFvq11ge5q0Bj75KcCyGQBYx8S5QDGDkS2vRj";
        $decryptedName = openssl_decrypt($_COOKIE['user'], "AES-128-ECB", $encryption_key);

        // Подключаемся к базе данных
        include './assets/php/bd.php';

        // Проверяем, если соединение с базой данных установлено
        if ($mysql->connect_errno) {
            echo 'Ошибка подключения к базе данных: ' . $mysql->connect_error;
            exit();
        }

        $stmt = $mysql->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $decryptedName);
        $stmt->execute();

        $result = $stmt->get_result();

        // Проверяем, если пользователь существует
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
        }

        $stmt->close();
        $mysql->close();
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
    <?php include './assets/components/header.php' ?>

    <div class="follow-cursor"></div>

    <script src="./assets/js/app.js"></script>
    <script src="./assets/js/cursor.js"></script>
</body>
</html>