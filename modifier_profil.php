<?php

require_once('inclure.php');

function securiser($donnee) {

    $donnee = trim($donnee);
    $donnee = htmlspecialchars($donnee);
    $donnee = stripslashes($donnee);

    return $donnee;
}

if (!isset($_SESSION['id'])){
    header('Location: index.php');
    exit;
   }

    $info = $DB->prepare('SELECT * from utilisateurs where id_utilisateur=?');

    $info->execute(array($_SESSION['id']));

    $info_user = $info->fetch();

    if(!empty($_POST)) {

        extract($_POST);

        $valide = true;

        if(isset($_POST['modifier'])) {
            $email = securiser($email);
            $telephone = securiser($telephone);

            // verifications du mail

            if(empty($email)) {
                $valide = false;
                $erreur_mail = "Le champ de l'adresse mail ne peut pas etre vide";
            }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $valide = false;
                $erreur_mail = "Vueiller renseigner un mail qui est valide";
            }else{
                $requete = $DB->prepare('SELECT id_utilisateur from utilisateurs where email=?');

                $requete->execute(array($email));

                $requete = $requete->fetch();

                if(isset($requete['id'])) {
                    $valide = false;
                    $erreur_mail = "Ce mail est lié a un autre compte";
                }
            }

            // verifications du telephone

            if(empty($telephone)) {
                $valide = false;
                $erreur_telephone = "Le champ du numero de telephone ne peut pas etre vide";
            }

            if($valide) {

                $requete = $DB->prepare('UPDATE utilisateurs SET email = ?, telephone = ? WHERE id_utilisateur = ?');

                $requete->execute(array($email, $telephone, $_SESSION['id']));

                header('location: profil.php');

                exit;
            }
        }
    }


// pour afficher les donneés de la base de donneés dans les zones de saisie

/*if(isset($info_user['email']) or isset($info_user['telephone']))
{$email = $info_user['email'];
$telephone = $info_user['telephone'];}*/



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
    <script src="assets/script.js" defer></script>
    <title>Modifier Mon Profil</title>
</head>
<body>

<?php include_once('logo.php'); include_once('menu.php'); ?>

    <div class="form-container">
        
        <form action="" method="post">

            <h3>Modifier Mes Informations</h3>

            <label for="email">Nouveau Email:</label>
            <div class="erreur"><?php  if(isset($erreur_mail)) { echo $erreur_mail; }  ?></div>
            <input type="email" name="email" value="<?php  if(isset($info_user['email'])) { echo $info_user['email']; }  ?>" class="box">

            <label for="telephone">Nouveau Telephone:</label>
            <div class="erreur"><?php  if(isset($erreur_telephone)) { echo $erreur_telephone; }  ?></div>
            <input type="text" name="telephone" value="<?php  if(isset($info_user['telephone'])) { echo $info_user['telephone']; }  ?>"  pattern="^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$" class="box">

            <input type="submit" name="modifier" value="Modifier Profil" class="btn">

        </form>

    </div>

    <?php include_once('footer.php'); ?>
</body>
</html>