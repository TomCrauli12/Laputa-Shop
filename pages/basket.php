<?php session_start();

require_once '../DB/start.php';
require_once '../core/Modules/UserModel.php';
require_once '../core/Modules/PostModel.php';

$conn = DB::getConnection();

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
                        <?php foreach($listcategory as $category): ?>
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


    <section class="basket_grid">
        <?php foreach($bascket as $key): ?>
        <?php
            
            $query = $conn->prepare('select * from products where id = ?');
            $query->execute([$key['product_id']]);
            $products = $query->fetchAll();
            
            $basket_id = $key['id'];
            //передаем id ибо он не передается так как выводятся все товары из таблицы продукт и выводятся product_id

        ?>
        <?php foreach($products as $key): ?>

        <div class="basket_card">
                    <div class="img_basket_product">
                        <a href=""><img src="../image/image_product/<?=$key['files']?>" alt=""></a>
                    </div>
                    <div class="info_product">
                        <div class="price">
                            <a href=""><h1><?=$key['title']?></h1></a> 
                            <p><?=$key['price']?> ₽</p>
                        </div>
                        <div class="button">
                            <?php if(isset($_SESSION['login'])): ?>
                                <div class="like">
                                    <a href="../core/Controllers/PostController.php?action=AddToFavouriteFromBasket&&product_id=<?=$key['id']?>"><img src="../image/Image_system/icons8-сердце-50 (2).png" alt="избранное"></a>
                                </div>
                                <div class="bascet">
                                    <a href="../core/Controllers/PostController.php?action=deleteBasketProduct&&id=<?=$basket_id?>">Удалить из корзины</a>
                                </div>
                            <?php else: ?>
                                <a href="">В вашем корзине ничего нету</a>
                                <a href="">Перейти к категориям</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
        <?php endforeach; ?>
        <?php endforeach; ?>
    </section>












































    <div class="conteiner_zero">

    <footer>
        <div class="footer">
            <div class="nav_item">
                <a href="./login.php"><img src="../image/Image_system/icons8-человек-48.png" alt=""></a>
                <?php if(isset($_SESSION['login'])): ?>
                    <a href="../core/Controllers/UserController.php?action=logout">Выход</a>                
                <?php else: ?>
                    <a href="./login.php">Вход</a>        
                <?php endif; ?>

                <?php if(isset($_SESSION['login'])): ?>
                    <label for="hd-1" ><p><?=$_SESSION['login']?></p></label>
                <?php endif; ?>
            </div>
            <div class="nav_item">
                <a href=""><img src="../image/Image_system/icons8-коробка-128 (1).png" alt=""></a>
                <a href="">Заказы</a>
            </div>
            <div class="nav_item">
                <a href="./favourites.php"><img src="../image/Image_system/icons8-сердце-50 (2).png" alt=""></a>
                <a href="./favourites.php">Избранное</a>
            </div>
            <div class="nav_item">
                <a href="./basket.php"><img src="../image/Image_system/icons8-корзины-32.png" alt=""></a>
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

















