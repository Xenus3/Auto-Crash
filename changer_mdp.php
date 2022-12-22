<?php
ob_start();
require_once('inclure.php');

if(isset($_SESSION['id'])) {
    header('location: index.php');
    exit;
}

function securiser($donnee) {

    $donnee = trim($donnee);
    $donnee = htmlspecialchars($donnee);
    $donnee = stripslashes($donnee);

    return $donnee;
}

 $token = $_SESSION['token'];


if($_GET['email']  && $_GET['token'] === $token)
{
  $requete = $DB->prepare('SELECT id_utilisateur FROM utilisateurs WHERE email = ?');

  $requete->execute(array($_GET['email']));

  $requete = $requete->fetch();

  if(isset($requete['id_utilisateur']))
  {
    ?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
    <script src="assets/script.js" defer></script>
    <title>Modifier Mon Compte</title>
</head>
<body>

<?php include_once('logo.php'); include_once('menu.php'); ?>

<div class="form-container">

    <form method="post" action="">

    <input type="hidden" name="email" value="<?php echo $_GET['email'];?>">

    <h3>Choisissez votre nouveau mot de passe</h3>

    <label for="password">Nouveau mot de passe:</label>
    <div class="erreur"><?php  if(isset($message_erreur)) { echo $message_erreur; }  ?></div>
    <input type="password" name='password' class="box">

    <label for="confirm_password">Confirmez votre nouveau mot de passe:</label>
    <input type="password" name='confirm_password' class="box">

    <input type="submit" name="nouveau_mdp" value="Soumettre" class="btn">
    </form>

</div>

<?php include_once('footer.php'); ?>

</body>
</html>

<?php

  }

  if(!empty($_POST)) {
    
    extract($_POST);
    
    $valide = true;

    if(isset($_POST['nouveau_mdp'])) {

        $email = securiser($email);
        $password = securiser($password);
        $confirm_password = securiser($confirm_password);

        if($password <> $confirm_password) {
            $valide = false;
            $message_erreur = "Le mot de passe et sa confirmation ne correspondent pas";
        } elseif(empty($password) or empty($confirm_password)) {
            $valide = false;
            $message_erreur = "Aucun des deux champs ne peut etre vide";
        }

        if($valide) {

            $password = password_hash($password , PASSWORD_DEFAULT);

            $requete = $DB->prepare('UPDATE utilisateurs SET mot_de_passe = ? WHERE email = ?');

            $requete->execute(array($password, $email));

            header('location: inscription.php');

            exit;
        }

        

    }

    
}
}
?>