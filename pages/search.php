<?php
session_start();

require_once '../DB/start.php';
require_once '../core/Modules/UserModel.php';
require_once '../core/Modules/PostModel.php';

// Предполагается, что DB::getConnection() возвращает объект PDO
$conn = DB::getConnection();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Поиск товаров</title>
</head>
<body>
    <h1>Поиск товаров</h1>

    <form action="" method="GET">
        <input type="text" name="query" placeholder="Введите название товара" value="<?php echo htmlspecialchars($_GET['query'] ?? ''); ?>">
        <button type="submit">Поиск</button>
    </form>

    <hr>

    <div class="search-results">
        <?php
        if (isset($_GET['query']) && !empty(trim($_GET['query']))) {
            $search_query = trim($_GET['query']);
            
            // Подготовка SQL-запроса для PDO
            $sql = "SELECT * FROM products WHERE title LIKE :query";
            $stmt = $conn->prepare($sql);
            
            // Привязываем параметр. Для PDO используется именованный параметр (:query)
            $search_param = "%" . $search_query . "%";
            $stmt->bindParam(':query', $search_param, PDO::PARAM_STR);
            
            // Выполняем запрос
            $stmt->execute();

            // Извлекаем все результаты
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Проверяем, есть ли результаты
            if (count($results) > 0) {
                // Выводим товары
                foreach ($results as $row) {
                    echo "<h2>" . htmlspecialchars($row['title']) . "</h2>";
                    echo "<p>Цена: " . htmlspecialchars($row['price']) . "</p>";
                    // Вывод других данных
                }
            } else {
                echo "<p>Товаров по вашему запросу не найдено.</p>";
            }

            // Закрывать соединение с базой данных в PDO можно, присвоив переменной null
            $stmt = null;
        } else {
            echo "<p>Введите название товара, чтобы начать поиск.</p>";
        }

        // В PDO не обязательно закрывать соединение, оно закроется автоматически
        // Но если нужно, можно сделать так: $conn = null;
        ?>
    </div>
</body>
</html>