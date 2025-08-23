<?php 
session_start();

require_once '../DB/start.php';
require_once '../core/Modules/UserModel.php';
require_once '../core/Modules/PostModel.php';

$conn = DB::getConnection();

// Обработка избранного ДО любого вывода
if (isset($_GET['action']) && $_GET['action'] === 'toggle_favourite' && isset($_SESSION['id'])) {
    $product_id = (int)($_GET['product_id'] ?? 0);
    
    if ($product_id > 0) {
        try {
            // Проверяем наличие товара в избранном
            $stmt = $conn->prepare("SELECT id FROM favourites WHERE user_id = ? AND product_id = ?");
            $stmt->execute([$_SESSION['id'], $product_id]);
            $favourite = $stmt->fetch();

            if ($favourite) {
                // Удаляем из избранного
                $conn->prepare("DELETE FROM favourites WHERE id = ?")->execute([$favourite['id']]);
            } else {
                // Добавляем в избранное
                $conn->prepare("INSERT INTO favourites (user_id, product_id) VALUES (?, ?)")
                     ->execute([$_SESSION['id'], $product_id]);
            }

            // Редирект на предыдущую страницу без параметров
            $redirect_url = isset($_SERVER['HTTP_REFERER']) ? strtok($_SERVER['HTTP_REFERER'], '?') : './basket.php';
            header("Location: " . $redirect_url);
            exit;
        } catch (PDOException $e) {
            error_log("Ошибка: " . $e->getMessage());
        }
    }
}

// Получаем список избранных товаров
$favourites = [];
if (isset($_SESSION['login']) && isset($_SESSION['id'])) {
    try {
        $stmt = $conn->prepare("SELECT product_id FROM favourites WHERE user_id = ?");
        $stmt->execute([$_SESSION['id']]);
        $favourites = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    } catch (PDOException $e) {
        error_log("Ошибка: " . $e->getMessage());
    }
}

$query = $conn->prepare('select * from `basket` where user_id = ?');
$query->execute([$_SESSION['id']]);
$bascket = $query->fetchAll();

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
        <?php if(empty($bascket)): ?>
            <div class="empty-basket">
                <p>Ваша корзина пуста</p>
                <a href="../index.php">Перейти к покупкам</a>
            </div>
        <?php else: ?>
            <?php foreach($bascket as $key): ?>
            <?php
                $query = $conn->prepare('select * from products where id = ?');
                $query->execute([$key['product_id']]);
                $products = $query->fetchAll();
                
                $basket_id = $key['id'];
            ?>
            <?php foreach($products as $key): ?>
            <div class="basket_card">
                <div class="img_basket_product">
                    <a href="/pages/product.php?id=<?=$key['id']?>"><img src="../image/image_product/<?=$key['files']?>" alt="<?=htmlspecialchars($key['title'])?>"></a>
                </div>
                <div class="info_product">
                    <div class="price">
                        <a href="/pages/product.php?id=<?=$key['id']?>"><h1><?=htmlspecialchars($key['title'])?></h1></a> 
                        <p><?=htmlspecialchars($key['price'])?> ₽</p>
                    </div>
                    <div class="button">
                        <?php if(isset($_SESSION['login'])): ?>
                            <div class="like">
                                <?php $isFavourite = in_array($key['id'], $favourites); ?>
                                <a href="./basket.php?action=toggle_favourite&product_id=<?=$key['id']?>">
                                    <img src="../image/Image_system/icons8-heart-50<?=$isFavourite ? ' (1)' : ''?>.png" 
                                         alt="<?=$isFavourite ? 'Удалить из избранного' : 'В избранное'?>">
                                </a>
                            </div>
                            <div class="bascet">
                                <a href="../core/Controllers/PostController.php?action=deleteBasketProduct&&id=<?=$basket_id?>" 
                                   onclick="return confirm('Удалить товар из корзины?')">Удалить из корзины</a>
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
            <?php endforeach; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>

    <div class="conteiner_zero">
        <footer>
            <div class="footer">
                <div class="nav_item">
                    <a href="./login.php"><img src="../image/Image_system/icons8-человек-48.png" alt="Профиль"></a>
                    <?php if(isset($_SESSION['login'])): ?>
                        <a href="../core/Controllers/UserController.php?action=logout">Выход</a>                
                    <?php else: ?>
                        <a href="./login.php">Вход</a>        
                    <?php endif; ?>

                    <?php if(isset($_SESSION['login'])): ?>
                        <label for="hd-1"><p><?=htmlspecialchars($_SESSION['login'])?></p></label>
                    <?php endif; ?>
                </div>
                <div class="nav_item">
                    <a href="./orders.php"><img src="../image/Image_system/icons8-коробка-128 (1).png" alt="Заказы"></a>
                    <a href="./orders.php">Заказы</a>
                </div>
                <div class="nav_item">
                    <a href="./favourites.php"><img src="../image/Image_system/icons8-сердце-50 (2).png" alt="Избранное"></a>
                    <a href="./favourites.php">Избранное</a>
                </div>
                <div class="nav_item">
                    <a href="./basket.php"><img src="../image/Image_system/icons8-корзины-32.png" alt="Корзина"></a>
                    <a href="./basket.php">Корзина</a>
                </div>
            </div>
        </footer>
    </div>

    <script src="../scripts/theme.js"></script>
    <script src="../scripts/script.js"></script>
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