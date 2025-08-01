<?php
session_start();

require_once __DIR__ . './DB/start.php';
require_once __DIR__ . './core/Modules/UserModel.php';
require_once __DIR__ . './core/Modules/PostModel.php';

$conn = DB::getConnection();

$new_product = PostModel::getInfoBlock("Новые товары");

$discounts = PostModel::getInfoBlock("Скидки");

$pre_orders = PostModel::getInfoBlock("Предзаказы");

$sale = PostModel::getInfoBlock("Распродажа");

$query = $conn->query('select * from sliders');
$sliders = $query->fetchAll();



?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="color-scheme" content="light dark">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/style.css">
    <link rel="stylesheet" href="./style/medea.css">
    
    <title>Laputa | Home</title>
</head>
<body>
    <nav class="navbar">
        <div class="nav">
            <a href="./pages/payment.html">Оплата и доставка</a>
            <a href="./pages/Refund.html">Возврат и обмен</a>
            <a href="./pages/about.html">О нас</a>
            <a href="./pages/contact.html">Контакты</a>
            <a href="./pages/create_product.html">Добавить товар</a>
            <a href="./pages/addToSlider.php">Добавить слайдер</a>
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
                e.preventDefault();
                checkbox.checked = !checkbox.checked;
            });
            </script>
                
                    
                <div class="info-block">
                <nav class="categories">
                        <a href="./pages/category.php?name=Манга">Манга</a>
                        <a href="./pages/category.php?name=Одежда">Одежда</a>
                        <a href="./pages/category.php?name=Постеры">Постеры</a>
                        <a href="./pages/category.php?name=Стикерпаки">Стикерпаки</a>
                        <a href="./pages/category.php?name=Наборы">Наборы</a>
                        <a href="./pages/category.php?name=Фигурки">Фигурки</a>
                        <a href="./pages/category.php?name=Ранобэ">Ранобэ</a>
                        <a href="./pages/category.php?name=Значки">Значки</a>
                        <a href="./pages/category.php?name=Косплеи">Косплеи</a>
                        <a href="./pages/category.php?name=Продукция">Продукция</a>
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
                <a href="./pages/login.php"><img src="./image/Image_system/icons8-человек-48.png" alt=""></a>
                                
                <?php if(isset($_SESSION['login'])): ?>
                    <a href="./core/Controllers/UserController.php?action=logout">Выход</a>                
                <?php else: ?>
                    <a href="./pages/login.php">Вход</a>        
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
                    <a href="./pages/favourites.php"><img src="./image/Image_system/icons8-сердце-50 (2).png" alt=""></a>
                    <a href="./pages/favourites.php">Избранное</a>
                </div>
                <div class="nav_item">
                    <a href="./pages/basket.php"><img src="./image/Image_system/icons8-корзины-32.png" alt=""></a>
                    <a href="./pages/basket.php">Корзина</a>
                </div>              
            <?php else: ?>
                <div class="nav_item">
                    <a href="./pages/login.php"><img src="./image/Image_system/icons8-сердце-50 (2).png" alt=""></a>
                    <a href="./pages/login.php">Избранное</a>
                </div>
                <div class="nav_item">
                    <a href="./pages/login.php"><img src="./image/Image_system/icons8-корзины-32.png" alt=""></a>
                    <a href="./pages/login.php">Корзина</a>
                </div>      
            <?php endif; ?>
        </div>
    </header>
    
    <section class="slider">
        <div class="slides-container">
            <?php foreach($sliders as $key): ?>
            <div class="slide">
                <!-- <a href="<?= $key['link'] ?? '#' ?>"> -->
                    <img src="./image/slider/<?=$key['imageslider']?>" alt="Слайд">
                <!-- </a> -->
            </div>
            <?php endforeach; ?>
        </div>
        <div class="slider-controls">
            <button class="slider-prev">‹</button>
            <div class="slider-dots">
                <?php foreach($sliders as $index => $key): ?>
                <button class="slider-dot <?= $index === 0 ? 'active' : '' ?>"></button>
                <?php endforeach; ?>
            </div>
            <button class="slider-next">›</button>
        </div>
    </section>

    

    <nav class="new_product">
        <div class="conteiner">
            <div class="section_name">
                <h1>Новые товары</h1>
                <a href="./pages/categoryMore.php?name=Новые Товары">Смотреть больше</a>
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
                                <a href="./core/Controllers/PostController.php?action=AddToBasket&&product_id=<?=$key['id']?>">добавить в корзину</a>
                            </div>
                            <div class="like">
                                <a href="./core/Controllers/PostController.php?action=AddToFavourites&product_id=<?=$key['id']?>&return_url=<?php echo urlencode($_SERVER['REQUEST_URI']) ?>"><img src="./image/Image_system/icons8-сердце-50 (2).png" alt="избранное"></a>
                            </div>
                        <?php else: ?>
                            <div class="bascet">
                                <a href="./pages/login.php">добавить в корзину</a>
                            </div>
                            <div class="like">
                                <a href="./pages/login.php"><img src="./image/Image_system/icons8-сердце-50 (2).png" alt="избранное"></a>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == "admin"): ?>
                        <div class="admin_buttons">
                            <a href="./core/Controllers/PostController.php?action=editProduct&id=<?=$key['id']?>" class="edit_btn">Редактировать</a>
                            <a href="./core/Controllers/PostController.php?action=deleteProduct&id=<?=$key['id']?>" class="delete_btn" onclick="return confirm('Вы уверены, что хотите удалить этот товар?')">Удалить</a>
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
                <a href="./pages/categoryMore.php?name=Скидки">Смотреть больше</a>
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
                                <a href="./core/Controllers/PostController.php?action=AddToBasket&&product_id=<?=$key['id']?>">добавить в корзину</a>
                            </div>
                            <div class="like">
                                <a href="./core/Controllers/PostController.php?action=AddToFavourites&product_id=<?=$key['id']?>&return_url=<?php echo urlencode($_SERVER['REQUEST_URI']) ?>"><img src="./image/Image_system/icons8-сердце-50 (2).png" alt="избранное"></a>
                            </div>
                        <?php else: ?>
                            <div class="bascet">
                                <a href="./pages/login.php">добавить в корзину</a>
                            </div>
                            <div class="like">
                                <a href="./pages/login.php"><img src="./image/Image_system/icons8-сердце-50 (2).png" alt="избранное"></a>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == "admin"): ?>
                        <div class="admin_buttons">
                            <a href="./core/Controllers/PostController.php?action=editProduct&id=<?=$key['id']?>" class="edit_btn">Редактировать</a>
                            <a href="./core/Controllers/PostController.php?action=deleteProduct&id=<?=$key['id']?>" class="delete_btn" onclick="return confirm('Вы уверены, что хотите удалить этот товар?')">Удалить</a>
                        </div>
                    <?php endif; ?>
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
                <a href="./pages/categoryMore.php?name=Предзаказы">Смотреть больше</a>
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
                                <a href="./core/Controllers/PostController.php?action=AddToBasket&&product_id=<?=$key['id']?>">добавить в корзину</a>
                            </div>
                            <div class="like">
                                <a href="./core/Controllers/PostController.php?action=AddToFavourites&product_id=<?=$key['id']?>&return_url=<?php echo urlencode($_SERVER['REQUEST_URI']) ?>"><img src="./image/Image_system/icons8-сердце-50 (2).png" alt="избранное"></a>
                            </div>
                        <?php else: ?>
                            <div class="bascet">
                                <a href="./pages/login.php">добавить в корзину</a>
                            </div>
                            <div class="like">
                                <a href="./pages/login.php"><img src="./image/Image_system/icons8-сердце-50 (2).png" alt="избранное"></a>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == "admin"): ?>
                        <div class="admin_buttons">
                            <a href="./core/Controllers/PostController.php?action=editProduct&id=<?=$key['id']?>" class="edit_btn">Редактировать</a>
                            <a href="./core/Controllers/PostController.php?action=deleteProduct&id=<?=$key['id']?>" class="delete_btn" onclick="return confirm('Вы уверены, что хотите удалить этот товар?')">Удалить</a>
                        </div>
                    <?php endif; ?>
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
                <a href="./pages/categoryMore.php?name=Распродажа">Смотреть больше</a>
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
                                <a href="./core/Controllers/PostController.php?action=AddToBasket&&product_id=<?=$key['id']?>">добавить в корзину</a>
                            </div>
                            <div class="like">
                                <a href="./core/Controllers/PostController.php?action=AddToFavourites&product_id=<?=$key['id']?>&return_url=<?php echo urlencode($_SERVER['REQUEST_URI']) ?>"><img src="./image/Image_system/icons8-сердце-50 (2).png" alt="избранное"></a>
                            </div>
                        <?php else: ?>
                            <div class="bascet">
                                <a href="./pages/login.php">добавить в корзину</a>
                            </div>
                            <div class="like">
                                <a href="./pages/login.php"><img src="./image/Image_system/icons8-сердце-50 (2).png" alt="избранное"></a>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == "admin"): ?>
                        <div class="admin_buttons">
                            <a href="./core/Controllers/PostController.php?action=editProduct&id=<?=$key['id']?>" class="edit_btn">Редактировать</a>
                            <a href="./core/Controllers/PostController.php?action=deleteProduct&id=<?=$key['id']?>" class="delete_btn" onclick="return confirm('Вы уверены, что хотите удалить этот товар?')">Удалить</a>
                        </div>
                    <?php endif; ?>
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
                <a href="./pages/login.php"><img src="./image/Image_system/icons8-человек-48.png" alt=""></a>
                <?php if(isset($_SESSION['login'])): ?>
                    <a href="../core/Controllers/UserController.php?action=logout">Выход</a>                
                <?php else: ?>
                    <a href="./pages/login.php">Вход</a>        
                <?php endif; ?>
            </div>
            <div class="nav_item">
                <a href=""><img src="./image/Image_system/icons8-коробка-128 (1).png" alt=""></a>
                <a href="">Заказы</a>
            </div>
            <div class="nav_item">
                <a href="./pages/favourites.php"><img src="./image/Image_system/icons8-сердце-50 (2).png" alt=""></a>
                <a href="./pages/favourites.php">Избранное</a>
            </div>
            <div class="nav_item">
                <a href="./pages/basket.php"><img src="./image/Image_system/icons8-корзины-32.png" alt=""></a>
                <a href="./pages/basket.php">Корзина</a>
            </div>
        </div>
    </footer>
    <a href=""></a>
    <script src="./scripts/theme.js"></script>
    <script src="./scripts/script.js"></script>
</body>
</html>









