<?php
session_start();

require_once '../DB/start.php';
require_once '../core/Modules/UserModel.php';
require_once '../core/Modules/PostModel.php';

$conn = DB::getConnection();

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/static.css">
    <link rel="stylesheet" href="../style/adminPanel.css">
    <title>Document</title>
</head>
<body>

    <?php require_once '../includes/header.php'; ?>


    <section class="list">
        <ul>
            <li><a href="../adminPages/create_product.php">- Добавить товар</a></li>
            <br>
            <li>Слайдер
                <ul>
                    <li><a href="../adminPages/addToSlider.php">- Добавить слайдер</a></li>
                    <li><a href="../adminPages/deletedSliders.php">- Удалить слайдер</a></li>
                </ul>
            </li>
            <br>
            <li>Информационный блок
                <ul>
                    <li><a href="../adminPages/createInfoBlock.php">- Создать информационный блок</a></li>
                    <li>- Удалить инф блок (сделать)</li>
                </ul>
            </li>
            <br>
            <li>Категории
                <ul>
                    <li><a href="../adminPages/createCategory.php">- Создать категорию</a></li>
                    <li>- Удалить категорию (сделать)</li>
                </ul>
            </li>
        </ul>

    </section>



    <?php require_once '../includes/footer.php'; ?>

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