<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    /*Для контактов и карты*/

    body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        
    .content{
            
            height: 680px;
        }
        

        .Cont .textandContacts{
            text-align: left;
            color:rgb(0, 0, 0);
            padding: 20px;
            font-style: italic;
            font-size: 25px;
        }

        .Map {
            position: absolute;
            top: 230px;
            left: 1200px;
        }
  </style>
</head>
<body>
<?php
    include('header.php');
    ?>
  <div class="content">

        <div class="textandContacts">
            <div>
            <p>Эта страница содержит всю контактную информацию о нашей компании.</p>
            <p>Наш адрес: Г. Москва, Ул.Верхняя Радищевская улица, 21, Этаж 2</p>
            <p>Электронная почта: alex09042004000@gmail.com</p>
            <p>Наши соц. сети: <a href="https://vk.com/creeptonn">Вконтакте</a></p>
            </div>
        </div>
    
    
        <div class="Map">    
            <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3Ac54d2053b08eede21cfe188ea03990bbabc50f48040acd643ab06eaa30d7e63b&amp;width=602&amp;height=484&amp;lang=ru_RU&amp;scroll=true"></script>
        </div>
    </div> 
    <?php
    include('footer.php');
    ?>
</body>
</html>