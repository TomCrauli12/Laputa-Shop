<?php
session_start();

require_once '../DB/start.php';
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

            // Формируем URL для редиректа
            $redirect_url = $_SERVER['PHP_SELF'];
            $params = [];
            
            // Сохраняем все GET-параметры кроме action и product_id
            foreach ($_GET as $key => $value) {
                if ($key !== 'action' && $key !== 'product_id') {
                    $params[] = $key . '=' . urlencode($value);
                }
            }
            
            if (!empty($params)) {
                $redirect_url .= '?' . implode('&', $params);
            }
            
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


// Определяем, вызываем ли мы категорию или информационный блок
if (isset($_GET['name'])) {
    // Режим категории
    $categoryName = $_GET['name'] ?? "Манга";
    $pageTitle = $categoryName;
    
    // Получаем информацию о категории
    $stmt = $conn->prepare("SELECT * FROM category WHERE categoryName = ?");
    $stmt->execute([$categoryName]);
    $category = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$category) {
        header("Location: /index.php?error=category_not_found");
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
    
    $hidden_field = '<input type="hidden" name="name" value="'.htmlspecialchars($categoryName).'">';
    $reset_url = './category.php?name='.urlencode($categoryName);
    $current_page = 'category.php';
} elseif (isset($_GET['block'])) {
    // Режим информационного блока
    $blockDBName = $_GET['block'] ?? '';
    $name = "Манга"; // Значение по умолчанию

    // Получаем отображаемое имя блока из базы данных
    if (!empty($blockDBName)) {
        $stmt = $conn->prepare("SELECT infoBlockName FROM infoblock WHERE infoBlockDBName = ?");
        $stmt->execute([$blockDBName]);
        $block = $stmt->fetch(PDO::FETCH_ASSOC);
        $name = $block['infoBlockName'] ?? $name;
    }
    
    $pageTitle = $name;
    $categoryName = $name;

    $min_value = isset($_GET['min_value']) ? (int)$_GET['min_value'] : 100;
    $max_value = (isset($_GET['max_value']) && $_GET['max_value'] > 0) ? (int)$_GET['max_value'] : 100000;

    if(isset($_GET['min_value']) && isset($_GET['max_value'])) {
        $products = PostModel::getSort($min_value, $max_value, $blockDBName);
    } else {
        $products = PostModel::getinfoConteiner($blockDBName);
    }
    
    $hidden_field = '<input type="hidden" name="block" value="'.htmlspecialchars($blockDBName).'">';
    $reset_url = './categoryMore.php?block='.urlencode($blockDBName);
    $current_page = 'categoryMore.php';
} else {
    header("Location: /index.php");
    exit();
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
    <title>Laputa | <?=htmlspecialchars($pageTitle)?></title>
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
                <?=$hidden_field?>
                <button type="submit">Применить</button>
                <a href="<?=$reset_url?>" class="reset-btn">Сбросить</a>
            </form>
        </div>
        
        <section class="conteiner_product">
            <div class="name">
                <h1><?=htmlspecialchars($pageTitle)?></h1>
            </div>

            <div class="product_grid">
                <?php if(empty($products)): ?>
                    <p class="no-products">Товары в этой категории отсутствуют</p>
                <?php else: ?>
                    <?php foreach($products as $product): ?>
                    <div class="card">
                        <div class="img_product">
                            <a href="/pages/product.php?id=<?=$product['id']?>">
                                <img src="/image/image_product/<?=htmlspecialchars($product['files'])?>" 
                                    alt="<?=htmlspecialchars($product['title'])?>">
                            </a>
                        </div>
                        <div class="price">
                            <a href="/pages/product.php?id=<?=$product['id']?>">
                                <h3><?=htmlspecialchars($product['title'])?></h3>
                            </a> 
                            <p><?=htmlspecialchars($product['price'])?> ₽</p>
                        </div>
                        <div class="button">
                            <?php if(isset($_SESSION['login'])): ?>
                                <div class="bascet">
                                    <a href="/core/Controllers/PostController.php?action=AddToBasket&product_id=<?=$product['id']?>">
                                        В корзину
                                    </a>
                                </div>
                                <div class="like">
                                    <?php $isFavourite = in_array($product['id'], $favourites); ?>
                                    <?php
                                    // Формируем URL для избранного с сохранением всех параметров
                                    $favourite_url = $current_page . '?action=toggle_favourite&product_id=' . $product['id'];
                                    foreach ($_GET as $key => $value) {
                                        if ($key !== 'action' && $key !== 'product_id') {
                                            $favourite_url .= '&' . $key . '=' . urlencode($value);
                                        }
                                    }
                                    ?>
                                    <a href="<?=$favourite_url?>">
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
                        
                        <?php if(isset($_SESSION['role']) && $_SESSION['role'] == "admin"): ?>
                            <div class="admin_buttons">
                                <a href="../adminPages/editProduct.php?id=<?=$product['id']?>" 
                                class="edit_btn">Редактировать</a>
                                <a href="/core/Controllers/PostController.php?action=deleteProduct&id=<?=$product['id']?>" 
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