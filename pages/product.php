<?php
session_start();

require_once '../DB/start.php';
require_once '../core/Modules/PostModel.php';
require_once '../core/Modules/UserModel.php';

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
            $redirect_url = isset($_SERVER['HTTP_REFERER']) ? strtok($_SERVER['HTTP_REFERER'], '?') : '../index.php';
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

// Получаем список товаров в корзине
$basketItems = [];
if (isset($_SESSION['login']) && isset($_SESSION['id'])) {
    try {
        $stmt = $conn->prepare("SELECT product_id FROM basket WHERE user_id = ?");
        $stmt->execute([$_SESSION['id']]);
        $basketItems = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    } catch (PDOException $e) {
        error_log("Ошибка корзины: " . $e->getMessage());
    }
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
                            <a href="../core/Controllers/PostController.php?action=AddToBasket&product_id=<?=$product['id']?>">
                                В корзину
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="like">
                        <?php $isFavourite = in_array($product['id'], $favourites); ?>
                        <a href="../index.php?action=toggle_favourite&product_id=<?=$product['id']?>">
                            <img src="../image/Image_system/icons8-heart-50<?=$isFavourite ? ' (1)' : ''?>.png" 
                                alt="<?=$isFavourite ? 'Удалить из избранного' : 'В избранное'?>">
                        </a>
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
</body>
</html>