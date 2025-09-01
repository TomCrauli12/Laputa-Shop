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

// Получаем имя категории из параметра URL
$categoryName = $_GET['name'];

// Получаем информацию о категории
$stmt = $conn->prepare("SELECT * FROM category WHERE categoryName = ?");
$stmt->execute([$categoryName]);
$category = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$category) {
    header("Location: ../index.php?error=category_not_found");
    exit();
}

// Получаем параметры фильтрации
$min_value = $_GET['min_value'] ?? 100;
$max_value = ($_GET['max_value'] ?? 0) > 0 ? $_GET['max_value'] : 100000;

// Получаем товары по categoryBDName
if(isset($_GET['min_value']) && isset($_GET['max_value'])) {
    $products = category::getProductsByCategoryWithPriceFilter($category['categoryBDName'], $min_value, $max_value);
} else {
    $products = category::getProductsByCategory($category['categoryBDName']);
}

// Получаем все категории для меню
$allCategories = $conn->query('SELECT * FROM category')->fetchAll();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/static.css">
    <link rel="stylesheet" href="../style/product_grid.css">
    <link rel="stylesheet" href="../style/product_card.css">
    <title>Laputa | <?=htmlspecialchars($categoryName)?></title>
</head>
<body>
    <?php require_once '../includes/header.php'; ?>

    <main>
        <div class="sorting">
            <h2>Сортировка</h2>
            <form method="get">
                <p>Цена</p>
                <label for="min_value">От</label>
                <input type="number" id="min_value" name="min_value" value="<?=$min_value?>"><br><br>
                <label for="max_value">До</label>
                <input type="number" id="max_value" name="max_value" value="<?=$max_value?>"><br><br>
                <input type="hidden" name="name" value="<?=htmlspecialchars($categoryName)?>">
                <button type="submit">Применить</button>
                <a href="./category.php?name=<?=urlencode($categoryName)?>" class="reset-btn">Сбросить</a>
            </form>
        </div>
        
        <section class="conteiner_product">
            <div class="name">
                <h1><?=htmlspecialchars($categoryName)?></h1>
            </div>

            <div class="product_grid">
                <?php if(empty($products)): ?>
                    <p class="no-products">Товары в этой категории отсутствуют</p>
                <?php else: ?>
                    <?php foreach($products as $product): ?>
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
                            <?php if(isset($_SESSION['login']) && isset($_SESSION['id'])): ?>
                                <div class="bascet">
                                    <?php $inBasket = in_array($product['id'], $basketItems); ?>
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
                                            data-category-name="<?=urlencode($categoryName)?>"
                                            data-min-value="<?=isset($_GET['min_value']) ? (int)$_GET['min_value'] : ''?>"
                                            data-max-value="<?=isset($_GET['max_value']) ? (int)$_GET['max_value'] : ''?>"
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
                        <?php if(isset($_SESSION['role']) && $_SESSION['role'] == "admin"): ?>
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
        </section>
    </main>
    <?php require_once '../includes/footer.php'; ?>

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