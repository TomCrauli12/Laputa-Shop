<?php session_start();

require_once '../DB/start.php';
require_once '../core/Modules/UserModel.php';
require_once '../core/Modules/PostModel.php';

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
    <link rel="stylesheet" href="../style/static.css">
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../style/medea.css">
    <title>Laputa | Избранное</title>
</head>
<body>
    <?php require_once '../includes/header.php'; ?>

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
                        <a href=""><img src="../image/image_product/<?=$key['files']?>" alt=""></a>
                    </div>
                    <div class="price">
                        <a href=""><h1><?=$key['title']?></h1></a> 
                        <p><?=$key['price']?> ₽</p>
                    </div>
                    <div class="button">
                        <?php if(isset($_SESSION['login'])): ?>
                            <div class="bascet">
                                <a href="../core/Controllers/PostController.php?action=AddToBasket&&product_id=<?=$key['id']?>">добавить в корзину</a>
                            </div>
                            <div class="like">
                                <a href="../core/Controllers/PostController.php?action=deleteFavourites&&id=<?=$favourites_id?>"><img src="../image/Image_system/icons8red-сердце-50 (2).png" alt="избранное"></a>
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
        <?php require_once '../includes/footer.php'; ?>
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