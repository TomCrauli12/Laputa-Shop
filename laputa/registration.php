<?php
require_once './start.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/login.css">
    <title>Регистрация</title>
</head>
<body>

    <form method="post" enctype="multipart/form-data" action="./scripts/UserController.php?action=register">
        <h3>Регистрация</h3>

        <label>Логин</label>
        <input type="text" name="login" required="" placeholder="Ваш логин">

        <label>Пароль</label>
        <input type="password" name="password" required=""placeholder="Пароль">

        <button class="button" type="submit">Создать аккаунт</button>
        <div class="i">
          <a href="./login.php">Авторизация</a>
        </div> 
    </form>

</body>
</html>