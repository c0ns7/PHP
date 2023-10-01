<?php
// Подключение к базе данных
include '../php/bd.php';

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
    header('Location: ../../login.php');
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
    <link rel="stylesheet" href="../css/main.css">

    <!-- JS Only -->
    <script src="https://kit.fontawesome.com/58ffb778bb.js" crossorigin="anonymous"></script>
</head>
<body>
    <header class="header">
        <div class="wrapper">
            <div class="inner">
                <div class="logo">
                    <a href="/">
                        <img src="../img/logo.png" alt="">
                    </a>
                </div>

                <div class="burger">
                    <span>Menu</span>
                    <i><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><path d="M0 96C0 78.3 14.3 64 32 64H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32 14.3 32 32z"/></svg></i>
                </div>

                <aside class="menu-list">
                    <div class="wrapper-2">
                        <span>Menu</span>

                        <a href="./users.php">
                            <i><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"/></svg></i>
                            Users
                        </a>

                        <?php if($_COOKIE['user'] == ''): ?>
                            <a href="login.php">
                                <i><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><path d="M352 96l64 0c17.7 0 32 14.3 32 32l0 256c0 17.7-14.3 32-32 32l-64 0c-17.7 0-32 14.3-32 32s14.3 32 32 32l64 0c53 0 96-43 96-96l0-256c0-53-43-96-96-96l-64 0c-17.7 0-32 14.3-32 32s14.3 32 32 32zm-9.4 182.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L242.7 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l210.7 0-73.4 73.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l128-128z"/></svg></i>
                                Sign In
                            </a>
                        <?php else: ?>
                            <a href="../php/logout.php">
                                <i><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><path d="M502.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 224 192 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l210.7 0-73.4 73.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l128-128zM160 96c17.7 0 32-14.3 32-32s-14.3-32-32-32L96 32C43 32 0 75 0 128L0 384c0 53 43 96 96 96l64 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-64 0c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32l64 0z"/></svg></i>
                                Logout
                            </a>
                        <?php endif; ?>
                    </div>
                </aside>
            </div>
        </div>
    </header>

    <div class="page">
        <div class="users">
            <div class="wrapper">
                <div class="card">
                    <div class="card-body">
                        <h1>Users</h1>

                        <?php
                        // Подключение к базе данных
                        include '../php/bd.php';

                        // Проверка наличия соединения с базой данных
                        if ($mysql->connect_errno) {
                            echo 'Ошибка подключения к базе данных: ' . $mysql->connect_error;
                            exit();
                        }

                        // Запрос на получение всех пользователей из таблицы users
                        $result = $mysql->query("SELECT * FROM users");

                        // Проверка наличия пользователей в базе данных
                        if ($result->num_rows > 0) {
                            echo "<h2>Пользователи:</h2>";
                            echo "<ul>";
                            while ($row = $result->fetch_assoc()) {
                                echo "<li>" . $row['username'] . " <a href='delete_user.php?id=" . $row['id'] . "'>[Удалить]</a></li>";
                            }
                            echo "</ul>";
                        } else {
                            echo "Пользователей не найдено.";
                        }

                        // Закрываем соединение с базой данных
                        $mysql->close();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="follow-cursor"></div>

    <script src="../js/app.js"></script>
    <script src="../js/cursor.js"></script>
</body>
</html>