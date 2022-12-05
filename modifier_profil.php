<?php

require_once('inclure.php');

if (!isset($_SESSION['id'])){
    header('Location: index.php');
    exit;
   }

    $info = $DB->prepare('SELECT * from utilisateurs where id_utilisateur=?');

    $info->execute(array($_SESSION['id']));

    $info_user = $info->fetch();

   

    if((isset($_POST['email']) and $_POST['email'] <> $_SESSION['email']) or (isset($_POST['telephone']) and $_POST['telephone'] <> $_SESSION['telephone'])) {

    $requete = $DB->prepare('UPDATE utilisateurs SET email = ?, telephone = ? WHERE id_utilisateur = ?');

    $requete->execute(array($_POST['email'], $_POST['telephone'], $_SESSION['id']));

 

    header('location: profil.php');

    exit;

} else{

}



if(isset($info_user['email']) or isset($info_user['telephone']))
{$email = $info_user['email'];
$telephone = $info_user['telephone'];}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Mon Compte</title>
</head>
<body>

    <?php  include ('navbar.php') ?>

    <h1>Modifier Mes Informations</h1>

    <?=  isset($message_erreur) ? $message_erreur : null ?>

    <form action="" method="post">
        <label for="email">Nouveau Email:</label>
        <input type="email" name="email" value="<?= $email ?> " required>
        <label for="telephone">Nouveau Telephone:</label>
        <input type="text" name="telephone" value="<?= $telephone ?>" required pattern="^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$">
        <input type="submit" name="modifier" value="Modifier">
    </form>
    

</body>
</html>