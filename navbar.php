<?php



?>
<ul>
    <li><a href="index.php">Accueil</a></li>
    <?php 
    if(!isset($_SESSION['id'])) {
    ?>
    <li><a href="inscription.php">Inscription</a></li>
    <li><a href="connexion.php">Connection</a></li>
    <?php 
    }else{
    ?>
     <li><a href="deconnexion.php">Déconnexion</a></li>
    <?php 
    }
    ?>
</ul>