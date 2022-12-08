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

if(!empty($_POST)) {

    extract($_POST);

    $valide = true;

    if(isset($_POST['modifier_mdp'])) {
        $email = securiser($email);

        $requete = $DB->prepare('SELECT id_utilisateur FROM utilisateurs WHERE email = ?');

        $requete->execute(array($email));

        $requete = $requete->fetch();

        if(!isset($requete['id_utilisateur'])) {
            $valide = false;
            $message_erreur = "Aucun compte n'est lié a ce mail";
        }

        if($valide) {

            $token = hash("sha256", random_bytes(32));
            
            //=====Création du header de l'e-mail.
            $header = "From: acefofo9@gmail.com\n";
            $header .= "MIME-version: 1.0\n";
            $header .= "Content-type: text/html; charset=utf-8\n";
            $header .= "Content-Transfer-ncoding: 8bit";
            //=======
                            
            //=====Ajout du message au format HTML          
            $contenu = '<p>Bonjour ' . $requete['nom'] . ',</p><br>
            <p>Veuillez cliquer sur ce lien pour <a href="http://localhost/php/auto-crash/changer_mdp.php?email=' . $email . '&token=' .   $token . '">choisir un nouveau mot de passe</a><p>';
                                                
            mail($email, 'Mot de passe oublié', $contenu, $header);

            header('location: connexion.php');

            $_SESSION['email'] = $email;
            $_SESSION['token'] = $token;

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
    <title>Mot de passe oublié</title>
</head>
<body>

    <?php  include ('navbar.php') ?>

    <h1>Veuillez renseigner votre adresse mail</h1>

    <form action="" method="post">
        <input type="email" name="email">
        <input type="submit" value="Soumettre" name="modifier_mdp">
    </form>
    
</body>
</html>