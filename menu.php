<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    .titleForMenu{
            font-family: 'Lobster', cursive;
            font-size: 40px;
            font-style: italic;  
            color: #fdae06;
            text-align: center;
            margin-top: 50px;
        }

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

        .assortiment figure {
        margin: 0;
        padding: 0;
        text-align: center;
        }

        .assortiment figure img {
        max-width: 100%;
        height: auto;
        margin-bottom: 10px;
        }

        .assortiment figure figcaption {
        font-size: 20px;
        color: #333;
        text-align: center;
        margin-top: 10px;
        }
  </style>
</head>
<body>
  <?php
  include('header.php');
  ?>
<div class="content">
      <p class="titleForMenu">Меню</p>
      <div class="assortiment">
        <figure>
          <a href="productPage.php?product_id=1"><img src="kruasan.jpg" alt="Круассан"></a>
          <figcaption>Круассан</figcaption>
        </figure>
        <figure>
          <a href="productPage.php?product_id=2"><img src="kolechkoSorexa,i.jpg" alt="Колечко с орехами"></a>
          <figcaption>Колечко с орехами</figcaption>
        </figure>
        <figure>
          <a href="productPage.php?product_id=3"><img src="vakBeluah.jpg" alt="Вафли Белуха"></a>
          <figcaption>Вафли Белуха</figcaption>
        </figure>
        <figure>
          <a href="productPage.php?product_id=4"><img src="plyuski.png" alt="плюшки"></a>
          <figcaption>Плюшки</figcaption>
        </figure>
        <figure>
          <a href="productPage.php?product_id=5"><img src="vkusnoeChoto.png" alt="вкусняха5"></a>
          <figcaption>Булочка с корицей</figcaption>
        </figure>
        <figure>
          <a href="productPage.php?product_id=6"><img src="fDCJ2KnewiE.jpg" alt="улитки"></a>
          <figcaption>Улитка синнабон</figcaption>
        </figure>
        <figure>
          <a href="productPage.php?product_id=7"><img src="IfBlNlu5xmE.jpg" alt="торт1"></a>
          <figcaption>Ягодный торт</figcaption>
        </figure>
        <figure>
          <a href="productPage.php?product_id=8"><img src="it8EtJT5Ot8.jpg" alt="торт2"></a>
          <figcaption>Торт "Тающая загадка"</figcaption>
        </figure>
        <figure>
          <a href="productPage.php?product_id=9"><img src="kg9THTMgGTQ.jpg" alt="торт3"></a>
          <figcaption>Торт "Медовик"</figcaption>
        </figure>
        <figure>
          <a href="productPage.php?product_id=10"><img src="stqOW1O5LE4.jpg" alt="торт4"></a>
          <figcaption>Пироженное "Медовик"</figcaption>
        </figure>
        <figure>
          <a href="productPage.php?product_id=11"><img src="X7frW39GuRQ.jpg" alt="вкусняха6"></a>
          <figcaption>Булочка с маком</figcaption>
        </figure>
    </div>
    </div>
    <?php
  include('footer.php');
  ?>
</body>
</html>