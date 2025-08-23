<?php
session_start();

require_once __DIR__ . '../../DB/start.php';
require_once __DIR__ . '../../core/Modules/UserModel.php';
require_once __DIR__ . '../../core/Modules/PostModel.php';

$conn = DB::getConnection();

$sliders = $conn->query('SELECT * FROM `sliders`')->fetchAll();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/static.css">
    <link rel="stylesheet" href="../style/adminPanel/deletedSliders.css">
    <title>Slider</title>
</head>
<body>
    <?php require_once '../includes/header.php'; ?>
    <section class="main">
        <? foreach($sliders as $slide): ?>
        <div class="slide">
            <img src="../image/slider/<?=htmlspecialchars($slide['imageslider'])?>" alt="Слайд">
            <a href="../core/Controllers/PostController.php?action=deleteSlider&id=<?=$slide['id']?>">Удалить</a>
        </div>
        <br>
        <? endforeach; ?>
    </section>
</body>
</html>