<?php

require_once '../Modules/UserModel.php';

if($_GET['action']=="register"){
    
    $login = $_POST['login'];

    $name = $_POST['name'];

    $password = md5($_POST['password']);

    $role = "user";

    UserModel::register($login, $name, $password, $role);

    header("Location: ../../pages/identification.php");

}
elseif($_GET['action']=="login"){

    $login = $_POST['login'];

    $password = md5($_POST['password']);

    UserModel::login($login, $password);

}
elseif($_GET['action']=="logout"){

    session_start();
    session_destroy();
    Header("Location: /");

}
else{
    Header("Location: /");
}