<?php 
include_once('inclure.php');

if(isset($_SESSION['id'])){
    header('Location: index.php');
    exit;
}

if(!empty($_POST)){
    extract($_POST);

$valid = (boolean) true;

    if(isset($_POST['inscription'])){

           //securiser

       /* function secure($donnees){
        $donnees = trim($donnees);
        $donnees = stripslashes($donnees);
        $donnees = htmlspecialchars($donnees);
        return $donnees;
    }*/

        $nom = secure($nom);
        $prenom = secure($prenom);
        $telephone = secure($telephone);
        $email = secure($email);
        $confemail = secure($confemail);
        $pass = secure($pass);
        $confpass = secure($confpass);

        if(empty($nom)){
            $valid = false;
            $err_nom = "Veuillez entrer votre nom";
        } 
        elseif(grapheme_strlen($nom)<3){ // graphem_strLen permet de reduire les emot ou caractères spéciaux à 1

            $valid = false;
            $err_nom = "ce nom doit faire plus de 2 caractères";

        }
           elseif(grapheme_strlen($nom)>=30){ 
            $valid = false;
            $err_nom = "ce nom doit faire moins de 31 caractères (" . grapheme_strlen($nom) . "/30)";

        }
        

        
        if(empty($prenom)){
            $valid = false;
            $err_prenom = "Veuillez entrer votre prénom";
        }
            elseif(grapheme_strlen($prenom)<3){
            $valid = false;
            $err_prenom = "ce nom doit faire plus de 2 caractères";

        }

            elseif(grapheme_strlen($prenom)>30){
            $valid = false;
            $err_prenom = "ce nom doit faire moins de 31 caractères (" . grapheme_strlen($prenom) . "/30)";

        }

        if(empty($email)){
            $valid = false;
            $err_email = "Veuillez entrer une adresse e-mail";

        }
        
        elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $valid = false;
            $err_email = "Adresse e-mail invalide";

        }

        elseif($email<>$confemail){

            $valid = false;
            $err_email = "l'adresse email est différente ";
        
        
        }else
        {
            $req = $DB->prepare("SELECT id_utilisateur FROM `utilisateurs` WHERE email = ?");
            $req->execute(array($email));
            $req = $req->fetch();

            if(isset($req['id_utilisateur'])){
                $valid = false;
                $err_email = "l'adresse e-mail des déjà prise";
            }
            
        }


        if(empty($pass)){
        $valid = false;
        $err_pass = "Veuillez entrer un mot de passe";
        }

        elseif($pass<>$confpass){

        $valid = false;
        $err_pass = "le mot de passe est différent";
        
        
        }



        if($valid){
        
        //$crypt_pass = crypt($pass, '$6$rounds=5000$9-DJf7+2;J6v+AujJdIPBKAg=cPd|l[>6D[sTwFy/;;qCfL4Lm+*4W)C++2Nq0,-$'); // crypter le mot de passe en PHP 
        $crypt_pass = password_hash($pass, PASSWORD_ARGON2ID);
        $token = bin2hex(random_bytes(12));

        $req = $DB->prepare("INSERT INTO utilisateurs( nom, prenom, telephone, email, mail_token, mot_de_passe)
        VALUES (?, ?, ?, ?, ?, ?)");

        $req->execute(array($nom, $prenom, $telephone, $email, $token, $crypt_pass));

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
        <p>Veuillez confirmer votre compte <a href="http://localhost/php/auto-crash-sallome/conf.php?id=' . $mail['id_utilisateur'] . '&token=' .   $token . '">Valider</a><p>';
        			
        mail($mail_to, 'Confirmation de votre compte', $contenu, $header);


        exit;

        header('location: connexion.php');


        } else {
            // rien (affichage des messages d'erreurs)
        }

    }
    }



if(!empty($_POST)){
    extract($_POST);

$valid = (boolean) true;

if(isset($_POST['connexion'])){

           //securiser

        function secure($donnees){
        $donnees = trim($donnees);
        $donnees = stripslashes($donnees);
        $donnees = htmlspecialchars($donnees);
        return $donnees;
    }

     $emaile = secure($mail);
     $mdp = secure($mdp);

      if(empty($mail)){
        $valid = false;
        $err_maile = "Veuillez entrer une adresse e-mail";
        } 

      if(empty($mdp)){
        $valid = false;
        $err_mdp = "Veuillez entrer un mot de passe";
        }

    if($valid){
        $req = $DB->prepare("SELECT mot_de_passe FROM utilisateurs WHERE email = ?");
        $req->execute(array($mail));
        $req = $req->fetch();

        if(isset($req['mot_de_passe'])){
        if(!password_verify($mdp, $req['mot_de_passe'])){
                    $valid = false;
        $err_mdp = "L'email ou le mot de passe sont incorrects.";

        }

        }else{
        $valid = false;
        $err_mdp = "L'email ou le mot de passe sont incorrects.";
        }
    }

    if($valid){

        $req = $DB->prepare("SELECT * FROM utilisateurs WHERE email = ?");
        $req->execute(array($mail));
        $req_user = $req->fetch();

        if(isset($req_user['id_utilisateur'])){

        $req = $DB->prepare("UPDATE utilisateurs
        WHERE id_utilisateur = ?");
        $req->execute(array($req_user['id_utilisateur']));

        $_SESSION['id'] = $req_user['id_utilisateur'];
        $_SESSION['nom'] = $req_user['nom'];
        $_SESSION['prenom'] = $req_user['prenom'];
        $_SESSION['email'] = $req_user['email'];
        $_SESSION['role'] = $req_user['id_role'];

        /*if(isset($remember)){
            setcookie("comail", urldecode($_SESSION['email']), time()+60*60*24*100, "/");
            setcookie("copass", $crypt_pass->crypt($mdp), time()+60*60*24*100, "/");
        }else
        {
            setcookie("comail", NULL , -1, "/");
            setcookie("copass", NULL , -1, "/");
        }*/

        header('location: index.php');
                exit;

    }else{
        $valid = false;
        $err_mdp = "L'email ou le mot de passe sont incorrects.";
    }

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="assets/style.css">
    <title>Document</title>
</head>
<body>

<?php 
include_once('logo.php');
include_once('menu.php');?>

<div class="form-container">
    
  <form method="post">

   <h3> Se connecter</h3>

        <label for="mail">Mail:</label>
        <div class="erreur"><?php if(isset($err_mail)){echo $err_mail;}?></div>
        <input type="email" name="mail" value="<?php if(isset($mail) && !isset($_COOKIE['comail'])){echo $mail;}
        if(isset($_COOKIE['comail'])){echo urldecode($_COOKIE['comail']);}?>" class="box"> 
        


        <label for="pass">Mot de passe:</label>
        <div class="erreur"><?php if(isset($err_mdp)){echo $err_mdp;}?></div>
        <input type="password" name="mdp" value="<?php if(isset($mdp) && !isset($_COOKIE['copass'])){echo $mdp;} if(isset($_COOKIE['copass'])){echo $crypt_pass->decrypt($_COOKIE['copass']);}?>" class="box">
         

        <input type="checkbox" name="remember" <?php if(isset($_COOKIE['copass']) &&($_COOKIE['copass']!="")){echo "checked";}?>> Se souvenir 
        
    <button type="submit" name="connexion" class="btn">Connexion </button>

    
    <a href="forgot_password.php">Mot de passe oublié ? </a>



    </form>

    <div class="container_line"></div>

        <form method="post">

    <h3> Inscription</h3>

        
        <label for="nom">Nom:</label>
        <div class="erreur"><?php if(isset($err_nom)){echo $err_nom;}?></div>
        <input type="text" name="nom" value="<?php if(isset($nom)){echo $nom;}?>" class="box"> 
        
        
        <label for="prenom">Prenom:</label>
        <div class="erreur"><?php if(isset($err_prenom)){echo $err_prenom;}?></div>
        <input type="text" name="prenom" value="<?php if(isset($prenom)){echo $prenom;}?>"  class="box"> 
        

        <label for="email">Mail:</label>
        <div class="erreur"><?php if(isset($err_email)){echo $err_email;}?></div>
        <input type="email" name="email" value="<?php if(isset($email)){echo $email;}?>"  class="box"> 
        

        <label for="email">Confirmation du Mail:</label>
        <input type="email" name="confemail" value="<?php if(isset($confemail)){echo $confemail;}?>" class="box">

        <label for="pass">Mot de passe:</label>
        <div class="erreur"><?php if(isset($err_pass)){echo $err_pass;}?></div>
        <input type="password" name="pass" value="<?php if(isset($pass)){echo $pass;}?>"  class="box"> 
        

        <label for="confpass">Confirmation du Mot de passe:</label>
        <input type="password" name="confpass" value="<?php if(isset($confpass)){echo $confpass;}?>"  class="box"> 



    <button type="submit" name="inscription" class="btn">S'inscrire</button>

    </form>

</div>



<?php include_once('footer.php'); ?>
<script src="assets/script.js"></script>
</body>
</html>