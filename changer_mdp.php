<?php

require_once('inclure.php');

if(isset($_SERVER['id_utilisateur'])) {
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
    <form method="post" action="">
    <input type="hidden" name="email" value="<?php echo $_GET['email'];?>">
    <p>Choisissez votre nouveau mot de passe</p>
    <input type="password" name='password'>
    <input type="password" name='confirm_password'>
    <input type="submit" name="nouveau_mdp" value="Soumettre">
    </form>
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
        }

        if($valide) {

            $password = password_hash($password , PASSWORD_DEFAULT);

            $requete = $DB->prepare('UPDATE utilisateurs SET mot_de_passe = ? WHERE email = ?');

            $requete->execute(array($password, $email));

            header('location: connexion.php');

            exit;
        }

    }
}
}
?>