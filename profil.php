<?php

require_once('inclure.php');

if (!isset($_SESSION['id'])){
    header('Location: index.php');
    exit;
   }

$requete = $DB->prepare('SELECT * FROM utilisateurs where id_utilisateur = ?');

$requete->execute(array($_SESSION['id']));

$requete_utilisateur = $requete->fetch();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>
<body>
    <h1>Profile de <?= $requete_utilisateur['nom'] ?></h1>
    <div>Email: <?= $requete_utilisateur['email'] ?> <span><a href="">Modifier</a></span></div>
    <div>Telephone: <?= $requete_utilisateur['telephone'] ?> <span><a href="">Modifier</a></span></div>
    <div><a href="">Changer mot de passe</a></div>
</body>
</html>