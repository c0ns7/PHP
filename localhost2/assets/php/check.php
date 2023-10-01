<?php
    // Записываем данные в переменные, предварительно фильтруя
    $username = filter_var(trim($_POST['username']), FILTER_SANITIZE_STRING);
    $password = filter_var(trim($_POST['password']), FILTER_SANITIZE_STRING);
    $repassword = filter_var(trim($_POST['repassword']), FILTER_SANITIZE_STRING);

    // Проверка длины логина и пароля
    if (mb_strlen($username) < 5 || mb_strlen($username) > 90) {
        echo "Недопустимая длина логина.";
        exit();
    } elseif (mb_strlen($password) < 2 || mb_strlen($password) > 6) {
        echo "Недопустимая длина пароля (от 2 до 6 символов).";
        exit();
    }

    // Проверка наличия введенных данных
    if (empty($username) || empty($password) || empty($repassword)) {
        echo 'Заполните все поля'; 
        exit();
    }

    // Проверка совпадения паролей
    if ($password !== $repassword) {
        echo 'Пароли не совпадают';
        exit();
    }

    // Хеширование пароля с помощью bcrypt или Argon2
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    include './bd.php';

    // Проверка наличия соединения с базой данных
    if ($mysql->connect_errno) {
        echo 'Ошибка подключения к базе данных: ' . $mysql->connect_error;
        exit();
    }

    $stmt = $mysql->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();

    // Проверка наличия пользователя с таким логином
    if ($result->num_rows > 0) {
        echo 'Пользователь с таким логином уже зарегистрирован';
        exit();
    }

    $stmt = $mysql->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $passwordHash);
    $stmt->execute();

    // Шифрование данных перед сохранением в cookie
    $encryption_key = "bndcFvq11ge5q0Bj75KcCyGQBYx8S5QDGDkS2vRj";
    $encryptedName = openssl_encrypt($username, "AES-128-ECB", $encryption_key);

    setcookie('user', $encryptedName, time() + 3600 * 24, "/");

    $stmt->close();
    $mysql->close();

    header('Location: /');
?>