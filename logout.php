<?php
session_start();

// Если сессия существует, уничтожаем её
if (isset($_SESSION['user_id'])) {
    session_unset(); // Очищаем все переменные сессии
    session_destroy(); // Разрушаем сессию
}

// Перенаправляем пользователя на главную страницу или другую страницу после выхода
header("Location: mainPage.php"); // Измените index.php на страницу, куда вы хотите перенаправить пользователя после выхода
exit();
?>
