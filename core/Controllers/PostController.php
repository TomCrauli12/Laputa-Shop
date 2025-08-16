<?php

require_once '../Modules/PostModel.php';

if($_GET['action']=="delete"){

    isset($_GET['id']) ? $id = trim($_GET['id']) : Header("Location: /");;

    PostModel::deletePost($id);

    Header("Location: /");

}
elseif($_GET['action'] == "createProduct") {
    try {
        $title = $_POST['title'];
        $descr = $_POST['descr'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        $info_block = $_POST['info_block'] ?? ''; 

        PostModel::createProduct(
            $title,
            $descr,
            $price,
            $category,
            $_FILES['files'],
            $info_block,
            $_FILES['files_2'] ?? null,
            $_FILES['files_3'] ?? null,
            $_FILES['files_4'] ?? null,
            $_FILES['files_5'] ?? null
        );

        header("Location: ../../index.php");
        exit();
    } catch (Exception $e) {
        die("Ошибка при создании товара: " . $e->getMessage());
    }
}

else{

    //Header("Location: /");
}


if($_GET['action']=="deleteProduct"){

    session_start();

    isset($_GET['id']) ? $id = trim($_GET['id']) : Header("Location: /");;

    PostModel::deleteProduct($id);

    Header("Location: ../../index.php");

}
if($_GET['action']=="deleteBasketProduct"){

    session_start();

    isset($_GET['id']) ? $id = trim($_GET['id']) : Header("Location: /");;

    Basket::deleteBasketProduct($id);

    Header("Location: ../../pages/basket.php");

}
elseif($_GET['action']=="AddToBasket"){

    session_start();
    
    $userid = $_SESSION['id'];

    $product_id = $_GET['product_id'];
    
    Basket::AddToBasket($product_id,$userid);

    Header("Location: /");

}
else{

}


if($_GET['action']=="deleteFavourites"){

    session_start();

    isset($_GET['id']) ? $id = trim($_GET['id']) : Header("Location: /");;

    Favourites::deleteFavourites($id);

    Header("Location: ../../pages/favourites.php");

}

elseif($_GET['action']=="editProduct"){

    $title = $_POST['title'];

    $descr = $_POST['descr'];

    $price = $_POST['price'];

    $category = $_POST['category'];

    $categorytwo = $_POST['categorytwo'];

    $info_block = $_POST['info_block'];

    $id = $_GET['id'];

    PostModel::editProduct($title, $descr, $price, $category, $categorytwo, $info_block, $id);
    
    Header("Location: ../../index.php");
}

elseif($_GET['action']=="AddToFavourites"){

    session_start();
    
    $userid = $_SESSION['id'];

    $product_id = $_GET['product_id'];
    
    Favourites::AddToFavourites($product_id,$userid);

    $return_url = $_GET['return_url'];
    Header("Location: $return_url");

}
elseif($_GET['action']=="AddToFavouriteFromBasket"){

    session_start();
    
    $userid = $_SESSION['id'];

    $product_id = $_GET['product_id'];
    
    Favourites::AddToFavouriteFromBasket($product_id,$userid);

    Header("Location: ../../pages/basket.php");
}
elseif($_GET['action']=="addSlider"){

    $imageslider = $_FILES['imageslider']['name'];

    slider::addSlider($imageslider);

    Header("Location: ../../index.php");
}
elseif($_GET['action']=="addCategory"){

    $categoryName = $_POST['categoryName'];
    
    $categoryBDName = $_POST['categoryBDName'];

    category::addCategory($categoryName, $categoryBDName);

    Header("Location: ../../index.php");
}
elseif($_GET['action']=="addInfoBlock"){

    $infoBlockName = $_POST['infoBlockName'];
    
    $infoBlockDBName = $_POST['infoBlockDBName'];

    infoBlock::addInfoBlock($infoBlockName, $infoBlockDBName);

    Header("Location: ../../index.php");
}



