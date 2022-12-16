<?php 

include_once('../inclure.php');



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
   if(!isset($_SESSION['id_utilisateur'])){

    
?>
<nav class="navbar">
    <a href="admin_accueil.php" class="nav-link">Acceuil</a>
    <a href="admin_carte_grise.php" class="nav-link">Carte Grise</a>
    <a href="rendez-vous.php" class="nav-link">Decalaminage</a>
    <a href="admin_utilisateurs.php" class="nav-link">Membres</a>
    <a href="admin_messages.php" class="nav-link">Contact</a>
    <a href="../index.php" class="nav-link">Retour au site</a>
    </nav>

     <div class="icons">
    <div id="menu-btn" class="fas fa-bars"></div>
</div>

<?php 
}
else{

 ?>

<nav class="navbar">
    <a href="admin_accueil.php" class="nav-link">Acceuil</a>
    <a href="admin_carte_grise.php" class="nav-link">Carte Grise</a>
    <a href="rendez-vous.php" class="nav-link">Rendez-vous</a>
    <a href="admin_utilisateurs.php" class="nav-link">Membres</a>
    <a href="admin_messages.php" class="nav-link">Contact</a>
    <a href="../index.php" class="nav-link">Retour au site</a>

</nav>




 <div class="icons">
    <div id="menu-btn" class="fas fa-bars"></div>
    </div>

<?php
}?>



</div>

</div>
</header>


</body>
</html>