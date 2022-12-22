<?php

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

            header('location: index.php');

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
    <script src="https://kit.fontawesome.com/13b8658640.js" crossorigin="anonymous"></script>
    
    <link rel="stylesheet" href="assets/style.css">
    <script src="assets/script.js" defer></script>
   
    <title>Mot de passe oublié</title>
</head>
<body>

<?php include_once('logo.php'); include_once('menu.php'); ?>

    
<div class="form-container">

    <form action="" method="post">

        <h3>Mot de Passe Oublié</h3>

        <label for="email">Vueillez renseigner votre adresse mail:</label>
        <input type="email" name="email" class="box">

        <p><i class="fa-light fa-circle-exclamation"></i>une fois votre demande soumise et si votre mail correspond a l'un de nos comptes vous allez recevoir un mail pour choisir un nouveau mot de passe</p>

        <input type="submit" value="Soumettre" name="modifier_mdp" class="btn">

    </form>

</div>

<?php include_once('footer.php'); ?>
   
</body>
</html>