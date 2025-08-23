<?php
session_start();

require_once '../DB/start.php';
require_once '../core/Modules/PostModel.php';

$conn = DB::getConnection();

$query = $conn->prepare('select * from `products` where id = ?');
$query->execute([$_GET['id']]);
$product = $query->fetch();

$allInfoblock = $conn->query('SELECT * FROM `infoblock`')->fetchAll(PDO::FETCH_ASSOC);

$allCategory = $conn->query('SELECT * FROM `category`')->fetchAll(PDO::FETCH_ASSOC);


// if (isset($_SESSION['role']) && ($_SESSION['role'] == "admin" || $_SESSION['role'] == "editor")):
        
// else:
//     header("Location: ../index.php");
// endif;

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

    <form method="post" action="../core/Controllers/PostController.php?action=editProduct&&id=<?=$_GET['id']?>" style="display: flex; flex-direction: column; width: 30vw;">

        <label>title</label>
        <input type="text" value="<?=$product['title']?>" name="title" required="" placeholder="Заголовок">
        <label>descr</label>
        <input type="text" value="<?=$product['descr']?>" name="descr" required="" placeholder="Заголовок"> 

        <label>price</label>
        <input type="text" value="<?=$product['price']?>" name="price" required="" placeholder="Заголовок"> 

        <label for="category">Выбрать категорию</label><br>
        <?php foreach($allCategory as $key): ?>
            <input name="category" type="radio" value="<?=$key['categoryBDName']?>" 
                <?=($product['category'] == $key['categoryBDName']) ? 'checked' : ''?>>
            <?=$key['categoryName']?><br>
        <?php endforeach; ?>

        <!-- <label>categorytwo</label>
        <input type="text" value="<?=$product['categorytwo']?>" name="categorytwo" required="" placeholder="Заголовок">  -->

        <label for="info_block">Добавить информационный блок</label><br>
        <?php foreach($allInfoblock as $key): ?>
            <input name="info_block" type="radio" value="<?=$key['infoBlockDBName']?>" 
                <?=($product['info_block'] == $key['infoBlockDBName']) ? 'checked' : ''?>>
            <?=$key['infoBlockName']?><br>
        <?php endforeach; ?>



        <button class="button" type="submit">Сохранить изменения</button>
    </form>

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
