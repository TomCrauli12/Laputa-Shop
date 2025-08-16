<?php
session_start();

require_once __DIR__ . '/DB/start.php';
require_once __DIR__ . '/core/Modules/UserModel.php';
require_once __DIR__ . '/core/Modules/PostModel.php';

$conn = DB::getConnection();

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

// Получаем категории для меню
$category = $conn->query('SELECT * FROM category')->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="color-scheme" content="light dark">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/style/style.css">
    <link rel="stylesheet" href="/style/medea.css">
    <title>Laputa | Главная</title>
</head>
<body>
    <nav class="navbar">
        <div class="nav">
            <a href="/pages/payment.html">Оплата и доставка</a>
            <a href="/pages/Refund.html">Возврат и обмен</a>
            <a href="/pages/about.html">О нас</a>
            <a href="/pages/contact.html">Контакты</a>
            <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                <a href="/pages/create_product.php">Добавить товар</a>
                <a href="/pages/addToSlider.php">Добавить слайдер</a>
                <a href="/pages/createCategory.php">Создать категорию</a>
                <a href="/pages/createInfoBlock.php">Создать инфоблок</a>
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
            <a href="#"><img src="/image/Image_system/icons8-vk-50.png" alt="Вконтакте"></a>
            <div class="logo_contact">
                <a href="/index.php"><h1>Laputa</h1></a>
            </div>
            <a href="#"><img src="/image/Image_system/icons8-телеграм-50.png" alt="Телеграм"></a>
        </div>
    </nav>


    <header>
        <div class="header_left">
            <div class="logo">
                <a href="/index.php"><h1>Laputa</h1></a>
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
                            <a href="/pages/category.php?name=<?=urlencode($category['categoryName'])?>">
                                <?=htmlspecialchars($category['categoryName'])?>
                            </a>
                        <?php endforeach; ?>
                    </nav>
                </div>
            </div>
        </div>

        <div class="sean">
            <form class="search" action="/pages/search.php" method="get">
                <input type="search" name="query" placeholder="Введите запрос..." required>
                <button type="submit">Найти</button>
            </form>   
        </div>

        <div class="header_right">
            <div class="nav_item">
                <a href="/pages/login.php"><img src="/image/Image_system/icons8-человек-48.png" alt="Профиль"></a>
                <?php if(isset($_SESSION['login'])): ?>
                    <a href="/core/Controllers/UserController.php?action=logout">Выход</a>
                    <label for="hd-1"><p><?=htmlspecialchars($_SESSION['login'])?></p></label>
                <?php else: ?>
                    <a href="/pages/login.php">Вход</a>
                <?php endif; ?>
            </div>
            <div class="nav_item">
                <a href="/pages/orders.php"><img src="/image/Image_system/icons8-коробка-128 (1).png" alt="Заказы"></a>
                <a href="/pages/orders.php">Заказы</a>
            </div>
            <div class="nav_item">
                <?php if(isset($_SESSION['login'])): ?>
                    <a href="/pages/favourites.php"><img src="/image/Image_system/icons8-сердце-50 (2).png" alt="Избранное"></a>
                    <a href="/pages/favourites.php">Избранное</a>
                <?php else: ?>
                    <a href="/pages/login.php"><img src="/image/Image_system/icons8-сердце-50 (2).png" alt="Избранное"></a>
                    <a href="/pages/login.php">Избранное</a>
                <?php endif; ?>
            </div>
            <div class="nav_item">
                <?php if(isset($_SESSION['login'])): ?>
                    <a href="/pages/basket.php"><img src="/image/Image_system/icons8-корзины-32.png" alt="Корзина"></a>
                    <a href="/pages/basket.php">Корзина</a>
                <?php else: ?>
                    <a href="/pages/login.php"><img src="/image/Image_system/icons8-корзины-32.png" alt="Корзина"></a>
                    <a href="/pages/login.php">Корзина</a>
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
                    <a href="/pages/categoryMore.php?block=<?=urlencode($blockDBName)?>">Смотреть больше</a>
                </div>
                
                <?php if(!empty($block['products'])): ?>
                <div class="product_grid">
                    <?php foreach ($block['products'] as $product): ?>
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
                                    <a href="/core/Controllers/PostController.php?action=AddToFavourites&product_id=<?=$product['id']?>&return_url=<?=urlencode($_SERVER['REQUEST_URI'])?>">
                                        <img src="/image/Image_system/icons8-сердце-50 (2).png" alt="В избранное">
                                    </a>
                                </div>
                            <?php else: ?>
                                <div class="bascet">
                                    <a href="/pages/login.php">В корзину</a>
                                </div>
                                <div class="like">
                                    <a href="/pages/login.php">
                                        <img src="/image/Image_system/icons8-сердце-50 (2).png" alt="В избранное">
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <?php if(isset($_SESSION['role']) && $_SESSION['role'] == "admin"): ?>
                            <div class="admin_buttons">
                                <a href="./pages/editProduct.php?id=<?=$product['id']?>" 
                                   class="edit_btn">Редактировать</a>
                                <a href="/core/Controllers/PostController.php?action=deleteProduct&id=<?=$product['id']?>" 
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


    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3>Магазин</h3>
                <?php foreach(array_slice($categories, 0, 3) as $category): ?>
                    <a href="/pages/category.php?name=<?=urlencode($category['categoryName'])?>">
                        <?=htmlspecialchars($category['categoryName'])?>
                    </a>
                <?php endforeach; ?>
            </div>
            <div class="footer-section">
                <h3>Информация</h3>
                <a href="/pages/payment.html">Оплата и доставка</a>
                <a href="/pages/Refund.html">Возврат</a>
                <a href="/pages/about.html">О нас</a>
            </div>
            <div class="footer-section">
                <h3>Контакты</h3>
                <p>Email: info@laputa.ru</p>
                <p>Телефон: +7 (123) 456-78-90</p>
                <div class="social-links">
                    <a href="#"><img src="/image/Image_system/icons8-vk-50.png" alt="Вконтакте"></a>
                    <a href="#"><img src="/image/Image_system/icons8-телеграм-50.png" alt="Телеграм"></a>
                </div>
            </div>
        </div>
        <div class="copyright">
            <p>&copy; <?=date('Y')?> Laputa. Все права защищены.</p>
        </div>
    </footer>


<script src="/scripts/script.js"></script>
<script src="./scripts/theme.js"></script>
</body>
</html>