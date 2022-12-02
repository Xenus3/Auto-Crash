<?php

include ('_db/connexionDB.php');

// Fonction pour securiser les zones de saisie

function securiser($donnee) {

    $donnee = trim($donnee);
    $donnee = htmlspecialchars($donnee);
    $donnee = stripslashes($donnee);

    return $donnee;
}

// Insertion dans base de donneés

if(!empty($_POST)) {

    extract($_POST);

    $valide =(boolean) true;

    if(isset($_POST["inscription"])) {

        $nom = securiser($nom);
        $prenom = securiser($prenom);
        $email = securiser($email);
        $tel = securiser($tel);
        $mdp = securiser($mdp);
        $confirmer_mdp = securiser($confirmer_mdp);

        if(empty($nom) or empty($prenom) or empty($email) or empty($tel) or empty($mdp) or empty($confirmer_mdp)) {

            $message_erreur = "Ce champ ne peut etre vide";
            $valide = false;

        }elseif($mdp <> $confirmer_mdp){

            $message_erreur = "La mot de passe et sa confirmation ne correspondent pas";
            $valide = false;

        }else{

            $requete = $DB->prepare("SELECT id_utilisateur from utilisateurs where email=?");

            $requete->execute(array($email));

            $requete = $requete->fetch();

            if(isset($requete["id_utilisateur"], $_POST["inscription"])) {

                $valide = false;
                $message_erreur = "L'adresse mail que vous avez renseigné est lieé a un autre compte";

            }
        }

        if($valide) {

            $inserer = $DB->prepare("INSERT INTO utilisateurs (nom, prenom, email, mail_token, telephone, mot_de_passe, id_role) VALUES (:nom, :prenom, :email, :mail_token, :telephone, :mot_de_passe, :id_role)");

            $token = bin2hex(random_bytes(12));
            $id_role = 1;
            $mdp_crypte = password_hash($mdp, PASSWORD_DEFAULT);

            $inserer->execute(array(":nom" => $nom,
                                    ":prenom" => $prenom,
                                    ":email" => $email,
                                    ":mail_token" => $token,
                                    ":telephone" => $tel,
                                    ":mot_de_passe" => $mdp_crypte,
                                    ":id_role" => $id_role
                                    ));

            // Email de verification

            $mail = $DB->prepare("SELECT * FROM utilisateurs WHERE email=?");
            $mail->execute(array($email));
                            
            $mail = $mail->fetch();
                            
            $mail_to = $mail['email'];
                            
            //=====Création du header de l'e-mail.
            $header = "From: acefofo9@gmail.com\n";
            $header .= "MIME-version: 1.0\n";
            $header .= "Content-type: text/html; charset=utf-8\n";
            $header .= "Content-Transfer-ncoding: 8bit";
            //=======
                            
            //=====Ajout du message au format HTML          
            $contenu = '<p>Bonjour ' . $mail['nom'] . ',</p><br>
            <p>Veuillez confirmer votre compte <a href="http://localhost/php/auto-crash/mail_conf.php?id=' . $mail['id_utilisateur'] . '&token=' .   $token . '">Valider</a><p>';
                                                
            mail($mail_to, 'Confirmation de votre compte', $contenu, $header);

            exit;

            header('location: connexion.php');
        }else{

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
    <link rel="stylesheet" href="asset/style.css">
    <script src="asset/script.js" defer></script>
    <title>Inscription</title>
</head>
<body>
    <div class="form">
        <h1>Inscription Auto Crash</h1>
        <form action="" method="POST">
            <?php if(isset($message_erreur)) { echo "<div>$message_erreur</div>"; } ?>
            <label for="nom">Nom:</label>
            <input type="text" name="nom" value="<?php if(isset($nom)) { echo $nom; } ?>" required>
            <label for="prenom">Prenom:</label>
            <input type="text" name="prenom" value="<?php if(isset($prenom)) { echo $prenom; } ?>">
            <label for="email">Email:</label>
            <input type="text" name="email" value="<?php if(isset($email)) { echo $email; } ?>">
            <label for="tel">N°tel:</label>
            <input type="text" name="tel" value="<?php if(isset($tel)) { echo $tel; } ?>">
            <label for="mdp">Mot de passe:</label>
            <input type="password" name="mdp" value="<?php if(isset($mdp)) { echo $mdp; } ?>">
            <label for="confirmer">Confirmation du mot de passe:</label>
            <input type="password" name="confirmer_mdp" value="">
            <input type="submit" value="Soumettre" name="inscription">
        </form>
    </div>
    
</body>
</html>