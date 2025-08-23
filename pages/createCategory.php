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
    <?php require_once '../includes/header.php'; ?>

    <form action="../core/Controllers/PostController.php?action=addCategory" method="post">
        <label for="categoryName">Название категории для отображения на сайте</label>
        <input type="text" name="categoryName" id="">

        <label for="categoryBDName">Название категории(на английском!)</label>
        <input type="text" name="categoryBDName" id="">

        <button>Создать информационный блок</button>
    </form>

    <?php require_once '../includes/footer.php'; ?>
</body>
</html>