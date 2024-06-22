<?php
// Путь к файлу базы данных SQLite
$db_file = 'bakery.db';

// Создаем подключение к базе данных SQLite
$conn = new SQLite3($db_file);

// Проверяем соединение
if (!$conn) {
    die("Connection failed: Unable to connect to SQLite database.");
}

// Переменная, которая будет использоваться для вывода сообщений об ошибках или успешной регистрации
$message = '';

// Проверяем, был ли запрос отправлен методом POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    // Получаем данные из формы
    $login = $_POST['login'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone_number = $_POST['phone_number'];

    // Хешируем пароль
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $role = "user";
    // Подготавливаем SQL запрос для вставки данных в таблицу Users
    $query = "INSERT INTO Users (login, email, password, first_name, last_name, phone_number, role) 
              VALUES (:login, :email, :password, :first_name, :last_name, :phone_number, :role)";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':login', $login, SQLITE3_TEXT);
    $stmt->bindValue(':email', $email, SQLITE3_TEXT);
    $stmt->bindValue(':password', $hashed_password, SQLITE3_TEXT);
    $stmt->bindValue(':first_name', $first_name, SQLITE3_TEXT);
    $stmt->bindValue(':last_name', $last_name, SQLITE3_TEXT);
    $stmt->bindValue(':phone_number', $phone_number, SQLITE3_TEXT);
    $stmt->bindValue(':role', $role, SQLITE3_TEXT);


    // Выполняем запрос
    $result = $stmt->execute();

    // Проверяем результат выполнения запроса
    if ($result) {
        // Успешная регистрация
        $message = "Регистрация прошла успешно!";
        // После успешной регистрации перенаправляем пользователя на главную страницу
        header("Location: mainPage.php"); // Предположим, что ваш файл главной страницы называется index.php
        exit(); // Останавливаем выполнение скрипта
    } else {
        // Ошибка при выполнении запроса
        $message = "Ошибка при регистрации. Пожалуйста, попробуйте снова.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 500px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-top: 0;
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            margin-bottom: 10px;
            padding: 10px;
            font-size: 16px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        button {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .message {
            margin-top: 20px;
            text-align: center;
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Регистрация</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <input type="text" name="login" placeholder="Логин" required><br>
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="password" placeholder="Пароль" required><br>
            <input type="text" name="first_name" placeholder="Имя" required><br>
            <input type="text" name="last_name" placeholder="Фамилия" required><br>
            <input type="text" name="phone_number" placeholder="Номер телефона" required><br>
            <button type="submit" name="register">Зарегистрироваться</button>
        </form>

        <div class="message">
            <?php echo $message; ?>
        </div>
    </div>
</body>
</html>

<?php
// Закрываем соединение с базой данных SQLite
$conn->close();
?>
