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
    <title>Document</title>
</head>
<body>

<?php require_once '../includes/header.php'; ?>


    <section>
        <ul>
            <li><a href="./create_product.php">Добавить товар</a></li>
            <li>Слайдер
                <ol>
                    <li><a href="./addToSlider.php">Добавить слайдер</a></li>
                    <li>Удалить слайдер (сделать)</li>
                </ol>
            </li>

            <li>Информационный блок
                <ol>
                    <li><a href="./createInfoBlock.php">Создать информационный блок</a></li>
                    <li>Удалить инф блок (сделать)</li>
                </ol>
            </li>

            <li>Категории
                <ol>
                    <li><a href="./createCategory.php">Создать категорию</a></li>
                    <li>Удалить категорию (сделать)</li>
                </ol>
            </li>

        </ul>




                
                
                
    </section>




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