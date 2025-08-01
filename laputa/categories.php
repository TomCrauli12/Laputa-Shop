<!-- таблица с каталогом и таблица с категориями ну и передовать id
if else в ссылках на категориии если нету то ссылку ссылка на страницу с тега данной категории если нет то ссылку на категории  -->





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/categories.css">
    <link rel="stylesheet" href="./style/medea.css">
    <title>Laputa | Категории</title>
</head>
<body>
    <nav class="navbar">
        <div class="nav">
            <a href="">Акции</a>
            <a href="">Оплата и доставка</a>
            <a href="">Возврат и обмен</a>
            <a href="">О нас</a>
            <a href="">Контакты</a>
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
                <a href="">Каталог</a>
                    
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
              
            
            <div class="sean">
                <form> 
                    <input type="text" name="text" class="search" placeholder="Введите запрос">
                    <input type="submit" name="submit" class="submit" value="Поиск">
                  </form>
            </div>
            <a href="./create_product.html">Добавить товар</a>
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
            <div class="nav_item">
                <a href="./favourites.php"><img src="./image/Image_system/icons8-сердце-50 (2).png" alt=""></a>
                <a href="./favourites.php">Избранное</a>
            </div>
            <div class="nav_item">
                <a href="./basket.php"><img src="./image/Image_system/icons8-корзины-32.png" alt=""></a>
                <a href="./basket.php">Корзина</a>
            </div>
        </div>
    </header>

    <section class="categories_grid">
        <div class="category">
            <div class="img_categiry">
                <a href=""><img src="./2024-02-16_16-18-39.png" alt=""></a>
            </div>
            <div class="name_category">
                <a href=""><h1>Манга в переплете</h1></a>
            </div>
        </div>
        <div class="category">
            <div class="img_categiry">
                <a href=""><img src="./2024-02-16_16-18-39.png" alt=""></a>
            </div>
            <div class="name_category">
                <a href=""><h1>Манга в переплете</h1></a>
            </div>
        </div>
        <div class="category">
            <div class="img_categiry">
                <a href=""><img src="./2024-02-16_16-18-39.png" alt=""></a>
            </div>
            <div class="name_category">
                <a href=""><h1>Манга в переплете</h1></a>
            </div>
        </div>
        <div class="category">
            <div class="img_categiry">
                <a href=""><img src="./2024-02-16_16-18-39.png" alt=""></a>
            </div>
            <div class="name_category">
                <a href=""><h1>Манга в переплете</h1></a>
            </div>
        </div>
        <div class="category">
            <div class="img_categiry">
                <a href=""><img src="./2024-02-16_16-18-39.png" alt=""></a>
            </div>
            <div class="name_category">
                <a href=""><h1>Манга в переплете</h1></a>
            </div>
        </div>
        <div class="category">
            <div class="img_categiry">
                <a href=""><img src="./2024-02-16_16-18-39.png" alt=""></a>
            </div>
            <div class="name_category">
                <a href=""><h1>Манга в переплете</h1></a>
            </div>
        </div>
        <div class="category">
            <div class="img_categiry">
                <a href=""><img src="./2024-02-16_16-18-39.png" alt=""></a>
            </div>
            <div class="name_category">
                <a href=""><h1>Манга в переплете</h1></a>
            </div>
        </div>
        

    </section>
   































    <footer>
        <div class="footer">
            <div class="nav_item">
                <a href="./login.php"><img src="./image/Image_system/icons8-человек-48.png" alt=""></a>
                <a href="./login.php">Войти</a>
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