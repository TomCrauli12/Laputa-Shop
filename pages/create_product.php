<?php 
    session_start();

    require_once '../DB/start.php';
    require_once '../core/Modules/PostModel.php';

    $conn = DB::getConnection();

    $query = $conn->query('select * from category');
    $allCategory = $query->fetchAll();

    $query = $conn->query('select * from infoblock');
    $allInfoblock = $query->fetchAll();

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Созданиие продукта</title>
</head>
<body>

    <!-- Добавить выбор информациооного блока
    добавить выбор категории -->
<form enctype="multipart/form-data" action="../core/Controllers/PostController.php?action=createProduct" method="POST">
    <label for="title">Название</label>
    <input name="title" class="title" required="" maxlength="20"/>
    <br>
    <br>
    <label for="descr">Описание</label>
    <input name="descr" class="descr" required="">
    <br>
    <br>
    <label for="price">Цена</label>
    <input name="price" class="price" required="">
    <br>
    <br>

    <label for="category">Выбрать категорию</label><br>
    <?php foreach($allCategory as $key): ?>
        <input name="category" type="radio" value="<?=$key['categoryBDName']?>"><?=$key['categoryName']?><br>
    <?php endforeach; ?>
    <br>
    <br>

    <label for="info_block">Добавить в информациооный блок</label><br>
        <?php foreach($allInfoblock as $key): ?>
        <input name="info_block" type="radio" value="<?=$key['infoBlockDBName']?>"><?=$key['infoBlockName']?><br>
    <?php endforeach; ?>


    
    <br>
    <br>
    <!-- Название элемента input определяет имя в массиве $_FILES -->
    <!-- Измените input для дополнительных файлов, сделав их необязательными -->
    <label for="files">добавить главное изображение (обязательно)</label>
    <input name="files" type="file" required />
    <br><br>

    <label for="files_2">добавить изображение 2 (необязательно)</label>
    <input name="files_2" type="file" />
    <br><br>

    <label for="files_3">добавить изображение 3 (необязательно)</label>
    <input name="files_3" type="file" />
    <br><br>

    <label for="files_4">добавить изображение 4 (необязательно)</label>
    <input name="files_4" type="file" />
    <br><br>

    <label for="files_5">добавить изображение 5 (необязательно)</label>
    <input name="files_5" type="file" />
    <br><br>

    <input type="submit" value="создать товар" />
</form>


<!-- добавить штуки 4 форм загрузки изображений и
добавит 4 колонки в таблицу 
с хештегами так же 
можно добавить колонку с хештегом на выбор в какой инфо блок выложить товар
так же редактировку к нему -->

<!-- <footer>
    <div class="footer">
        <div class="nav_item">
            <a href="../login.php"><img src="../image/Image_system/icons8-человек-48.png" alt=""></a>
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
</footer> -->


</body>
</html>