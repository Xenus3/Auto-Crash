<?php 
include_once('inclure.php');



if(!empty($_POST)){

    extract($_POST);

    $valide = (boolean) true;

    if(isset($_POST['contacter'])){

        // fonction pour securiser les zones de saisie

       function secure($donnees){
        $donnees = trim($donnees);
        $donnees = stripslashes($donnees);
        $donnees = htmlspecialchars($donnees);
        return $donnees;
    }

        $nom = secure($nom);
        $prenom = secure($prenom);
        $telephone = secure($telephone);
        $email = secure($email);
        $commentaire = secure($commentaire);
        

        // verifications du nom

        if(empty($nom)){
            $valide = false;
            $erreur_nom = "Le champ du nom ne peut pas etre vide!";
        } 
        elseif(grapheme_strlen($nom)<3){ // graphem_strLen permet de reduire les emot ou caractères spéciaux à 1

            $valide = false;
            $erreur_nom = "Le nom doit faire au moins 2 caractères";

        }
           elseif(grapheme_strlen($nom)>=30){ 
            $valide = false;
            $erreur_nom = "Le nom doit faire au plus 31 caractères";

        }
        
        // verifications du prenom
        
        if(empty($prenom)){
            $valide = false;
            $erreur_prenom = "Le champ du prenom ne peut pas etre vide!";
        }
            elseif(grapheme_strlen($prenom)<3){
            $valide = false;
            $erreur_prenom = "Le prenom doit faire au moins de 2 caractères";

        }

            elseif(grapheme_strlen($prenom)>30){
            $valide = false;
            $erreur_prenom = "Le prenom doit faire au plus 31 caractères";

        }

        // verifications du telephone

        if(empty($telephone)){
            $valide = false;
            $erreur_tel = "Le champ du telephone ne peut pas etre vide!";

        }
        
        elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $valide = false;
            $erreur_tel = "Votre adresse email est invalide";

        }

        // verifications du mail

        if(empty($email)){
            $valide = false;
            $erreur_mail = "Le champ de l'adresse mail ne peut pas etre vide!";

        }
        
        elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $valide = false;
            $erreur_mail = "Votre adresse email est invalide";

        }

        
        // verifications du commentaire

        if(empty($commentaire)){
            $valide = false;
            $erreur_commentaire = "Le champ de commentaire ne peut pas etre vide!";
        } 
        elseif(grapheme_strlen($commentaire)<30){ // graphem_strLen permet de reduire les emot ou caractères spéciaux à 1

            $valide = false;
            $erreur_commentaire = "Le commentaire doit faire au moins 30 caractères";

        }
           elseif(grapheme_strlen($commentaire)>=500){ 
            $valide = false;
            $erreur_commentaire = "Le commentaire doit faire au plus 500 caractères";

        }

        // si les verifications on reussi

        if($valide){
            $req = $DB->prepare("SELECT id_utilisateur FROM `utilisateurs` WHERE email = ?");
            $req->execute(array($email));
            $req = $req->fetch();

            // si l'utilisateur existe deja dans nos BDD

            if(isset($req['id_utilisateur'])){

                $date = date('y/m/d');
                $status = 0;
                $utilisateur = $req['id_utilisateur'];

                //on cree une demande de contact dans notre tableau demandes_contact

                $requete = $DB->prepare('INSERT INTO demandes_contact(date_contact, commentaire, status, id_utilisateur) VALUES (?, ?, ?, ?)'); 

                $requete->execute(array($date, $commentaire, $status, $utilisateur));

            }else{

                // si l'utilisateur n'existe aps dans nos BDD ajouter l'utilisateur a la BDD

                $role = 3;
                $requete = $DB->prepare('INSERT INTO utilisateurs (nom, prenom, telephone, email, id_role) VALUES (?, ?, ?, ?, ?)');
                $requete->execute(array($nom, $prenom, $telephone, $email, $role));

                // on recupere l'id_utilisateur du nouvel utilisateur

                $req = $DB->prepare("SELECT id_utilisateur FROM `utilisateurs` WHERE email = ?");
                $req->execute(array($email));
                $req = $req->fetch();
    
                if(isset($req['id_utilisateur'])){
    
                    $date = date('d/m/y');
                    $status = 0;
                    $utilisateur = $req['id_utilisateur'];
    
                   
                    // creer la demande de contact

                    $requete = $DB->prepare('INSERT INTO demandes_contact(date_contact, commentaire, status, id_utilisateur) VALUES (?, ?, ?, ?)'); 
    
                    $requete->execute(array($date, $commentaire, $status, $utilisateur));

                }
            }

// envoyer un mail a l'adminsitrateur

 $mail = $DB->prepare("SELECT * FROM utilisateurs WHERE email=?");
 $mail->execute(array($email));

 $mail = $mail->fetch();

 $mail_to = $mail['email'];

 // Création du header de l'e-mail.

 $header = "From: acefofo9@gmail.com\n";
 $header .= "MIME-version: 1.0\n";
 $header .= "Content-type: text/html; charset=utf-8\n";
 $header .= "Content-Transfer-ncoding: 8bit";
 

 //Ajout du message au format HTML 

 $contenu = "
 <p> Vous avez reçu un message de <strong>".$email."</strong></p>
 <p><strong>Nom :</strong> ".$nom."</p>
 <p><strong>Prenom :</strong> ".$prenom."</p>
 <p><strong>Téléphone :</strong> ".$telephone."</p>
 <p><strong>Message :</strong> ".$commentaire."</p>";
             
 $contacter = mail($mail_to, "Demande de contact", $contenu, $header);

 if($contacter){
    $_SESSION['succes_message'] = "message envoyé";

}else{
    $message_erreur = "message non envoyé";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="assets/style.css">
    <script src="assets/script.js" defer></script>
    <title>Document</title>
</head>
<body>
    <?php 
include_once('logo.php');
include_once('menu.php');

?>

<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d81629.65146713358!2d3.967239!3d50.255955!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c2684947068943%3A0xd4975ded0a213fb5!2s56%20Rue%20Ren%C3%A9%20Vicaine%2C%2059720%20Louvroil!5e0!3m2!1sfr!2sfr!4v1671018218496!5m2!1sfr!2sfr" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

<div class="form-container">
    
  <form method="post">

  <h3> Nous contacter</h3>



        <label for="nom">Nom:</label>
        <div class="erreur"><?php if(isset($erreur_nom)){echo $erreur_nom;}?></div>
        <input type="text" name="nom" value="<?php if(isset($nom)){echo $nom;}?>" class="box"> 

        <label for="prenom">prenom:</label>
        <div class="erreur"><?php if(isset($erreur_prenom)){echo $erreur_prenom;}?></div>
        <input type="text" name="prenom" value="<?php if(isset($prenom)){echo $prenom;}?>" class="box"> 

        <label for="tel">Téléphone:</label>
        <div class="erreur"><?php if(isset($erreur_tel )){echo $erreur_tel ;}?></div>
        <input type="text" name="telephone" value="<?php if(isset($telephone)){echo $telephone;}?>"  class="box">

        <label for="email">Mail:</label>
        <div class="erreur"><?php if(isset($erreur_mail)){echo $erreur_mail;}?></div>
        <input type="email" name="email" value="<?php if(isset($email)){echo $email;}?>"  class="box"> 

         
        <label for="messages">Message:</label>
        <div class="erreur"><?php if(isset($erreur_commentaire)){echo $erreur_commentaire;}?></div>
        <textarea name="commentaire" value="<?php if(isset($commentaire)){echo $commentaire;}?>"  class="box"> </textarea>
        <div class="bttn">
        <button type="submit" name="contacter" class="btn">Nous Contacter</button>
        </div>
</form>
</div>
    

<?php include_once('footer.php'); ?>



    
</body>
</html>