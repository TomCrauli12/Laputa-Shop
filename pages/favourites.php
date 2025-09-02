<?php 
session_start();

require_once '../DB/start.php';
require_once '../core/Controllers/PoductController.php';

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

// Получаем все избранные товары с данными
$favouriteProducts = [];
if (isset($_SESSION['login']) && isset($_SESSION['id'])) {
    $favouriteProducts = $productController->getFavouriteProductsWithDetails((int)$_SESSION['id']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/static.css">
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../style/media/medea.css">
    <title>Laputa | Избранное</title>
</head>
<body>
    <?php require_once '../includes/header.php'; ?>

    <section class="favourites_grid">
        <?php if(empty($favouriteProducts)): ?>
            <div class="empty-favourites">
                <p>В вашем избранном ничего нет</p>
                <a href="../index.php">Перейти к категориям</a>
            </div>
        <?php else: ?>
            <?php foreach($favouriteProducts as $product): ?>
            <?php 
                $isFavourite = in_array($product['id'], $favourites);
                $inBasket = in_array($product['id'], $basketItems);
            ?>
            <div class="card">
                <div class="img_product">
                    <a href="./product.php?id=<?=$product['id']?>">
                        <img src="../image/image_product/<?=htmlspecialchars($product['files'])?>" alt="<?=htmlspecialchars($product['title'])?>">
                    </a>
                </div>
                <div class="price">
                    <a href="./product.php?id=<?=$product['id']?>">
                        <h1><?=htmlspecialchars($product['title'])?></h1>
                    </a> 
                    <p><?=htmlspecialchars($product['price'])?> ₽</p>
                </div>
                <div class="button">
                    <?php if(isset($_SESSION['login'])): ?>
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
            <?php endforeach; ?>
        <?php endif; ?>
    </section>

    <div class="conteiner_zero">
        <?php require_once '../includes/footer.php'; ?>
    </div>

    <script src="../scripts/theme.js"></script>
    <script src="../scripts/script.js"></script>
    <script src="../scripts/ajax.js"></script>
    <script>
        // Обработчик для кнопки каталога
        document.getElementById('catalog-link').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('burger-checkbox').checked = 
                !document.getElementById('burger-checkbox').checked;
        });
    </script>
</body>
</html>