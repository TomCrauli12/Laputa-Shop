<?php
session_start();

require_once '../DB/start.php';
require_once '../core/Controllers/PoductController.php';
require_once __DIR__ . '/../core/Modules/PostModel.php';

$conn = DB::getConnection();
$productController = new PoductController();

// Получаем список избранных товаров
$favourites = [];
if (isset($_SESSION['login']) && isset($_SESSION['id'])) {
    $favourites = $productController->getFavourites((int)$_SESSION['id']);
}

// Получаем список товаров в корзине
$basketItems = [];
if (isset($_SESSION['login']) && isset($_SESSION['id'])) {
    $basketItems = $productController->getBasketItemIds((int)$_SESSION['id']);
}

$product = products::showProduct($_GET['id']);
$isFavourite = in_array($product['id'], $favourites);
$inBasket = in_array($product['id'], $basketItems);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/product.css">
    <link rel="stylesheet" href="../style/medea.css">
    <title>Laputa | <?=htmlspecialchars($product['title'])?></title>
</head>
<body>
    <?php require_once '../includes/header.php'; ?>

    <section class="product">
        <div class="product_images_conteiner">
            <div class="images_conteiner">
                <div class="images_list">
                    <?php if(!empty($product['files_2'])): ?>
                        <a href=""><img src="../image/image_product/<?=$product['files_2']?>" alt="Дополнительное изображение"></a>
                    <?php endif; ?>
                    <?php if(!empty($product['files_3'])): ?>
                        <a href=""><img src="../image/image_product/<?=$product['files_3']?>" alt="Дополнительное изображение"></a>
                    <?php endif; ?>
                    <?php if(!empty($product['files_4'])): ?>
                        <a href=""><img src="../image/image_product/<?=$product['files_4']?>" alt="Дополнительное изображение"></a>
                    <?php endif; ?>
                    <?php if(!empty($product['files_5'])): ?>
                        <a href=""><img src="../image/image_product/<?=$product['files_5']?>" alt="Дополнительное изображение"></a>
                    <?php endif; ?>
                </div>
                <div class="main_images">
                    <a href=""><img src="../image/image_product/<?=$product['files']?>" alt="<?=htmlspecialchars($product['title'])?>"></a>
                </div>
            </div>
        </div>

        <div class="info_product_conteiner">
            <div class="info_conteiner">
                <div class="title">
                    <h1><?=htmlspecialchars($product['title'])?></h1>
                </div>
                <div class="price">
                    <h2><?=htmlspecialchars($product['price'])?> ₽</h2>
                </div>
                <div class="description">
                    <p><?=htmlspecialchars($product['descr'])?></p>
                </div>
            </div>
            <div class="buttons">
                <?php if(isset($_SESSION['login']) && isset($_SESSION['id'])): ?>
                    <div class="bascet">
                        <?php if($inBasket): ?>
                            <a href="./basket.php" class="in-basket">
                                Товар в корзине
                            </a>
                        <?php else: ?>
                            <button class="add-to-basket-btn" data-product-id="<?=$product['id']?>" 
                                    data-redirect-url="<?=urlencode($_SERVER['REQUEST_URI'])?>">
                                В корзину
                            </button>
                        <?php endif; ?>
                    </div>
                    <div class="like">
                        <?php $isFavourite = in_array($product['id'], $favourites); ?>
                        <button class="toggle-favourite-btn" 
                                data-product-id="<?=$product['id']?>" 
                                data-redirect-url="<?=urlencode($_SERVER['REQUEST_URI'])?>">
                            <img src="../image/Image_system/icons8-heart-50<?=$isFavourite ? ' (1)' : ''?>.png" 
                                alt="<?=$isFavourite ? 'Удалить из избранного' : 'В избранное'?>">
                        </button>
                    </div>
                <?php else: ?>
                    <div class="bascet">
                        <a href="./login.php">В корзину</a>
                    </div>
                    <div class="like">
                        <a href="./login.php">
                            <img src="../image/Image_system/icons8-heart-50.png" alt="В избранное">
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php require_once '../includes/footer.php'; ?>

    <script src="../scripts/product.js"></script>
    <script src="../scripts/ajax.js"></script>
</body>
</html>