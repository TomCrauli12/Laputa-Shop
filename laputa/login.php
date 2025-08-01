<?php
require_once './start.php';

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/login.css">
    <title>Login</title>
</head>
<body>

    <form method="post" action="./scripts/UserController.php?action=login">
        <h3>Авторизация</h3>

        <label for="username">Имя Пользователя</label>
        <input type="text" name="login" placeholder="Ваш логин">
        

        <label for="password">Пароль</label>
        <input type="password" name="password" placeholder="Ваш пароль" id="password">

        <button class="button" type="submit">Войти в акаунт</button>
        <div class="i">
          <a href="./registration.php">Регистрация</a>
        </div>

    </form>


</body>
</html>


