<?php session_start();

require_once './start.php';
require_once './scripts/PostModel.php';


$conn = DB::getConnection();

$products = [];

isset($_GET['name']) ? $name = $_GET['name'] : $name = "Манга";

isset($_GET['min_value']) ? $min_value = $_GET['min_value'] : $min_value = 100;
//isset - если сущетвует передющаяся мин величина ?(это обозначение консрукции if else) =(if) передается значение :(else) нет то она будет равна 1

isset($_GET['max_value']) && $_GET['max_value'] >0 ? $max_value = $_GET['max_value'] : $max_value = 100000;





isset($_GET['name']) ? $name = $_GET['name'] : $name = "Новые товары";

if(isset($_GET['min_value']) && isset($_GET['max_value'])){

    $products = PostModel::getSort($min_value,$max_value,$name);
    
}
else{

    $products = PostModel::getinfoConteiner($name);
}

?>













<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/category.css">
    <link rel="stylesheet" href="./style/medea.css">
    <title>Laputa | <?=$_GET['name']?></title>
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
    
        <div class="name"><h1><?=$_GET['name']?></h1></div>
        <section class="conteiner_product">
        <div class="sorting">
            <h1>Сортировка</h1>


            <form method="get">
                <p>Цена</p>
                <label for="min_value">От</label>
                <input type="number" id="min_value" name="min_value"><br><br>
                <label for="max_value">До</label>
                <input type="number" id="max_value" name="max_value"><br><br>
                <input style="visibility:hidden" type="text" name="name" value="<?=$_GET['name']?>">
                <input type="submit" value="Применить">
                <input type="submit" value="Сбросить">
            </form>





            
            
        </div>
                    



















        <div class="product_grid">
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
                <div class="bascet">
                    <a href="./scripts/PostController.php?action=AddToBasket&&product_id=<?=$key['id']?>">добавить в корзину</a>
                </div>
                <div class="like">
                    <a href="./scripts/PostController.php?action=AddToFavourites&&product_id=<?=$key['id']?>"><img src="./image/Image_system/icons8-сердце-50 (2).png" alt="избранное"></a>
                </div>
            </div>
        </div>
            <?php endforeach; ?>  
        </section>  





































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