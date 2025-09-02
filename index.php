<?php
session_start();

require_once __DIR__ . '/DB/start.php';
require_once __DIR__ . '/core/Controllers/PoductController.php';
require_once __DIR__ . '/core/Modules/UserModel.php';
require_once __DIR__ . '/core/Modules/PostModel.php';

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
    <link rel="stylesheet" href="/Laputa-Shop/style/static.css">
    <link rel="stylesheet" href="/Laputa-Shop/style/style.css">
    <link rel="stylesheet" href="./style/media/medea.css">
    <title>Laputa | Главная</title>
</head>
<body>
    <nav class="navbar">
        <div class="nav">
            <a href="/Laputa-Shop/pages/payment.php">Оплата и доставка</a>
            <a href="/Laputa-Shop/pages/Refund.php">Возврат и обмен</a>
            <a href="/Laputa-Shop/pages/about.php">О нас</a>
            <a href="/Laputa-Shop/pages/contact.php">Контакты</a>
            <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                <a href="/Laputa-Shop/pages/adminPanel.php">AdminPanel</a>
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
            <a href="#"><img src="/Laputa-Shop/image/Image_system/icons8-vk-50.png" alt="Вконтакте"></a>
            <a href="#"><img src="/Laputa-Shop/image/Image_system/icons8-телеграм-50.png" alt="Телеграм"></a>
        </div>
    </nav>

    <header>
        <div class="header_left">
            <div class="logo">
                <a href="/Laputa-Shop/index.php"><h1>Laputa</h1></a>
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
                            <a href="/Laputa-Shop/pages/category.php?name=<?=urlencode($category['categoryName'])?>">
                                <?=htmlspecialchars($category['categoryName'])?>
                            </a>
                        <?php endforeach; ?>
                    </nav>
                </div>
            </div>
        </div>

        <div class="sean">
            <form class="search" action="/Laputa-Shop/pages/search.php" method="get">
                <input type="search" name="query" placeholder="Введите запрос..." required>
                <button type="submit">Найти</button>
            </form>   
        </div>

        <div class="header_right">
            <div class="nav_item">
                <a href="/Laputa-Shop/pages/login.php"><img src="/Laputa-Shop/image/Image_system/icons8-человек-48.png" alt="Профиль"></a>
                <?php if(isset($_SESSION['login'])): ?>
                    <a href="/Laputa-Shop/core/Controllers/UserController.php?action=logout">Выход</a>
                    <label for="hd-1"><p><?=htmlspecialchars($_SESSION['login'])?></p></label>
                <?php else: ?>
                    <a href="/Laputa-Shop/pages/login.php">Вход</a>
                <?php endif; ?>
            </div>
            <div class="nav_item">
                <a href="/Laputa-Shop/pages/orders.php"><img src="/Laputa-Shop/image/Image_system/icons8-коробка-128 (1).png" alt="Заказы"></a>
                <a href="/Laputa-Shop/pages/orders.php">Заказы</a>
            </div>
            <div class="nav_item">
                <?php if(isset($_SESSION['login'])): ?>
                    <a href="/Laputa-Shop/pages/favourites.php"><img src="/Laputa-Shop/image/Image_system/icons8-сердце-50 (2).png" alt="Избранное"></a>
                    <a href="/Laputa-Shop/pages/favourites.php">Избранное</a>
                <?php else: ?>
                    <a href="/Laputa-Shop/pages/login.php"><img src="/Laputa-Shop/image/Image_system/icons8-сердце-50 (2).png" alt="Избранное"></a>
                    <a href="/Laputa-Shop/pages/login.php">Избранное</a>
                <?php endif; ?>
            </div>
            <div class="nav_item">
                <?php if(isset($_SESSION['login'])): ?>
                    <a href="/Laputa-Shop/pages/basket.php"><img src="/Laputa-Shop/image/Image_system/icons8-корзины-32.png" alt="Корзина"></a>
                    <a href="/Laputa-Shop/pages/basket.php">Корзина</a>
                <?php else: ?>
                    <a href="/Laputa-Shop/pages/login.php"><img src="/Laputa-Shop/image/Image_system/icons8-корзины-32.png" alt="Корзина"></a>
                    <a href="/Laputa-Shop/pages/login.php">Корзина</a>
                <?php endif; ?>
            </div>
        </div>
    </header>
    
    <section class="slider">
        <div class="slides-container">
            <?php foreach($sliders as $slide): ?>
            <div class="slide">
                <a href=""><img src="/Laputa-Shop/image/slider/<?=htmlspecialchars($slide['imageslider'])?>" alt="Слайд"></a>
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
                    <a href="/Laputa-Shop/pages/categoryMore.php?block=<?=urlencode($blockDBName)?>">Смотреть больше</a>
                </div>
                
                <?php if(!empty($block['products'])): ?>
                <div class="product_grid">
                    <?php foreach ($block['products'] as $product): ?>
                    <div class="card">
                        <div class="img_product">
                            <a href="/Laputa-Shop/pages/product.php?id=<?=$product['id']?>">
                                <img src="/Laputa-Shop/image/image_product/<?=htmlspecialchars($product['files'])?>" 
                                     alt="<?=htmlspecialchars($product['title'])?>">
                            </a>
                        </div>
                        <div class="price">
                            <a href="/Laputa-Shop/pages/product.php?id=<?=$product['id']?>">
                                <h3><?=htmlspecialchars($product['title'])?></h3>
                            </a> 
                            <p><?=htmlspecialchars($product['price'])?> ₽</p>
                        </div>
                        <div class="button">
                            <?php if(isset($_SESSION['login']) && isset($_SESSION['id'])): ?>
                                <div class="bascet">
                                    <?php $inBasket = in_array($product['id'], $basketItems); ?>
                                    <?php if($inBasket): ?>
                                        <a href="/Laputa-Shop/pages/basket.php" class="in-basket">
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
                                        <img src="/Laputa-Shop/image/Image_system/icons8-heart-50<?=$isFavourite ? ' (1)' : ''?>.png" 
                                            alt="<?=$isFavourite ? 'Удалить из избранного' : 'В избранное'?>">
                                    </button>
                                </div>
                            <?php else: ?>
                                <div class="bascet">
                                    <a href="/Laputa-Shop/pages/login.php">В корзину</a>
                                </div>
                                <div class="like">
                                    <a href="/Laputa-Shop/pages/login.php">
                                        <img src="/Laputa-Shop/image/Image_system/icons8-heart-50.png" alt="В избранное">
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <?php if(isset($_SESSION['role']) && $_SESSION['role'] == "admin"): ?>
                            <div class="admin_buttons">
                                <a href="/Laputa-Shop/adminPages/editProduct.php?id=<?=$product['id']?>" 
                                   class="edit_btn">Редактировать</a>
                                <a href="/Laputa-Shop/core/Controllers/PostController.php?action=deleteProduct&id=<?=$product['id']?>" 
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

    <script src="/Laputa-Shop/scripts/script.js"></script>
    <script src="/Laputa-Shop/scripts/theme.js"></script>
    <script src="/Laputa-Shop/scripts/ajax.js"></script>
</body>
</html>