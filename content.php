<?php

$page = $_GET['page'] ?? 'mainPage'; // значение по умолчанию - 'mainpage'

switch ($page) {
    case 'aboutus':
        include('aboutUS.php');
        break;
    case 'menu':
        include('menu.php');
        break;
    case 'contacts':
        include('Contacts.php');
        break;
    default:
        include('mainpage.php'); // файл с разметкой главной страницы
}

?>
