<?php 
session_start();

require_once '../DB/start.php';
require_once '../core/Modules/PostModel.php';

$conn = DB::getConnection();

$category = $conn->query('SELECT * FROM category')->fetchAll();

// Получаем имя блока из параметра 
$blockDBName = $_GET['block'] ?? '';
$name = "Манга"; // Значение по умолчанию

// Получаем отображаемое имя блока из базы данных
if (!empty($blockDBName)) {
    $stmt = $conn->prepare("SELECT infoBlockName FROM infoblock WHERE infoBlockDBName = ?");
    $stmt->execute([$blockDBName]);
    $block = $stmt->fetch(PDO::FETCH_ASSOC);
    $name = $block['infoBlockName'] ?? $name;
}


$min_value = isset($_GET['min_value']) ? (int)$_GET['min_value'] : 100;
$max_value = (isset($_GET['max_value']) && $_GET['max_value'] > 0) ? (int)$_GET['max_value'] : 100000;

if(isset($_GET['min_value']) && isset($_GET['max_value'])) {
    $products = PostModel::getSort($min_value, $max_value, $blockDBName);
} else {
    $products = PostModel::getinfoConteiner($blockDBName);
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laputa | <?=htmlspecialchars($name)?></title>
    <link rel="stylesheet" href="../style/static.css">
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../style/category.css">
    <link rel="stylesheet" href="../style/medea.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav">
            <a href="./payment.html">Оплата и доставка</a>
            <a href="./Refund.html">Возврат и обмен</a>
            <a href="./about.html">О нас</a>
            <a href="./contact.html">Контакты</a>
            <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                <a href="./create_product.php">Добавить товар</a>
                <a href="./addToSlider.php">Добавить слайдер</a>
                <a href="./createCategory.php">Создать категорию</a>
                <a href="./createInfoBlock.php">Создать информационный блок</a>
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
            <a href="#"><img src="../image/Image_system/icons8-vk-50.png" alt="Вк"></a>
            <div class="logo_contact">
                <a href="../index.php"><h1>Laputa</h1></a>
            </div>
            <a href="#"><img src="../image/Image_system/icons8-телеграм-50.png" alt="Тг"></a>
        </div>
    </nav>

    <header>
        <div class="header_left">
            <div class="logo">
                <a href="../index.php"><h1>Laputa</h1></a>
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
            <form class="search" action="./search.php" method="get">
                <input type="search" name="query" placeholder="Введите запрос..." required>
                <button type="submit">Найти</button>
            </form>   
        </div>

        <div class="header_right">
            <div class="nav_item">
                <a href="./login.php"><img src="../image/Image_system/icons8-человек-48.png" alt="Профиль"></a>
                <?php if(isset($_SESSION['login'])): ?>
                    <a href="../core/Controllers/UserController.php?action=logout">Выход</a>
                    <label for="hd-1"><p><?=htmlspecialchars($_SESSION['login'])?></p></label>
                <?php else: ?>
                    <a href="./login.php">Вход</a>
                <?php endif; ?>
            </div>
            <div class="nav_item">
                <a href="./orders.php"><img src="../image/Image_system/icons8-коробка-128 (1).png" alt="Заказы"></a>
                <a href="./orders.php">Заказы</a>
            </div>

            <div class="nav_item">
                <?php if(isset($_SESSION['login'])): ?>
                    <a href="./favourites.php"><img src="../image/Image_system/icons8-сердце-50 (2).png" alt="Избранное"></a>
                    <a href="./favourites.php">Избранное</a>
                <?php else: ?>
                    <a href="./login.php"><img src="../image/Image_system/icons8-сердце-50 (2).png" alt="Избранное"></a>
                    <a href="./login.php">Избранное</a>
                <?php endif; ?>
            </div>
            
            <div class="nav_item">
                <?php if(isset($_SESSION['login'])): ?>
                    <a href="./basket.php"><img src="../image/Image_system/icons8-корзины-32.png" alt="Корзина"></a>
                    <a href="./basket.php">Корзина</a>
                <?php else: ?>
                    <a href="./login.php"><img src="../image/Image_system/icons8-корзины-32.png" alt="Корзина"></a>
                    <a href="./login.php">Корзина</a>
                <?php endif; ?>
            </div>
        </div>
    </header>
    
    <main>
        <div class="name"><h1><?=htmlspecialchars($name)?></h1></div>
        
        <section class="conteiner_product">
            <div class="sorting">
                <h2>Сортировка</h2>
                <form method="get">
                    <p>Цена</p>
                    <label for="min_value">От</label>
                    <input type="number" id="min_value" name="min_value" value="<?=$min_value?>"><br><br>
                    <label for="max_value">До</label>
                    <input type="number" id="max_value" name="max_value" value="<?=$max_value?>"><br><br>
                    <input type="hidden" name="block" value="<?=htmlspecialchars($blockDBName)?>">
                    <button type="submit">Применить</button>
                    <a href="./categoryMore.php?block=<?=urlencode($blockDBName)?>" class="reset-btn">Сбросить</a>
                </form>
            </div>
            
            <div class="product_grid">
                <?php foreach($products as $product): ?>
                <div class="card">
                    <div class="img_product">
                        <a href="./product.php?id=<?=$product['id']?>">
                            <img src="../image/image_product/<?=htmlspecialchars($product['files'])?>" alt="<?=htmlspecialchars($product['title'])?>">
                        </a>
                    </div>
                    <div class="price">
                        <a href="./product.php?id=<?=$product['id']?>"><h2><?=htmlspecialchars($product['title'])?></h2></a> 
                        <p><?=htmlspecialchars($product['price'])?> ₽</p>
                    </div>
                    <div class="button">
                        <div class="bascet">
                            <?php if(isset($_SESSION['login'])): ?>
                                <a href="../core/Controllers/PostController.php?action=AddToBasket&product_id=<?=$product['id']?>">добавить в корзину</a>
                            <?php else: ?>
                                <a href="./login.php">добавить в корзину</a>
                            <?php endif; ?>
                        </div>
                        <div class="like">
                            <?php if(isset($_SESSION['login'])): ?>
                                <a href="../core/Controllers/PostController.php?action=AddToFavourites&product_id=<?=$product['id']?>&return_url=<?=urlencode($_SERVER['REQUEST_URI'])?>">
                                    <img src="../image/Image_system/icons8-сердце-50 (2).png" alt="Избранное">
                                </a>
                            <?php else: ?>
                                <a href="./login.php">
                                    <img src="../image/Image_system/icons8-сердце-50 (2).png" alt="Избранное">
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <?php if(isset($_SESSION['role']) && $_SESSION['role'] == "admin"): ?>
                        <div class="admin_buttons">
                            <a href="../core/Controllers/PostController.php?action=editProduct&id=<?=$product['id']?>" class="edit_btn">Редактировать</a>
                            <a href="../core/Controllers/PostController.php?action=deleteProduct&id=<?=$product['id']?>" class="delete_btn" onclick="return confirm('Вы уверены, что хотите удалить этот товар?')">Удалить</a>
                        </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>  
            </div>
        </section>
    </main>

    <footer>
        <div class="footer">
            <div class="footer-section">
                <h3>О компании</h3>
                <a href="./about.html">О нас</a>
                <a href="./contact.html">Контакты</a>
            </div>
            <div class="footer-section">
                <h3>Помощь</h3>
                <a href="./payment.html">Оплата и доставка</a>
                <a href="./Refund.html">Возврат и обмен</a>
            </div>
            <div class="footer-section">
                <h3>Соцсети</h3>
                <a href="#"><img src="../image/Image_system/icons8-vk-50.png" alt="Вконтакте"></a>
                <a href="#"><img src="../image/Image_system/icons8-телеграм-50.png" alt="Телеграм"></a>
            </div>
        </div>
        <div class="copyright">
            <p>&copy; 2023 Laputa. Все права защищены.</p>
        </div>
    </footer>

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