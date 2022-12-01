<?php

// fonction pour securiser les zones de saisie

function securiser($donnee) {

    $donnee = trim($donnee);
    $donnee = htmlspecialchars($donnee);
    $donnee = stripslashes($donnee);

    return $donnee;
}

if(!empty($_POST)) {

    extract($_POST);

    $valid =(boolean) true;

    if(isset($_POST["inscription"])) {
        $nom = securiser($nom);
        $prenom = securiser($prenom);
        $email = securiser($email);
        $tel = securiser($tel);
        $mdp = securiser($mdp);
        $confirmerMail = securiser($confirmerMail);
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="asset/style.css">
    <script src="asset/script.js" defer></script>
    <title>Inscription</title>
</head>
<body>
    <div class="form">
        <h1>Inscription Auto Crash</h1>
        <form action="" method="POST">
            <label for="nom">Nom:</label>
            <input type="text" name="nom" value="<?php if(isset($nom)) { echo $nom; } ?>">
            <label for="prenom">Prenom:</label>
            <input type="text" name="prenom" value="<?php if(isset($prenom)) { echo $prenom; } ?>">
            <label for="email">Email:</label>
            <input type="text" name="email" value="<?php if(isset($email)) { echo $email; } ?>">
            <label for="tel">N°tel:</label>
            <input type="text" name="tel" value="<?php if(isset($tel)) { echo $tel; } ?>">
            <label for="mdp">Mot de passe:</label>
            <input type="text" name="mdp" value="<?php if(isset($mdp)) { echo $mdp; } ?>">
            <label for="confirmer">Confirmation du mot de passe:</label>
            <input type="text" name="confirmerMail" value="<?php if(isset($confirmerMail)) { echo $confirmerMail; } ?>">
            <input type="submit" value="Soumettre" name="inscription">
        </form>
    </div>
    
</body>
</html>