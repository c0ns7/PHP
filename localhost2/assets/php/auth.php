<?php
    // Записываем данные в переменные, предварительно фильтруя
    $username = filter_var(trim($_POST['username']), FILTER_SANITIZE_STRING);
    $password = filter_var(trim($_POST['password']), FILTER_SANITIZE_STRING);

    // Проверка наличия введенных данных
    if (empty($username) || empty($password)) {
        echo 'Заполните все поля'; 
        exit();
    }

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
    if ($result->num_rows == 0) {
        echo 'Пользователь с таким логином не найден';
        exit();
    }

    $user = $result->fetch_assoc();

    // Проверка правильности пароля
    if (!password_verify($password, $user['password'])) {
        echo 'Неправильный пароль';
        exit();
    }

    // Шифрование данных перед сохранением в cookie
    $encryption_key = "bndcFvq11ge5q0Bj75KcCyGQBYx8S5QDGDkS2vRj";
    $encryptedName = openssl_encrypt($username, "AES-128-ECB", $encryption_key);

    setcookie('user', $encryptedName, time() + 3600 * 24, "/");

    $stmt->close();
    $mysql->close();

    header('Location: /');
?>