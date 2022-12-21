<?php 
include_once('inclure.php');



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="assets/style.css">
    <script
  src="https://code.jquery.com/jquery-3.6.3.slim.js"
  integrity="sha256-DKU1CmJ8kBuEwumaLuh9Tl/6ZB6jzGOBV/5YpNE2BWc="
  crossorigin="anonymous" defer></script>
    <script src="assets/script.js" defer></script>
    <title>Document</title>
</head>
<body data-title="accueil">
<?php 
include_once('logo.php');
include_once('menu.php');?>

    <div class="slider">
        <img src="image/photo_4.jpeg" alt="img1" class="img__slider active" />
        <img src="image/photo_5.jpeg" alt="img2" class="img__slider" />
        <img src="image/photo_6.jpeg" alt="img3" class="img__slider" />
        <div class="suivant">
            <i class="fa-solid fa-arrow-right"></i>
        </div>
        <div class="precedent">
           <i class="fa-solid fa-arrow-left"></i>
        </div>
    </div>


<?php include_once('footer.php'); ?>

</body>
</html>

