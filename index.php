<?php
session_start();

require_once __DIR__ . '/DB/start.php';
require_once __DIR__ . '/core/Modules/UserModel.php';
require_once __DIR__ . '/core/Modules/PostModel.php';

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

// Обработка корзины ДО любого вывода
if (isset($_GET['action']) && $_GET['action'] === 'toggle_basket' && isset($_SESSION['id'])) {
    $product_id = (int)($_GET['product_id'] ?? 0);
    
    if ($product_id > 0) {
        try {
            // Проверяем наличие товара в корзине
            $stmt = $conn->prepare("SELECT id FROM basket WHERE user_id = ? AND product_id = ?");
            $stmt->execute([$_SESSION['id'], $product_id]);
            $basketItem = $stmt->fetch();

            if ($basketItem) {
                // Редирект в корзину, если товар уже там
                header("Location: /pages/basket.php");
                exit;
            } else {
                // Добавляем в корзину
                $conn->prepare("INSERT INTO basket (user_id, product_id, quantity) VALUES (?, ?, 1)")
                     ->execute([$_SESSION['id'], $product_id]);
            }

            // Редирект на предыдущую страницу без параметров
            $redirect_url = isset($_SERVER['HTTP_REFERER']) ? strtok($_SERVER['HTTP_REFERER'], '?') : '/index.php';
            header("Location: " . $redirect_url);
            exit;
        } catch (PDOException $e) {
            error_log("Ошибка корзины: " . $e->getMessage());
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

// Получаем слайдеры
$sliders = $conn->query('SELECT * FROM sliders')->fetchAll();
// Получаем информационные блоки и их товары
$infoBlocks = $conn->query('SELECT * FROM infoblock')->fetchAll(PDO::FETCH_ASSOC);
$blocksData = [];

foreach ($infoBlocks as $block) {
    $blockDBName = $block['infoBlockDBName'];
    $blockDisplayName = $block['infoBlockName'];
    
    $blocksData[$blockDBName] = [
        'name' => $blockDisplayName,
        'products' => infoBlock::getProductsByBlockDBName($blockDBName)
    ];
}

// категории для меню
$category = $conn->query('SELECT * FROM category')->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="color-scheme" content="light dark">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/static.css">
    <link rel="stylesheet" href="./style/style.css">
    <link rel="stylesheet" href="./style/medea.css">
    <title>Laputa | Главная</title>
</head>
<body>
    <nav class="navbar">
        <div class="nav">
            <a href="./pages/payment.php">Оплата и доставка</a>
            <a href="./pages/Refund.php">Возврат и обмен</a>
            <a href="./pages/about.php">О нас</a>
            <a href="./pages/contact.php">Контакты</a>
            <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                <a href="./pages/adminPanel.php">AdminPanel</a>
            <?php endif; ?>
        </div>
        <div class="contact">
            <div class="theme-switcher">
                <label for="theme-toggle-checkbox" class="theme-switcher__label">
                    <span class="theme-switcher__text">Светлая</span>
                    <span class="theme-switcher__toggle-wrap">
                        <input id="theme-toggle-checkbox" class="theme-switcher__toggle" type="checkbox" role="switch">
                        <span class="theme-switcher__slider"></span>
                    </span>
                    <span class="theme-switcher__text">Тёмная</span>
                </label>
            </div>
            <a href="#"><img src="./image/Image_system/icons8-vk-50.png" alt="Вконтакте"></a>
            <div class="logo_contact">
                <a href="./index.php"><h1>Laputa</h1></a>
            </div>
            <a href="#"><img src="./image/Image_system/icons8-телеграм-50.png" alt="Телеграм"></a>
        </div>
    </nav>

    <header>
        <div class="header_left">
            <div class="logo">
                <a href="./index.php"><h1>Laputa</h1></a>
            </div>
            
            <div class="burger-checkbox">
                <input type="checkbox" id="burger-checkbox" />
                <label for="burger-checkbox">
                    <div class="burger"></div>
                </label>

                <a href="#" id="catalog-link">Каталог</a>
                <div class="info-block">
                    <nav class="categories">
                        <?php foreach($category as $category): ?>
                            <a href="./pages/category.php?name=<?=urlencode($category['categoryName'])?>">
                                <?=htmlspecialchars($category['categoryName'])?>
                            </a>
                        <?php endforeach; ?>
                    </nav>
                </div>
            </div>
        </div>

        <div class="sean">
            <form class="search" action="./pages/search.php" method="get">
                <input type="search" name="query" placeholder="Введите запрос..." required>
                <button type="submit">Найти</button>
            </form>   
        </div>

        <div class="header_right">
            <div class="nav_item">
                <a href="./pages/login.php"><img src="./image/Image_system/icons8-человек-48.png" alt="Профиль"></a>
                <?php if(isset($_SESSION['login'])): ?>
                    <a href="./core/Controllers/UserController.php?action=logout">Выход</a>
                    <label for="hd-1"><p><?=htmlspecialchars($_SESSION['login'])?></p></label>
                <?php else: ?>
                    <a href="./pages/login.php">Вход</a>
                <?php endif; ?>
            </div>
            <div class="nav_item">
                <a href="./pages/orders.php"><img src="./image/Image_system/icons8-коробка-128 (1).png" alt="Заказы"></a>
                <a href="./pages/orders.php">Заказы</a>
            </div>
            <div class="nav_item">
                <?php if(isset($_SESSION['login'])): ?>
                    <a href="./pages/favourites.php"><img src="./image/Image_system/icons8-сердце-50 (2).png" alt="Избранное"></a>
                    <a href="./pages/favourites.php">Избранное</a>
                <?php else: ?>
                    <a href="./pages/login.php"><img src="./image/Image_system/icons8-сердце-50 (2).png" alt="Избранное"></a>
                    <a href="./pages/login.php">Избранное</a>
                <?php endif; ?>
            </div>
            <div class="nav_item">
                <?php if(isset($_SESSION['login'])): ?>
                    <a href="./pages/basket.php"><img src="./image/Image_system/icons8-корзины-32.png" alt="Корзина"></a>
                    <a href="./pages/basket.php">Корзина</a>
                <?php else: ?>
                    <a href="./pages/login.php"><img src="./image/Image_system/icons8-корзины-32.png" alt="Корзина"></a>
                    <a href="./pages/login.php">Корзина</a>
                <?php endif; ?>
            </div>
        </div>
    </header>
    
    <section class="slider">
        <div class="slides-container">
            <?php foreach($sliders as $slide): ?>
            <div class="slide">
                <a href=""><img src="./image/slider/<?=htmlspecialchars($slide['imageslider'])?>" alt="Слайд"></a>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="slider-controls">
            <button class="slider-prev">‹</button>
            <div class="slider-dots">
                <?php foreach($sliders as $index => $slide): ?>
                <button class="slider-dot <?= $index === 0 ? 'active' : '' ?>"></button>
                <?php endforeach; ?>
            </div>
            <button class="slider-next">›</button>
        </div>
    </section>

    <main>
        <?php foreach ($blocksData as $blockDBName => $block): ?>
        <section class="product_block">
            <div class="container">
                <div class="section_name">
                    <h2><?=htmlspecialchars($block['name'])?></h2>
                    <a href="./pages/categoryMore.php?block=<?=urlencode($blockDBName)?>">Смотреть больше</a>
                </div>
                
                <?php if(!empty($block['products'])): ?>
                <div class="product_grid">
                    <?php foreach ($block['products'] as $product): ?>
                    <div class="card">
                        <div class="img_product">
                            <a href="./pages/product.php?id=<?=$product['id']?>">
                                <img src="./image/image_product/<?=htmlspecialchars($product['files'])?>" 
                                     alt="<?=htmlspecialchars($product['title'])?>">
                            </a>
                        </div>
                        <div class="price">
                            <a href="./pages/product.php?id=<?=$product['id']?>">
                                <h3><?=htmlspecialchars($product['title'])?></h3>
                            </a> 
                            <p><?=htmlspecialchars($product['price'])?> ₽</p>
                        </div>
                        <div class="button">
                            <?php if(isset($_SESSION['login']) && isset($_SESSION['id'])): ?>
                                <div class="bascet">
                                    <?php $inBasket = in_array($product['id'], $basketItems); ?>
                                    <?php if($inBasket): ?>
                                        <a href="./pages/basket.php" class="in-basket">
                                            Товар в корзине
                                        </a>
                                    <?php else: ?>
                                        <a href="./core/Controllers/PostController.php?action=AddToBasket&product_id=<?=$product['id']?>">
                                            В корзину
                                        </a>
                                    <?php endif; ?>
                                </div>
                                <div class="like">
                                    <?php $isFavourite = in_array($product['id'], $favourites); ?>
                                    <a href="./index.php?action=toggle_favourite&product_id=<?=$product['id']?>">
                                        <img src="./image/Image_system/icons8-heart-50<?=$isFavourite ? ' (1)' : ''?>.png" 
                                            alt="<?=$isFavourite ? 'Удалить из избранного' : 'В избранное'?>">
                                    </a>
                                </div>
                            <?php else: ?>
                                <div class="bascet">
                                    <a href="./pages/login.php">В корзину</a>
                                </div>
                                <div class="like">
                                    <a href="./pages/login.php">
                                        <img src="./image/Image_system/icons8-heart-50.png" alt="В избранное">
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <?php if(isset($_SESSION['role']) && $_SESSION['role'] == "admin"): ?>
                            <div class="admin_buttons">
                                <a href="./adminPages/editProduct.php?id=<?=$product['id']?>" 
                                   class="edit_btn">Редактировать</a>
                                <a href="./core/Controllers/PostController.php?action=deleteProduct&id=<?=$product['id']?>" 
                                   class="delete_btn" 
                                   onclick="return confirm('Удалить этот товар?')">Удалить</a>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                    <p class="no-products">Товары отсутствуют</p>
                <?php endif; ?>
            </div>
        </section>
        <?php endforeach; ?>
    </main>

<?php require_once './includes/footer.php'; ?>

    <script src="./scripts/script.js"></script>
    <script src="./scripts/theme.js"></script>
</body>
</html>