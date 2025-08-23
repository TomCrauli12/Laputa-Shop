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
            $redirect_url = isset($_SERVER['HTTP_REFERER']) ? strtok($_SERVER['HTTP_REFERER'], '?') : '/index.php';
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

// Получаем все избранные товары с данными
$query = $conn->prepare('SELECT f.id as favourite_id, p.* FROM favourites f JOIN products p ON f.product_id = p.id WHERE f.user_id = ?');
$query->execute([$_SESSION['id']]);
$favouriteProducts = $query->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/static.css">
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../style/medea.css">
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
                    <a href="/pages/product.php?id=<?=$product['id']?>">
                        <img src="../image/image_product/<?=htmlspecialchars($product['files'])?>" alt="<?=htmlspecialchars($product['title'])?>">
                    </a>
                </div>
                <div class="price">
                    <a href="/pages/product.php?id=<?=$product['id']?>">
                        <h1><?=htmlspecialchars($product['title'])?></h1>
                    </a> 
                    <p><?=htmlspecialchars($product['price'])?> ₽</p>
                </div>
                <div class="button">
                    <?php if(isset($_SESSION['login'])): ?>
                        <div class="bascet">
                            <?php if($inBasket): ?>
                                <a href="/pages/basket.php" class="in-basket">
                                    Товар в корзине
                                </a>
                            <?php else: ?>
                                <a href="/core/Controllers/PostController.php?action=AddToBasket&product_id=<?=$product['id']?>">
                                    В корзину
                                </a>
                            <?php endif; ?>
                        </div>
                        <div class="like">
                            <?php $isFavourite = in_array($product['id'], $favourites); ?>
                            <a href="/index.php?action=toggle_favourite&product_id=<?=$product['id']?>">
                                <img src="/image/Image_system/icons8-heart-50<?=$isFavourite ? ' (1)' : ''?>.png" 
                                    alt="<?=$isFavourite ? 'Удалить из избранного' : 'В избранное'?>">
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="bascet">
                            <a href="/pages/login.php">В корзину</a>
                        </div>
                        <div class="like">
                            <a href="/pages/login.php">
                                <img src="/image/Image_system/icons8-heart-50.png" alt="В избранное">
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