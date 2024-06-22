<?php
// Проверяем, активна ли уже сессия
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

// Переменная, которая будет использоваться для вывода сообщений об ошибках при входе
$login_error = '';

// Проверяем, был ли запрос отправлен методом POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    // Получаем данные из формы
    $login = $_POST['login'];
    $password = $_POST['password'];

    // Подготавливаем SQL запрос для выборки данных пользователя из таблицы Users
    $query = "SELECT * FROM Users WHERE login = :login";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':login', $login, SQLITE3_TEXT);

    // Выполняем запрос
    $result = $stmt->execute();

    // Проверяем результат выполнения запроса
    if ($result) {
        // Получаем данные пользователя из результата запроса
        $user = $result->fetchArray(SQLITE3_ASSOC);

        // Проверяем существует ли пользователь и совпадает ли введенный пароль
        if ($user && password_verify($password, $user['password'])) {
            // Успешная авторизация
            $_SESSION['user_id'] = $user['user_id']; // Сохраняем ID пользователя в сессии
            $_SESSION['username'] = $user['username']; // Сохраняем имя пользователя в сессии
            $_SESSION['role'] = $user['role']; // Сохраняем роль пользователя в сессии
            header("Location: mainPage.php"); // Перенаправляем на главную страницу или куда вам нужно
            exit(); // Останавливаем выполнение скрипта
        } else {
            // Неверный логин или пароль
            $login_error = "Неверный логин или пароль.";
        }
    } else {
        // Ошибка при выполнении запроса
        $login_error = "Ошибка при попытке входа. Пожалуйста, попробуйте еще раз.";
    }
}

// Проверяем статус авторизации пользователя
if (isset($_SESSION['user_id'])) {
    // Пользователь авторизован
    $username = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : '';
    $header_content = '';
    if ($_SESSION['role'] === 'user') {
        // Пользователь с ролью "user"
        $header_content = '
            <div class="header-right">
                <p>Добро пожаловать, ' . $username . '!</p>
                <a href="logout.php">Выйти</a>
            </div>
        ';
    } elseif ($_SESSION['role'] === 'admin') {
        // Пользователь с ролью "admin"
        $header_content = '
            <div class="header-right">
                <p>Добро пожаловать, ' . $username . '! Вы вошли как администратор.</p>
                <a href="logout.php">Выйти</a>
            </div>
        ';
    } else {
        // Пользователь с другой ролью
        $header_content = '
            <div class="header-right">
                <p>Добро пожаловать, ' . $username . '! У вас нет доступа к этой части сайта.</p>
                <a href="logout.php">Выйти</a>
            </div>
        ';
    }
} else {
    // Пользователь не авторизован
    $header_content = '
        <div class="login-form">
            <form action="' . $_SERVER['PHP_SELF'] . '" method="post">
                <input type="text" name="login" placeholder="Логин">
                <input type="password" name="password" placeholder="Пароль">
                <button type="submit">Войти</button>
            </form>
            <div class="register-button">
                <button><a href="register.php"><b>Зарегистрироваться</b></a></button>
            </div>
        </div>
    ';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная страница</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .header {
            background-color: rgb(251, 251, 251);
            height: 120px;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header img.logo {
            width: 150px;
            height: auto;
        }

        .header button {
            background-color: #fdfefd;
            color: #040404;
            border: none;
            padding: 10px 20px;
            font-size: 23px;
            margin: 30px;
            cursor: pointer;
            border-radius: 4px;
            transition: border-color 0.3s ease;
        }

        .header button:hover {
            border: 3px solid #000000;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* добавляем стили для формы авторизации */
        .login-form {
            display: flex;
            align-items: center;
            margin-right: 30px;
        }

        .login-form input[type="text"],
        .login-form input[type="password"] {
            border: none;
            padding: 10px;
            font-size: 20px;
            border-radius: 4px;
            margin-right: 10px;
        }

        .login-form button {
            background-color: #fdfefd;
            color: #040404;
            border: none;
            padding: 10px 20px;
            font-size: 23px;
            cursor: pointer;
            border-radius: 4px;
            transition: border-color 0.3s ease;
        }

        .login-form button:hover {
            border: 3px solid #000000;
        }

        .register-button {
            margin-left: 10px;
        }

        .error {
            margin-top: 10px;
            color: red;
        }

        .header-right p {
            margin-right: 20px;
        }

        .header-right a {
            font-size: 20px;
            margin-right: 20px;
        }
    </style>
</head>
<body>
    <header class="header">
        <img class="logo" src="logo.png" alt="Логотип">
        <div class="mainPage"><button><a href="mainPage.php"><b>Главная</b></a></button></div>
        <div class="Menu"><button><a href="menu.php"><b>Меню</b></a></button></div>
        <div class="Contacts"><button><a href="Contacts.php"><b>Контакты</b></a></button></div>
        <div class="AboutUS"><button><a href="AboutUS.php"><b>О нас</b></a></button></div>

        <?php echo $header_content; ?>
    </header>

    <?php if (!empty($login_error)): ?>
        <div class="error"><?php echo $login_error; ?></div>
    <?php endif; ?>
</body>
</html>

<?php
// Закрываем соединение с базой данных SQLite
$conn->close();
?>
