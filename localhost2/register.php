<?php 
if (isset($_COOKIE['user'])) {
    header('Location: /');
    exit();
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

    <div class="page">
        <div class="register">
            <div class="wrapper">
                <div class="card">
                    <div class="card-body">
                        <h1>Register</h1>

                        <div class="form-control">
                            <form action="./assets/php/check.php" method="post" id="registration-form">
                                <input type="text" id="username" name="username" placeholder="Username">
                                <input type="password" id="password" name="password" placeholder="Password">
                                <input type="password" id="repassword" name="repassword" placeholder="Repeat password">
                                <button>Create New Account</button>
                                
                                <div class="info">
                                    <span>Already have an account?</span> 
                                    <a href="/login.php">Login Here</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="follow-cursor"></div>

    <script src="./assets/js/app.js"></script>
    <script src="./assets/js/cursor.js"></script>
    <script src="./assets/js/reg.js"></script>
</body>
</html>