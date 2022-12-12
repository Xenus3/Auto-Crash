<?php

require_once('inclure.php');

if(isset($_SESSION['id'])) {
    $saluer = "Bonjour " . $_SESSION['prenom'] . " " . $_SESSION['nom'];
}elseif(isset($_COOKIE['souvient_toi'])) {
    $requete = $DB->prepare('SELECT * from utilisateurs where souvient_toi = ?');
    $requete->execute(array($_COOKIE['souvient_toi']));
    $requete = $requete->fetch();

    if($requete['id_utilisateur']) {
        $_SESSION['id'] = $requete['id_utilisateur'];
        $_SESSION['nom'] = $requete['nom'];
        $_SESSION['prenom'] = $requete['prenom'];
        $_SESSION['email'] = $requete['email'];
        $_SESSION['role'] = $requete['id_role'];
    }

    $saluer = "Bonjour " . $requete['prenom'] . " " . $requete['nom'];
    header('location: index.php');
    exit;
}else{
    
$saluer = "Bonjour Etranger";
    
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
    <script src="assets/script.js" defer></script>
    
    <title>Document</title>
    
</head>
<body>
 <?php  include_once('logo.php'); include_once('menu.php') ?>
    <h1><?= $saluer ?></h1>

    
    <?php include_once('footer.php'); ?>
</body>
</html>

