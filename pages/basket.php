<?php 
session_start();

require_once '../DB/start.php';
require_once '../core/Controllers/PoductController.php';

$conn = DB::getConnection();
$productController = new PoductController();

// Обработка избранного ДО любого вывода
// Логика обработки toggle_favourite будет перемещена в PoductController.php
if (isset($_GET['action']) && isset($_SESSION['id'])) {
    $action = $_GET['action'];
    if ($action === 'toggle_favourite') {
        // Это действие будет обрабатываться напрямую PoductController.php
        // Этот блок будет пустым, так как контроллер сам обработает редирект
    }
    // Если другие действия должны быть обработаны здесь, добавить их
}

// Получаем список избранных товаров
$favourites = [];
if (isset($_SESSION['login']) && isset($_SESSION['id'])) {
    $favourites = $productController->getFavourites((int)$_SESSION['id']);
}

// Получаем список товаров в корзине с деталями
$basketItemsDetails = []; // Переименовываем $basket в $basketItemsDetails для ясности
if (isset($_SESSION['login']) && isset($_SESSION['id'])) {
    $basketItemsDetails = $productController->getBasketItems((int)$_SESSION['id']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/static.css">
    <link rel="stylesheet" href="../style/basket.css">
    <link rel="stylesheet" href="../style/medea.css">
    <title>Laputa | Корзина</title>
</head>
<body>
    <?php require_once '../includes/header.php'; ?>


    <section class="basket_grid">
        <?php if(empty($basketItemsDetails)): ?>
            <div class="empty-basket">
                <p>Ваша корзина пуста</p>
                <a href="../index.php">Перейти к покупкам</a>
            </div>
        <?php else: ?>
            <?php foreach($basketItemsDetails as $item): // Используем $item вместо $key ?>
            <?php
                // $query = $conn->prepare('select * from products where id = ?'); // Больше не нужно, так как детали продукта уже получены
                // $query->execute([$item['product_id']]);
                // $products = $query->fetchAll();
                
                $basket_id = $item['basket_id']; // Используем basket_id из полученных данных
                $product = $item; // Вся информация о продукте уже в $item
            ?>
            <?php // foreach($products as $key): // Этот цикл больше не нужен ?>
            <div class="basket_card">
                <div class="img_basket_product">
                    <a href="./product.php?id=<?=$product['id']?>"><img src="../image/image_product/<?=$product['files']?>" alt="<?=htmlspecialchars($product['title'])?>"></a>
                </div>
                <div class="info_product">
                    <div class="price">
                        <a href="./product.php?id=<?=$product['id']?>"><h1><?=htmlspecialchars($product['title'])?></h1></a> 
                        <p><?=htmlspecialchars($product['price'])?> ₽</p>
                    </div>
                    <div class="button">
                        <?php if(isset($_SESSION['login'])): ?>
                            <div class="like">
                                <?php $isFavourite = in_array($product['id'], $favourites); ?>
                                <button class="toggle-favourite-btn" 
                                        data-product-id="<?=$product['id']?>" 
                                        data-redirect-url="<?=urlencode($_SERVER['REQUEST_URI'])?>">
                                    <img src="../image/Image_system/icons8-heart-50<?=$isFavourite ? ' (1)' : ''?>.png" 
                                         alt="<?=$isFavourite ? 'Удалить из избранного' : 'В избранное'?>">
                                </button>
                            </div>
                            <div class="bascet">
                                <button class="delete-from-basket-btn" 
                                        data-basket-id="<?=$basket_id?>" 
                                        data-redirect-url="<?=urlencode($_SERVER['REQUEST_URI'])?>">
                                    Удалить из корзины
                                </button>
                            </div>
                        <?php else: ?>
                            <div class="like">
                                <a href="./login.php">
                                    <img src="../image/Image_system/icons8-heart-50.png" alt="В избранное">
                                </a>
                            </div>
                            <div class="bascet">
                                <a href="./login.php">Удалить из корзины</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php // endforeach; // Этот цикл больше не нужен ?>
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