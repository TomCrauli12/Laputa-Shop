<?php session_start();

require_once './start.php';
require_once './scripts/UserModel.php';
require_once './scripts/PostModel.php';

$conn = DB::getConnection();

$query = $conn->prepare('select * from favourites where user_id = ?');
$query->execute([$_SESSION['id']]);
$favourites = $query->fetchAll();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/favourites.css">
    <link rel="stylesheet" href="./style/medea.css">
    <title>Laputa | Избранное</title>
</head>
<body>
<nav class="navbar">
        <div class="nav">
            <a href="./payment.html">Оплата и доставка</a>
            <a href="./Refund.html">Возврат и обмен</a>
            <a href="./about.html">О нас</a>
            <a href="./contact.html">Контакты</a>
            <a href="./create_product.html">Добавить товар</a>
        </div>
        <div class="contact">
            <a href=""><img src="./image/Image_system/icons8-vk-50.png" alt="Вк"></a>
            <div class="logo_contact">
                <a href="./index.php"><h1>Laputa</h1></a>
            </div>
            <a href=""><img src="./image/Image_system/icons8-телеграм-50.png" alt="Тг"></a>
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
            <a href="" id="catalog-link">Каталог</a>

            <script>
            const catalogLink = document.getElementById('catalog-link');
            const checkbox = document.getElementById('burger-checkbox');

            catalogLink.addEventListener('click', (e) => {
                e.preventDefault(); // prevent default link behavior
                checkbox.checked = !checkbox.checked; // toggle checkbox state
            });
            </script>
                
                    
                <div class="info-block">
                <nav class="categories">
                        <a href="/category.php?name=Манга">Манга</a>
                        <a href="/category.php?name=Одежда">Одежда</a>
                        <a href="/category.php?name=Постеры">Постеры</a>
                        <a href="/category.php?name=Стикерпаки">Стикерпаки</a>
                        <a href="/category.php?name=Наборы">Наборы</a>
                        <a href="/category.php?name=Фигурки">Фигурки</a>
                        <a href="/category.php?name=Ранобэ">Ранобэ</a>
                        <a href="/category.php?name=Значки">Значки</a>
                        <a href="/category.php?name=Косплеи">Косплеи</a>
                        <a href="/category.php?name=Продукция">Продукция</a>
                    </nav>
                </div>
              </div>
        </div>

        <div class="sean">
            <form class="search" action="">
                <input type="search" placeholder="Введите запрос..." required>
                <button type="submit">Найти</button>
            </form>   
        </div>

        <div class="header_right">
            <div class="nav_item">
                <a href="./login.php"><img src="./image/Image_system/icons8-человек-48.png" alt=""></a>
                                
                <?php if(isset($_SESSION['login'])): ?>
                    <a href="./logout.php">Выход</a>                
                <?php else: ?>
                    <a href="./login.php">Вход</a>        
                <?php endif; ?>

                <?php if(isset($_SESSION['login'])): ?>
                    <label for="hd-1" ><p><?=$_SESSION['login']?></p></label>
                <?php endif; ?>
            </div>
            <div class="nav_item">
                <a href=""><img src="./image/Image_system/icons8-коробка-128 (1).png" alt=""></a>
                <a href="">Заказы</a>
            </div>

            <?php if(isset($_SESSION['login'])): ?>
                <div class="nav_item">
                    <a href="./favourites.php"><img src="./image/Image_system/icons8-сердце-50 (2).png" alt=""></a>
                    <a href="./favourites.php">Избранное</a>
                </div>
                <div class="nav_item">
                    <a href="./basket.php"><img src="./image/Image_system/icons8-корзины-32.png" alt=""></a>
                    <a href="./basket.php">Корзина</a>
                </div>              
            <?php else: ?>
                <div class="nav_item">
                    <a href="./login.php"><img src="./image/Image_system/icons8-сердце-50 (2).png" alt=""></a>
                    <a href="./login.php">Избранное</a>
                </div>
                <div class="nav_item">
                    <a href="./login.php"><img src="./image/Image_system/icons8-корзины-32.png" alt=""></a>
                    <a href="./login.php">Корзина</a>
                </div>      
            <?php endif; ?>
        </div>
    </header>

    <section class="favourites_grid">
        <?php foreach($favourites as $key): ?>
        <?php
            
            $query = $conn->prepare('select * from products where id = ?');
            $query->execute([$key['product_id']]);
            $products = $query->fetchAll();

            $favourites_id = $key['id'];

        ?>
        <?php foreach($products as $key): ?>

        <div class="card">
                    <div class="img_product">
                        <a href=""><img src="./image/image_product/<?=$key['files']?>" alt=""></a>
                    </div>
                    <div class="price">
                        <a href=""><h1><?=$key['title']?></h1></a> 
                        <p><?=$key['price']?> ₽</p>
                    </div>
                    <div class="button">
                        <?php if(isset($_SESSION['login'])): ?>
                            <div class="bascet">
                                <a href="./scripts/PostController.php?action=AddToBasket&&product_id=<?=$key['id']?>">добавить в корзину</a>
                            </div>
                            <div class="like">
                                <a href="./scripts/PostController.php?action=deleteFavourites&&id=<?=$favourites_id?>"><img src="./image/Image_system/icons8red-сердце-50 (2).png" alt="избранное"></a>
                            </div>
                        <?php else: ?>
                            <a href="">В вашем избранном ничего нету</a>
                            <a href="">Перейти к категориям</a>
                            <?php endif; ?>
                        </div>
                    </div>
        <?php endforeach; ?>
        <?php endforeach; ?>
    </section>





    <!-- если cуществует id сессии и id сессии равен id пользователя котоырй опубликовал пост появиться то или иное сообщение -->
        

    
   




































    <div class="conteiner_zero">

    <footer>
        <div class="footer">
            <div class="nav_item">
                <a href="./login.php"><img src="./image/Image_system/icons8-человек-48.png" alt=""></a>
                <?php if(isset($_SESSION['login'])): ?>
                    <a href="./logout.php">Выход</a>                
                <?php else: ?>
                    <a href="./login.php">Вход</a>        
                <?php endif; ?>
            </div>
            <div class="nav_item">
                <a href=""><img src="./image/Image_system/icons8-коробка-128 (1).png" alt=""></a>
                <a href="">Заказы</a>
            </div>
            <div class="nav_item">
                <a href="./favourites.php"><img src="./image/Image_system/icons8-сердце-50 (2).png" alt=""></a>
                <a href="./favourites.php">Избранное</a>
            </div>
            <div class="nav_item">
                <a href="./basket.php"><img src="./image/Image_system/icons8-корзины-32.png" alt=""></a>
                <a href="./basket.php">Корзина</a>
            </div>
        </div>
    </footer>
</body>
</html>