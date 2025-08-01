<?php

require_once '../Modules/UserModel.php';

if($_GET['action']=="register"){
    
    $login = $_POST['login'];

    $password = $_POST['password'];

    UserModel::register($login, $password);

    Header('Location: ../login.php');

}
elseif($_GET['action']=="login"){

    $login = $_POST['login'];

    $password = $_POST['password'];

    UserModel::login($login,$password);

    Header("Location: /");

}
elseif($_GET['action']=="logout"){

    session_start();
    session_destroy();
    Header("Location: /");

}
else{
    Header("Location: /");
}