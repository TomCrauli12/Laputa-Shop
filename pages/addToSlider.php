<?php
    session_start();
    require_once '../DB/start.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="../core/Controllers/PostController.php?action=addSlider" method="post" enctype="multipart/form-data">
        <h1>Загрузить новый слайдер</h1>
        <input type="file" name="imageslider" id="">
        <button>Загрузить изображение</button>
        
    </form>
</body>
</html>