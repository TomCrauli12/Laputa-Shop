<?php
session_start();

require_once '../DB/start.php';
require_once '../core/Controllers/PoductController.php';

$conn = DB::getConnection();
$productController = new PoductController();

// --- БЛОК ПОЛУЧЕНИЯ ДАННЫХ ДЛЯ ВЫВОДА ---
// Получаем список избранных товаров для текущего пользователя
$favourites = [];
if (isset($_SESSION['login']) && isset($_SESSION['id'])) {
    $favourites = $productController->getFavourites((int)$_SESSION['id']);
}

// Получаем список товаров в корзине для текущего пользователя
$basketItems = [];
if (isset($_SESSION['login']) && isset($_SESSION['id'])) {
    $basketItems = $productController->getBasketItemIds((int)$_SESSION['id']);
}

// --- ОСНОВНАЯ ЛОГИКА ПОИСКА ---
$results = [];
if (isset($_GET['query']) && !empty(trim($_GET['query']))) {
    $search_query = trim($_GET['query']);
    
    $sql = "SELECT * FROM products WHERE title LIKE :query";
    $stmt = $conn->prepare($sql);
    
    $search_param = "%" . $search_query . "%";
    $stmt->bindParam(':query', $search_param, PDO::PARAM_STR);
    
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <title>Поиск товаров</title>
</head>
<body>
    <?php require_once '../includes/header.php'; ?>

    <hr>

    <div class="search-results">
        <?php if (isset($_GET['query']) && !empty(trim($_GET['query']))) : ?>
            <div class="product_grid">
                <?php if (empty($results)) : ?>
                    <p class="no-products">Товаров по вашему запросу не найдено.</p>
                <?php else : ?>
                    <?php foreach ($results as $product) : ?>
                    <div class="card">
                        <div class="img_product">
                            <a href="./product.php?id=<?=$product['id']?>">
                                <img src="../image/image_product/<?=htmlspecialchars($product['files'])?>" 
                                    alt="<?=htmlspecialchars($product['title'])?>">
                            </a>
                        </div>
                        <div class="price">
                            <a href="./product.php?id=<?=$product['id']?>">
                                <h3><?=htmlspecialchars($product['title'])?></h3>
                            </a> 
                            <p><?=htmlspecialchars($product['price'])?> ₽</p>
                        </div>
                        <div class="button">
                            <?php if (isset($_SESSION['login']) && isset($_SESSION['id'])) : ?>
                                <div class="bascet">
                                    <?php $inBasket = in_array($product['id'], $basketItems); ?>
                                    <?php if ($inBasket) : ?>
                                        <a href="./basket.php" class="in-basket">
                                            Товар в корзине
                                        </a>
                                    <?php else : ?>
                                        <a href="../core/Controllers/PoductController.php?action=AddToBasket&product_id=<?=$product['id']?>&query=<?=urlencode($_GET['query'])?>&redirect_url=<?=urlencode($_SERVER['REQUEST_URI'])?>">
                                            В корзину
                                        </a>
                                    <?php endif; ?>
                                </div>
                                <div class="like">
                                    <?php $isFavourite = in_array($product['id'], $favourites); ?>
                                    <a href="../core/Controllers/PoductController.php?action=toggle_favourite&product_id=<?=$product['id']?>&query=<?=urlencode($_GET['query'])?>&redirect_url=<?=urlencode($_SERVER['REQUEST_URI'])?>">
                                        <img src="../image/Image_system/icons8-heart-50<?=$isFavourite ? ' (1)' : ''?>.png" 
                                            alt="<?=$isFavourite ? 'Удалить из избранного' : 'В избранное'?>">
                                    </a>
                                </div>
                            <?php else : ?>
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
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == "admin") : ?>
                            <div class="admin_buttons">
                                <a href="../adminPages/editProduct.php?id=<?=$product['id']?>" 
                                class="edit_btn">Редактировать</a>
                                <a href="../core/Controllers/PostController.php?action=deleteProduct&id=<?=$product['id']?>" 
                                class="delete_btn" 
                                onclick="return confirm('Удалить этот товар?')">Удалить</a>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php else : ?>
            <p>Введите название товара, чтобы начать поиск.</p>
        <?php endif; ?>
    </div>


    <script src="../scripts/ajax.js"></script>
</body>
</html>