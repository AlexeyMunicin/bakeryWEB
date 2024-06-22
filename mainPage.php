<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    /* Под шапкой */
    .underHead {
            text-align: center;
            padding: 50px 0;
        }

        .moved1 {
            font-style: italic;
            font-size: 48px;
            color: #9d7c03;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .moved2 {
            font-style: italic;
            font-size: 25px;
            color: #4a4101;
        }

        .png1 {
            display: block;
            margin: 20px auto;
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Ассортимент */
        .text {
            font-family: 'Lobster', cursive;
            font-size: 40px;
            font-style: italic;  
            color: #fdae06;
            text-align: center;
            margin-top: 50px;
        }

        .assortiment {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            padding: 20px;
        }

        .assortiment img {
            width: 300px;
            height: auto;
            margin: 10px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .assortiment img:hover {
            transform: scale(1.05);
        }
  </style>
</head>
<body>

<?php
include('header.php');
?>
<div class="content">
        <div class="underHead">
            <div class="moved1">Сеть городских пекарнь</div>
            <div class="moved2">Аромат свежей выпечки - солнечное настроение на весь день</div>
            <img class="png1" src="1663681694_47-mykaleidoscope-ru-p-bulochka-s-koritsei-yeda-krasivo-55.jpg" alt="Булочка С Корицей">
        </div>
    
        <p class="text">Наш Ассортимент</p>
    
        <div class="assortiment">
        <a href="productPage.php?id=1"><img src="kruasan.jpg" alt="Круассан"></a>
        <a href="productPage.php?id=2"><img src="kolechkoSorexa,i.jpg" alt="Колечко с орехами"></a>
        <a href="productPage.php?id=3"><img src="vakBeluah.jpg" alt="Вафли Белуха"></a>
        <a href="productPage.php?id=4"><img src="plyuski.png" alt="плюшки"></a>
        <a href="productPage.php?id=5"><img src="vkusnoeChoto.png" alt="вкусняха5"></a>
        </div>
</div>
<?php
include('footer.php');
?>

</body>
</html>