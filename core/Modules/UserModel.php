<?php 
require_once __DIR__ . '/../../DB/start.php';

class UserModel{

    static function register($login, $name, $password, $role) {
        $conn = DB::getConnection();

        $query = $conn->prepare("SELECT * FROM `users` WHERE `login` = :login");
        $query->execute(['login' => $_POST['login']]);
        if ($query->rowCount() > 0) {
            $_SESSION['error_message'] = 'Это логин уже занят.';
            header('Location: ../../pages/register.php'); 
            die; 
        }

        $query = $conn->prepare("SELECT * FROM `users` WHERE `name` = :name");
        $query->execute(['name' => $_POST['name']]);
        if ($query->rowCount() > 0) {
            $_SESSION['error_message'] = 'Это имя пользователя уже занято.';
            header('Location: ../../pages/register.php'); 
            die; 
        }

        $query = $conn->prepare("INSERT INTO users (login, name, password, role) values (?, ?, ?, ?)");
        $query->execute([$login, $name, $password, $role]);

    }


    static function login($login, $password) {
        session_start();
        $conn = DB::getConnection();

        $query = $conn->prepare('SELECT * FROM `users` WHERE `login` = ? AND `password` = ?');
        $query->execute([$login, $password]);

        $userinfo = $query->fetch();

        if ($query->rowCount() > 0) {

            $_SESSION['login'] = $userinfo['login'];
            $_SESSION['id'] = $userinfo['id'];
            $_SESSION['role'] = $userinfo['role'];
            $_SESSION['name'] = $userinfo['name'];

            header('Location: ../../index.php');
            exit();
        } else {

            $_SESSION['error'] = 'Ошибка авторизации';
            header('Location: ../../pages/login.php');
            exit();
        }
    }

    static function getUserInfo($userid){

        $conn = DB::getConnection();

        $query = $conn->prepare("select * from users where id = ?");

        $query->execute([$userid]);

        $userdata = $query->fetch();

        return $userdata;

    }


}
