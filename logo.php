<?php 

include_once('inclure.php');


if(isset($message)){
    foreach($message as $message){ //pour afficher les messages d'erreurs
        echo  '
        <div class="message">
    <span> '.$message.' </span>
    <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
          </div>';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="assets/style.css">
    <title>Acceuil</title>
</head>
<body>

<header class="header_menu"> 
<div class="flex">
<?php 
   if(!isset($_SESSION['id_utilisateur'])){

    
?>
<nav class="menu">
<img src="image/rogner.png">
<i class="fa-solid fa-phone"></i>  03 27 64 59 71
<i class="fa-sharp fa-solid fa-envelope"></i> autocrash@orange.fr

    </nav>

     <div class="icons">
    <a href="https://www.facebook.com/garageautocrash/" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
    <a href="search_page.php"><i class="fas fa-search"></i></a>
 <a href="inscription.php"><i class="fa-solid fa-circle-user"></i> Mon compte</a>
</div>

<?php 
}
else{

 ?>

<nav class="menu">
<img src="image/rogner.png">
<i class="fa-solid fa-phone"></i>  03 27 64 59 71
<i class="fa-sharp fa-solid fa-envelope"></i> autocrash@orange.fr


</nav>

 <div class="icons">
    <a href="https://www.facebook.com/garageautocrash/" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
    <a href="search_page.php"><i class="fas fa-search"></i></a>
    <a href="profil.php"><i class="fa-solid fa-circle-user"></i></a>
    <a href="deconnexion.php" class="nav-link"><i class="fa-solid fa-arrow-right-from-bracket"></i> deconnexion</a>

</div>

<?php
}?>



</div>

</div>
</header>


</body>
</html>