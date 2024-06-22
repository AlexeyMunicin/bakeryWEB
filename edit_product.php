<?php
// Путь к файлу базы данных SQLite
$db_file = 'bakery.db';

// Создаем подключение к базе данных SQLite
$conn = new SQLite3($db_file);

// Проверяем соединение
if (!$conn) {
    die("Connection failed: Unable to connect to SQLite database.");
}

// Обработка отправленной формы редактирования
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получение данных из формы
    $product_id = $_POST['product_id'];
    $new_name = $_POST['name'];
    $new_image = $_POST['image'];
    $new_proteins = $_POST['proteins'];
    $new_fats = $_POST['fats'];
    $new_carbs = $_POST['carbs'];
    $new_calories = $_POST['calories'];
    $new_price = $_POST['price'];

    // Подготовка SQL-запроса на обновление информации о продукте
    $query = "UPDATE Products SET 
                name = :name, 
                image = :image, 
                proteins = :proteins, 
                fats = :fats, 
                carbs = :carbs, 
                calories = :calories, 
                price = :price 
              WHERE product_id = :product_id";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':name', $new_name, SQLITE3_TEXT);
    $stmt->bindValue(':image', $new_image, SQLITE3_TEXT);
    $stmt->bindValue(':proteins', $new_proteins, SQLITE3_INTEGER);
    $stmt->bindValue(':fats', $new_fats, SQLITE3_INTEGER);
    $stmt->bindValue(':carbs', $new_carbs, SQLITE3_INTEGER);
    $stmt->bindValue(':calories', $new_calories, SQLITE3_INTEGER);
    $stmt->bindValue(':price', $new_price, SQLITE3_FLOAT);
    $stmt->bindValue(':product_id', $product_id, SQLITE3_INTEGER);
    $result = $stmt->execute();

    // Перенаправление на страницу с продуктом после обновления
    header("Location: productPage.php?product_id=" . $product_id);
    exit();
}

// Проверка наличия параметра product_id в URL
if (isset($_GET['product_id'])) {
    $id = $_GET['product_id'];
    // Подготовка SQL-запроса на получение информации о товаре по его ID
    $query = "SELECT * FROM Products WHERE product_id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
    $result = $stmt->execute();

    // Получение данных о товаре из результата запроса
    $product = $result->fetchArray(SQLITE3_ASSOC);
} else {
    // Если параметр product_id не передан, можно вывести сообщение об ошибке или выполнить другие действия
    $product = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
</head>
<body>
<h2>Edit Product</h2>
<form method="post">
    <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
    <label for="name">Name:</label><br>
    <input type="text" id="name" name="name" value="<?php echo $product['name']; ?>"><br>
    <label for="image">Image URL:</label><br>
    <input type="text" id="image" name="image" value="<?php echo $product['image']; ?>"><br>
    <label for="proteins">Proteins:</label><br>
    <input type="number" id="proteins" name="proteins" value="<?php echo $product['proteins']; ?>"><br>
    <label for="fats">Fats:</label><br>
    <input type="number" id="fats" name="fats" value="<?php echo $product['fats']; ?>"><br>
    <label for="carbs">Carbs:</label><br>
    <input type="number" id="carbs" name="carbs" value="<?php echo $product['carbs']; ?>"><br>
    <label for="calories">Calories:</label><br>
    <input type="number" id="calories" name="calories" value="<?php echo $product['calories']; ?>"><br>
    <label for="price">Price:</label><br>
    <input type="text" id="price" name="price" value="<?php echo $product['price']; ?>"><br><br>
    <input type="submit" value="Save Changes">
</form>
</body>
</html>

<?php
// Закрытие соединения с базой данных SQLite
$conn->close();
?>
