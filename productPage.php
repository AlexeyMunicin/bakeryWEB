<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Путь к файлу базы данных SQLite
$db_file = 'bakery.db';

// Создаем подключение к базе данных SQLite
$conn = new SQLite3($db_file);

// Проверяем соединение
if (!$conn) {
    die("Connection failed: Unable to connect to SQLite database.");
}

$id = isset($_GET['product_id']) ? $_GET['product_id'] : null;

$product = []; // Инициализируем массив продукта

if (isset($_GET['product_id'])) {
    $id = $_GET['product_id'];
    // Подготавливаем запрос с использованием параметров
    $query = "SELECT * FROM Products WHERE product_id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
    $result = $stmt->execute();

    // Привязываем значение к плейсхолдеру :id
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
    // Выполняем запрос
    $result = $stmt->execute();

    // Преобразуем результат запроса в ассоциативный массив
    $product = $result->fetchArray(SQLITE3_ASSOC);
} else {
    // здесь можно вывести сообщение об ошибке, если параметр product_id не передан
    $product = [];
}


// Обработка отправки отзыва
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $name = $_POST['name'];
    $comment = $_POST['comment'];
    $rating = $_POST['rating'];

    // Проверяем, авторизован ли пользователь
    if (isset($_SESSION['user_id'])) {
        // Проверяем, заполнены ли все поля
        if (!empty($product_id) && !empty($name) && !empty($comment) && !empty($rating)) {
            // Добавляем отзыв в базу данных
            $insert_query = "INSERT INTO review (product_id, user_name, comment, rating) VALUES (:product_id, :name, :comment, :rating)";
            $stmt = $conn->prepare($insert_query);
            $stmt->bindValue(':product_id', $product_id, SQLITE3_INTEGER);
            $stmt->bindValue(':name', $name, SQLITE3_TEXT);
            $stmt->bindValue(':comment', $comment, SQLITE3_TEXT);
            $stmt->bindValue(':rating', $rating, SQLITE3_INTEGER);

            // Выполняем запрос
            $result = $stmt->execute();

            // Перенаправляем пользователя после добавления отзыва (можно добавить URL, куда перенаправить)
            header("Location: menu.php");
            exit(); // Прерываем дальнейшее выполнение скрипта
        } else {
            // Если не все поля заполнены, выведем сообщение об ошибке
            echo "Пожалуйста, заполните все поля!";
        }
    } else {
        // Если пользователь не авторизован, выведем сообщение об ошибке
        echo "Только авторизованные пользователи могут оставлять отзывы.";
    }
}


// Fetch comments for the product
$comments = [];
$commentsQuery = "SELECT * FROM review WHERE product_id = :id";
$stmt = $conn->prepare($commentsQuery);
$stmt->bindValue(':id', $id, SQLITE3_INTEGER);

// Выполняем запрос
$commentsResult = $stmt->execute();

// Проверяем результат выполнения запроса
if (!$commentsResult) {
    die("Error fetching comments.");
}

// Получаем комментарии и сохраняем их в массиве
while ($row = $commentsResult->fetchArray(SQLITE3_ASSOC)) {
    $comments[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Page</title>
    <style>
        /* Общие стили */
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        /* Стили для товара */
        .product {
            height: 780px;
            text-align: center;
        }

        .product img {
            height: 400px;
            margin-bottom: 20px;
        }

        .product .name {
            font-size: 25px;
            color: rgb(0, 0, 0);
            margin-bottom: 20px;
        }

        .product .stats {
            font-size: 20px;
            margin-bottom: 20px;
        }

        .product .stats ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .product .stats li {
            margin-bottom: 10px;
        }

        .product .price {
            font-size: 20px;
            margin-bottom: 20px;
        }

        /* Стили для кнопки редактирования */
        .edit-button {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .edit-button:hover {
            background-color: #45a049;
        }

        /* Стили для раздела комментариев */
        .comments-section {
            margin-top: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .comments-section h2 {
            margin-bottom: 10px;
            font-size: 24px;
        }

        .comment {
            margin-bottom: 15px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 15px;
        }

        .comment p {
            margin: 5px 0;
        }

        .comment p:first-child {
            font-weight: bold;
        }
    </style>
</head>
<body>
<?php include('header.php'); ?>

<div class="product">
    <center><p class="name"><?php echo $product['name']; ?></p></center>
    <img class="kruasan" src="<?php echo $product['image']; ?>">
    <div class="stats">
        <div>Пищевая ценность на 100 г :</div>
        <ul>
            <li>Белки <?php echo $product['proteins']; ?> г</li>
            <li>Жиры <?php echo $product['fats']; ?> г</li>
            <li>Углеводы <?php echo $product['carbs']; ?> г</li>
            <li>Каллорийность <?php echo $product['calories']; ?> ккал</li>
        </ul>
    </div>
    <div class="price">
        <div>Цена:</div>
        <div><?php echo $product['price']; ?> руб.</div>
    </div>
    <!-- Кнопка для редактирования продукта для админа -->
    <?php
    if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'){
        echo '<a class="edit-link" href="edit_product.php?product_id=' . $product['product_id'] . '">Редактировать</a>';
    }
    ?>
</div>

<!-- Форма для оставления отзыва -->
<div class="comments-section">
    <h2>Оставить отзыв</h2>
    <form method="post">
        <input type="hidden" name="product_id" value="<?php echo $id; ?>">
        <label for="name">Имя:</label>
        <input type="text" id="name" name="name" required><br>
        <label for="comment">Комментарий:</label>
        <textarea id="comment" name="comment" rows="4" cols="50" required></textarea><br>
        <label for="rating">Оценка:</label>
        <select id="rating" name="rating" required>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select><br>
        <input type="submit" value="Отправить">
    </form>
</div>

<!-- Раздел для комментариев -->
<div class="comments-section">
    <h2>Отзывы о товаре</h2>
    <?php 
    if (empty($comments)) {
        echo "Отзывов пока нет.";
    } else {
        foreach ($comments as $comment) : ?>
            <div class="comment">
                <p><strong>Пользователь:</strong> <?php echo $comment['user_name']; ?></p>
                <p><strong>Комментарий:</strong> <?php echo $comment['comment']; ?></p>
                <p><strong>Оценка:</strong> <?php echo $comment['rating']; ?></p>
            </div>
        <?php endforeach;
    }
    ?>
</div>

<?php include('footer.php'); ?>

</body>
</html>
