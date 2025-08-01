<?php

require_once '../Modules/PostModel.php';

if($_GET['action']=="delete"){

    isset($_GET['id']) ? $id = trim($_GET['id']) : Header("Location: /");;

    PostModel::deletePost($id);

    Header("Location: /");

}
elseif($_GET['action']=="create"){

    $title = $_POST['title'];

    $descr = $_POST['descr'];
    
    $price = $_POST['price'];

    $category = $_POST['category'];
    
    $files = $_FILES['files']['name'];
    
    $categorytwo = $_POST['categorytwo'];

    $info_block = $_POST['info_block'];

    $files_2 = $_FILES['files_2']['name'];

    $files_3 = $_FILES['files_3']['name'];

    $files_4 = $_FILES['files_4']['name'];

    $files_5 = $_FILES['files_5']['name'];


    PostModel::createPost($title, $descr, $price, $category, $files, $categorytwo, $info_block, $files_2, $files_3, $files_4, $files_5);

    Header("Location: /");

}  

else{

    //Header("Location: /");
}


if($_GET['action']=="deleteProduct"){

    session_start();

    isset($_GET['id']) ? $id = trim($_GET['id']) : Header("Location: /");;

    PostModel::deleteProduct($id);

    Header("Location: /basket.php");

}
elseif($_GET['action']=="AddToBasket"){

    session_start();
    
    $userid = $_SESSION['id'];

    $product_id = $_GET['product_id'];
    
    PostModel::AddToBasket($product_id,$userid);

    Header("Location: /");

}
else{

}


if($_GET['action']=="deleteFavourites"){

    session_start();

    isset($_GET['id']) ? $id = trim($_GET['id']) : Header("Location: /");;

    PostModel::deleteFavourites($id);

    Header("Location: /favourites.php");

}

elseif($_GET['action']=="AddToFavourites"){

    session_start();
    
    $userid = $_SESSION['id'];

    $product_id = $_GET['product_id'];
    
    PostModel::AddToFavourites($product_id,$userid);

    $return_url = $_GET['return_url'];
    Header("Location: $return_url");

}
else{

}


