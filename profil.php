<?php

require_once('inclure.php');

if (!isset($_SESSION['id'])){
    header('Location: index.php');
    exit;
   }

$requete = $DB->prepare('SELECT * FROM utilisateurs where id_utilisateur = ?');

$requete->execute(array($_SESSION['id']));

$requete_utilisateur = $requete->fetch();

switch($requete_utilisateur['id_role']) {
    case 1 :
    $requete_utilisateur['id_role'] = 'Super Admin';
    break;
    case 2 :
    $requete_utilisateur['id_role'] = 'Admin';
    break;
    case 3 :
    $requete_utilisateur['id_role'] = 'Utilisateur';
    break;
}

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

    <?php  include ('navbar.php') ?>

    <h1>Profile de <?= $requete_utilisateur['nom'] ?></h1>
    <div>Email: <?= $requete_utilisateur['email'] ?></div>
    <div>Telephone: <?= $requete_utilisateur['telephone'] ?></div>
    <div>Role: <?= $requete_utilisateur['id_role'] ?></div>
    <div><a href="modifier_profil.php">Modifier Mon Profile</a></div>
    <div><a href="modifier_MDP.php">Modifier Mon Mot de Passe</a></div>

</body>
</html>