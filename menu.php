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

<header class="header"> 
<div class="flex">
<?php 
    if(!isset($_SESSION['id'])){

    
?>
<nav class="navbar">

    <a href="index.php" class="nav-link">Acceuil</a>
    <a href="qui_sommes_nous.php" class="nav-link">Qui sommes nous ?</a>
    <a href="prestation.php" class="nav-link">Prestations</a>
    <a href="carte_grise.php" class="nav-link">Carte Grise</a>
    <a href="decalaminage.php" class="nav-link">Decalaminage</a>
    <a href="devis.php" class="nav-link">Devis</a>
    <a href="contact.php" class="nav-link">Contact</a>
    <a href="questions_recurrentes.php" class="nav-link">Questions Recurrentes</a>
    </nav>

     <div class="icons">
    <div id="menu-btn" class="fas fa-bars"></div>
</div>

<?php 
}
elseif(isset($_SESSION['id']) && in_array($_SESSION['role'], [1,2]) ) {
    ?>

    <nav class="navbar">

    <a href="index.php" class="nav-link">Acceuil</a>
    <a href="qui_sommes_nous.php" class="nav-link">Qui sommes nous ?</a>
    <a href="prestation.php" class="nav-link">Prestations</a>
    <a href="carte_grise.php" class="nav-link">Carte Grise</a>
    <a href="decalaminage.php" class="nav-link">Decalaminage</a>
    <a href="devis.php" class="nav-link">Devis</a>
    <a href="contact.php" class="nav-link">contact</a>
    <a href="questions_recurrentes.php" class="nav-link">Questions Recurrentes</a>
    <a href="admin/admin_accueil.php" class="nav-link">Administration</a>

    </nav>




    <div class="icons">
    <div id="menu-btn" class="fas fa-bars"></div>
    </div>


<?php }elseif(isset($_SESSION['id'])){

?>

<nav class="navbar">

   <a href="index.php" class="nav-link">Acceuil</a>
   <a href="qui_sommes_nous.php" class="nav-link">Qui sommes nous ?</a>
   <a href="prestation.php" class="nav-link">Prestations</a>
   <a href="carte_grise.php" class="nav-link">Carte Grise</a>
   <a href="decalaminage.php" class="nav-link">Decalaminage</a>
   <a href="devis.php" class="nav-link">Devis</a>
   <a href="contact.php" class="nav-link">contact</a>
   <a href="questions_recurrentes.php" class="nav-link">Questions Recurrentes</a>
   
</nav>




<div class="icons">
   <div id="menu-btn" class="fas fa-bars"></div>
   </div>

<?php
}  ?>
</div>

</div>
</header>


</body>
</html>