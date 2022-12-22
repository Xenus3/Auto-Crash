<?php

require_once('inclure.php');

// fonction pour securiser les zones de saisie

function securiser($donnee) {

    $donnee = trim($donnee);
    $donnee = htmlspecialchars($donnee);
    $donnee = stripslashes($donnee);

    return $donnee;
}

// si aucune seesion n'exite renvoyer vers l'index

if (!isset($_SESSION['id'])){
    header('Location: index.php');
    exit;
   }

   if(!empty($_POST)) {

    extract($_POST);

    $valide =(boolean) true;

        if(isset($_POST['modifier_mdp'])) {
            $mdp = securiser($mdp);
            $nouveau_mdp = securiser($nouveau_mdp);
            $confirm_mdp = securiser($confirm_mdp);

            if(empty($mdp)) {
                $valide = false;
                $erreur_mdp = "Ce champ ne peut pas etre vide";
            }else{
                $requete = $DB->prepare('SELECT mot_de_passe from utilisateurs where id_utilisateur = ?');

                $requete->execute(array($_SESSION['id']));

                $requete = $requete->fetch();

                if(isset($requete['mot_de_passe'])) {
                    if(!password_verify($mdp, $requete['mot_de_passe'])) {
                        $valide = false;
                        $erreur_mdp = "Ce mot de passe est incorrecte";
                    }
                }else{
                    $valide = false;
                    $erreur_mdp = "Ce champ ne peut etre vide";
                }
            }

            // verification du mot de passe

            if($valide) {
                if(empty($nouveau_mdp)) {
                    $valide = false;
                    $erreur_nmdp = "Ce champ ne peut pas etre vide";
                }elseif(empty($confirm_mdp)) {
                    $valide = false;
                    $erreur_conf = "Ce champ ne peut pas etre vide";
                }elseif($nouveau_mdp <> $confirm_mdp) {
                    $valide = false;
                    $erreur_conf  = "Le mot de passe et sa confirmation ne correspondent pas";
                }elseif($nouveau_mdp === $mdp) {
                    $valide = false;
                    $erreur_nmdp  = "Le nouveau mot de passe ne peut etre le meme que l'ancient mot de passe";
                }
            }

            // insertion du nouveau mot de passe dans la base de donnee

            if($valide) {

                $mdp_crypté = password_hash($nouveau_mdp, PASSWORD_DEFAULT);

                $requete = $DB->prepare('UPDATE utilisateurs SET mot_de_passe = ? WHERE id_utilisateur = ?');

                $requete->execute(array($mdp_crypté, $_SESSION['id']));

                $annonce = "votre mot de passe a été changé";

                header('location: profil.php');
                exit;
            }
        }

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
    <title>Modifier Mon Compte</title>
</head>
<body>

<?php include_once('logo.php'); include_once('menu.php'); ?>

<div class="form-container">
   
    <form action="" method="post">

        <h3>Modifier Mon Mot de Passe</h3>

        <label for="email">Mot de passe actuel:</label>
        <div class="erreur"><?php  if(isset($erreur_mdp)) { echo $erreur_mdp ; }  ?></div>
        <input type="password" name="mdp" value="" class="box">

        <label for="nouveau_mdp">Nouveau mot de passe:</label>
        <div class="erreur"><?php  if(isset($erreur_nmdp)) { echo $erreur_nmdp; }  ?></div>
        <input type="password" name="nouveau_mdp" value="" class="box">

        <label for="confirm_mdp">Confirmez mot de passe:</label>
        <div class="erreur"><?php  if(isset($erreur_conf)) { echo $erreur_conf; }  ?></div>
        <input type="password" name="confirm_mdp" value="" class="box">

        <input type="submit" name="modifier_mdp" value="Modifier mot de passe" class="btn">

    </form>
 
</div>

<?php include_once('footer.php'); ?>

</body>
</html>