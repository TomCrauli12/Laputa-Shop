<!-- таблицы
товар
id название описание изображения теги категория -->
<!-- таблица user
login password role -->
<?php
require_once './start.php';
require_once './scripts/UserModel.php';
require_once './scripts/PostModel.php';

$conn = DB::getConnection();

$new_product = PostModel::getInfoBlock("Новые товары");

$discounts = PostModel::getInfoBlock("Скидки");

$pre_orders = PostModel::getInfoBlock("Предзаказы");

$sale = PostModel::getInfoBlock("Распродажа");




session_start();
?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/style.css">
    <link rel="stylesheet" href="./style/medea.css">
    
    <title>Laputa | Home</title>
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
    
    <section class="slider">
        <div class="slides">
            <div class="slide active">
                <a href=""><img src="./2024-02-16_16-18-39.png" alt="Слайд 1"></a>
            </div>
            <div class="slide">
                <a href=""><img src="./2024-02-16_16-18-39.png" alt="Слайд 2"></a>
            </div>
            <div class="slide">
                <a href=""><img src="./2024-02-16_16-18-39.png" alt="Слайд 3"></a>
            </div>
        </div>
        <div class="controls">
            <button class="prev">Предыдущий</button>
            <button class="next">Следующий</button>
        </div>
        <div class="dots">
            <button class="dot active"></button>
            <button class="dot"></button>
            <button class="dot"></button>
        </div>
    </section>

    

    <nav class="new_product">
        <div class="conteiner">
            <div class="section_name">
                <h1>Новые товары</h1>
                <a href="/categoryMore.php?name=Новые Товары">Смотреть больше</a>
            </div>
            <div class="product_grid">
            <?php $count = 0; foreach($new_product as $key): ?>
                <?php if ($count < 5): ?>
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
                                <a href="./scripts/PostController.php?action=AddToFavourites&&product_id=<?=$key['id']?>"><img src="./image/Image_system/icons8-сердце-50 (2).png" alt="избранное"></a>
                            </div>
                        <?php else: ?>
                            <div class="bascet">
                                <a href="./login.php">добавить в корзину</a>
                            </div>
                            <div class="like">
                                <a href="./login.php"><img src="./image/Image_system/icons8-сердце-50 (2).png" alt="избранное"></a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php $count++; ?>
                <?php endif; ?>
            <?php endforeach; ?>
            </div> 
        </div>
    </div>
    </nav> 
    <nav class="discond">
        <div class="conteiner">
        <div class="section_name">
                <h1>Скидки</h1>
                <a href="/categoryMore.php?name=Скидки">Смотреть больше</a>
            </div>
            <div class="product_grid">
            <?php $count = 0; foreach($discounts as $key): ?>
                <?php if ($count < 5): ?>
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
                                <a href="./scripts/PostController.php?action=AddToFavourites&&product_id=<?=$key['id']?>"><img src="./image/Image_system/icons8-сердце-50 (2).png" alt="избранное"></a>
                            </div>
                        <?php else: ?>
                            <div class="bascet">
                                <a href="./login.php">добавить в корзину</a>
                            </div>
                            <div class="like">
                                <a href="./login.php"><img src="./image/Image_system/icons8-сердце-50 (2).png" alt="избранное"></a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php $count++; ?>
                <?php endif; ?>
            <?php endforeach; ?>
            </div> 
        </div>
    </div>
    </nav> 
    <nav class="Pre_orders">
        <div class="conteiner">
        <div class="section_name">
                <h1>Предзаказы</h1>
                <a href="/categoryMore.php?name=Предзаказы">Смотреть больше</a>
            </div>
            <div class="product_grid">
            <?php $count = 0; foreach($pre_orders as $key): ?>
                <?php if ($count < 5): ?>
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
                                <a href="./scripts/PostController.php?action=AddToFavourites&&product_id=<?=$key['id']?>"><img src="./image/Image_system/icons8-сердце-50 (2).png" alt="избранное"></a>
                            </div>
                        <?php else: ?>
                            <div class="bascet">
                                <a href="./login.php">добавить в корзину</a>
                            </div>
                            <div class="like">
                                <a href="./login.php"><img src="./image/Image_system/icons8-сердце-50 (2).png" alt="избранное"></a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php $count++; ?>
                <?php endif; ?>
            <?php endforeach; ?>
            </div> 
        </div>
    </div>
    </nav> 
    <nav class="Sale">
        <div class="conteiner">
        <div class="section_name">
                <h1>Распродажа</h1>
                <a href="/categoryMore.php?name=Распродажа">Смотреть больше</a>
            </div>
            <div class="product_grid">
            <?php $count = 0; foreach($sale as $key): ?>
                <?php if ($count < 5): ?>
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
                                <a href="./scripts/PostController.php?action=AddToFavourites&&product_id=<?=$key['id']?>"><img src="./image/Image_system/icons8-сердце-50 (2).png" alt="избранное"></a>
                            </div>
                        <?php else: ?>
                            <div class="bascet">
                                <a href="./login.php">добавить в корзину</a>
                            </div>
                            <div class="like">
                                <a href="./login.php"><img src="./image/Image_system/icons8-сердце-50 (2).png" alt="избранное"></a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php $count++; ?>
                <?php endif; ?>
            <?php endforeach; ?>
            </div> 
        </div>
    </div>
    </nav> 


























<div class="conteiner_zero">
    
</div>

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

    <script src="./script/script.js"></script>
</body>
</html>









