<?php


require_once('inclure.php');


function securiser($donnee) {

    $donnee = trim($donnee);
    $donnee = htmlspecialchars($donnee);
    $donnee = stripslashes($donnee);

    return $donnee;
}

// Si une session existe alors on quitte cette page  
if (isset($_SESSION['id'])){
     header('Location: index.php');
     exit;
    }

    if(!empty($_POST)) {

        extract($_POST);
    
        $valide =(boolean) true;
    
        if(isset($_POST["connexion"])) {
            $email = securiser($email);
            $mdp = securiser($mdp);

            if(empty($email) or empty($mdp)) {
                $valide = false;
                $message_erreur = "Tout les champs doivent etre remplis";
            }

            if($valide) {
                $requete = $DB->prepare('SELECT mot_de_passe FROM utilisateurs WHERE email=?');
                $requete->execute(array($email));
                $requete = $requete->fetch();

                if(isset($requete['mot_de_passe'])) {

                    if(!password_verify($mdp, $requete['mot_de_passe'])){

                        $valide = false;
                        $message_erreur = "Mot de passe incorrect ou ne coresspond pas a ce compte";

                    }

                }else{
                    $valide = false;
                    $message_erreur = "";
                }
            }

            if($valide) {

                $connect = $DB->prepare('SELECT * FROM utilisateurs WHERE email=?');
                $connect->execute(array($email));
                $connect_util = $connect->fetch();

                if(isset($connect_util['id_utilisateur'])) { 

                    $_SESSION['id'] = $connect_util['id_utilisateur'];
                    $_SESSION['email'] = $connect_util['email'];
                    $_SESSION['nom'] = $connect_util['nom'];
                    $_SESSION['prenom'] = $connect_util['prenom'];
                    $_SESSION['role'] = $connect_util['id_role'];
                    $_SESSION['telephone'] = $connect_util['telephone'];
                    //$_SESSION['mdp'] = $connect_util['mot_de_passe'];

                }else {
                    $valide = false;
                    $message_erreur = "";
                }

                header('location: index.php');

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
    <title>Connexion</title>
</head>
<body>

<?php  include ('navbar.php') ?>

    <div>Page de connexion</div>

    <form action="" method="post">
        <label for="email">Votre Email:</label>
        <input type="text" name="email">
        <label for="mdp">Votre mot de passe:</label>
        <input type="password" name="mdp">
        <input type="submit" value="Se Connecter" name="connexion">
    </form>
    
</body>
</html>