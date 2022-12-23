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
    <link rel="stylesheet" href="assets/style.css">
    <script src="assets/script.js" defer></script>
    <title>Profile</title>
</head>
<body>

<?php include_once('logo.php'); include_once('menu.php'); ?>

<div class="container-profil">
<h3><span>Profile de <?= $requete_utilisateur['nom'] ?></span></h3>

    <div class="profil"> 

    <div><span>Email:</span> <?= $requete_utilisateur['email'] ?></div><br />
    <div><span>Telephone:</span> <?= $requete_utilisateur['telephone'] ?></div><br />
    <div><span>Adresse:</span> <?= $requete_utilisateur['adresse'] ?></div><br />
    <div><span> Code Postal: </span><?= $requete_utilisateur['code_postale'] ?></div><br />
    <div><span> Ville:</span> <?= $requete_utilisateur['ville'] ?></div><br />
    <div><span>Pays: </span><?= $requete_utilisateur['pays'] ?></div><br />
    </div>
    
    
    <div class="btn-contact2"><a href="modifier_profil.php" class="btn-contact">Modifier Mon Profile</a>
    <a href="modifier_mdp.php" class="btn-contact">Modifier Mon Mot de Passe</a></div>
   </div>

</form>
</div><br />
<br />
<br />

<?php include_once('footer.php'); ?>

</body>
</html>