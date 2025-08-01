<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'../../DB/start.php';

class UserModel{

    static function register($login,$password){

    $conn = DB::getConnection();
        
    $query = $conn->prepare("INSERT INTO user (login,password) values (?,?)");

    $query->execute([$login,$password,]);


    }

    static function login($login,$password){

    $conn = DB::getConnection();
        
    $query = $conn->prepare("SELECT * FROM `user` WHERE `login` = ? and `password` = ?");

    $query->execute([$login, $password]);
    
    $userinfo = $query->fetch();

    if ($query->rowCount()>0){

        session_start();

        $_SESSION['login'] = $userinfo['login'];
        $_SESSION['id'] = $userinfo['id'];


        echo "<script type='text/javascript'> alert('Авторизация успешна!'); window.location.href='../index.php' </script> ";

    }

    else{

        echo "<script type='text/javascript'> alert('Ошибка авторизации'); window.location.href='../login.php' </script> ";

    }

    }

    static function getUserInfo($userid){

        $conn = DB::getConnection();

        $query = $conn->prepare("select * from user where id = ?");

        $query->execute([$userid]);

        $userdata = $query->fetch();

        return $userdata;

    }


}
