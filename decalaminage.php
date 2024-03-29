<?php

require_once('inclure.php');
// si $_post n'est pas vide
if(!empty($_POST)){

    extract($_POST);

    $valide = (boolean) true;

    if(isset($_POST['decalaminage'])){

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
        $prestation = secure($prestation);
        $date_souhaitee = secure($daterdv);
        $heure_souhaitee = secure($heurerdv);


        // verifications du nom

        if(empty($nom)){
            $valide = false;
            $erreur_nom = "Le champ du nom ne peut pas etre vide!";
        } 
        elseif(grapheme_strlen($nom)<3){ // graphem_strLen permet de reduire les emot ou caractères spéciaux à 1

            $valide = false;
            $erreur_nom  = "le nom doit faire au moins 2 caractères";

        }
           elseif(grapheme_strlen($nom)>=30){ 
            $valide = false;
            $erreur_nom  = "ce nom doit faire au plus de 31 caractères (" . grapheme_strlen($nom) . "/30)";

        }
        
        // verifications du prenom
        
        if(empty($prenom)){
            $valide = false;
            $erreur_prenom= "Veuillez entrer votre prénom";
        }
            elseif(grapheme_strlen($prenom)<3){
            $valide = false;
            $erreur_prenom= "ce nom doit faire plus de 2 caractères";

        }

            elseif(grapheme_strlen($prenom)>30){
            $valide = false;
            $erreur_prenom= "ce nom doit faire moins de 31 caractères (" . grapheme_strlen($prenom) . "/30)";

        }

         // verifications du telephone

         if(empty($telephone)){
            $valide = false;
            $erreur_tel = "Le champ du telephone ne peut pas etre vide!";

        }
        
        // verifications du mail

        if(empty($email)){
            $valide = false;
            $erreur_mail = "Le champ adresse email ne peut etre vide";

        }
        
        elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $valide = false;
            $erreur_mail = "Votre Adresse email est invalide";

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

                
                

                //on cree une demande dand notre tableau demandes_devis

                $requete = $DB->prepare('INSERT INTO demandes_prestations(date_demande, date_souhaitee, heure_souhaitee, status, id_type_prestation, id_utilisateur) VALUES (?, ?, ?, ?, ?, ?)'); 

                $requete->execute(array($date, $date_souhaitee, $heure_souhaitee, $status, $prestation, $utilisateur));

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
    
                    $date = date('y/m/d');
                    $status = 0;
                    $utilisateur = $req['id_utilisateur'];
    
                    
                    // creer la demande de devis

                    $requete = $DB->prepare('INSERT INTO demandes_prestations(date_demande, date_souhaitee, heure_souhaitee, status, id_type_prestation, id_utilisateur) VALUES (?, ?, ?, ?, ?, ?)'); 

                    $requete->execute(array($date, $date_souhaitee, $heure_souhaitee, $status, $prestation, $utilisateur));

                }
            }

        // envoyer un mail a l'utilisateur et a l'administrateur

        $mail = $DB->prepare("SELECT * FROM utilisateurs WHERE email=?");
        $mail->execute(array($email));

        $mail = $mail->fetch();

        $mail_to_user = $mail['email'];
        $mail_to_admin = "acefofo@yahoo.com"; 

        // Création du header de l'e-mail.

        $header = "From: acefofo9@gmail.com\n";
        $header .= "MIME-version: 1.0\n";
        $header .= "Content-type: text/html; charset=utf-8\n";
        $header .= "Content-Transfer-ncoding: 8bit";
        

        //Ajout du message au format HTML 

        switch($prestation){
            case 4 :
                $prestation = "Decalaminage pour 30 min";
                break;
            case 5 :
                $prestation = "Decalaminage pour 60 min";
                break;
            case 6 :
                $prestation = "Decalaminage pour 90 min";
                break;
            

        }

        $contenu_user = "
        <p>Bonjour $prenom $nom</p>
      
        <p>Votre demande de rebdez-vous pour decalaminage a bien été prise en compte et nous allons la traiter dans les meilleurs delais</p>
        
        <p>Cordialement</p>";

        $contenu_admin = "
        <p> Vous avez reçu une demande de la part de:</p>
        <p><strong>Nom :</strong> $nom</p>
        <p><strong>Prenom :</strong> $prenom</p>
        <p><strong>Téléphone :</strong> $telephone</p>
        <p><strong>Email :</strong> $email</p>
        <p><strong>Prestation:</strong> $prestation</p>";
        			
        mail($mail_to_user, "Votre Demande de Rendez-vous pour Decalamainage", $contenu_user, $header);
        mail($mail_to_admin, "Nouvelle Demande de Rendez-vous pour Decalamainage", $contenu_admin, $header);

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
include_once('menu.php')


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
    <script src="assets/script.js" defer></script>
    <title>Document</title>
</head>
<body>
<?php 
include_once('logo.php');
include_once('menu.php');

?>
<div class="title"> Rendez-vous decalaminage <div class="title-nav">vous-êtes ici : <a href="index.php" class="nav-link">Acceuil</a>/ <span>Decalaminage</span></div></div>
<br />

<div class= "content-descript">
    <div class="descript">
    <div class="title-tab">
<h3><span> Décalaminage moteur </span></h3>
</div>


Le décalaminage moteur est une intervention en profondeur sur votre véhicule afin d'éliminer la calamine incrustée. Ce mélange de suie et de particules non brûlés va encrasser de nombreuses pièces essentielles au bon fonctionnement du moteur et notamment à la bonne combustion de celui-ci.
<br />

Pour plus d'informations sur le site <a href="https://www.carbon-cleaning.com/" target="_blank">CARBON CLEANING</a></div> 


<img src="image/image.png">
</div></div>
</div>


<div class="form-container-contact">
    
  <form method="post">

  <h3><span> Reservez une date pour decalaminage</span></h3>

  <div class="title"> Informations <span>*</span></div>
<div class="form-contact"> 

            <div class="form-div">
          <label for="nom">Nom:</label>
          <div></div>
        <input type="text" name="nom" class="box"> </div>
        <div class="erreur"><?php if(isset($err_nom)){echo $err_nom;}?></div>

        
        <div class="form-div">
        <label for="prenom">prenom:</label>
        <div></div>
        <input type="text" name="prenom" class="box"> 
        <div class="erreur"><?php if(isset($err_nom)){echo $err_nom;}?></div>
         </div>
        </div>


        <div class="title"> Contact <span>*</span></div>
        <div class="form-contact"> 
        <div class="form-div">

        <label for="email">Mail:</label>
        <div></div>
        <input type="email" name="email"  class="box"> </div>
        <div class="erreur"><?php if(isset($err_email)){echo $err_email;}?></div>


        
        <div class="form-div">
        <label for="telephone">Téléphone:</label>
        <div></div>
        <input type="text" name="telephone"  class="box"> </div>
        <div class="erreur"><?php if(isset($err_telephone)){echo $err_telephone;}?></div>
        </div>

        <div class="title"> Date et jour souhaité <span>*</span></div>
        <div class="form-contact"> 
        <div class="form-div">

        <label for="tel">Date Souhaité</label>
        <div></div>
        <input type="date" name="daterdv"  class="box"></div> 
        <div class="erreur"><?php if(isset($err_email)){echo $err_email;}?></div>

        <div class="form-div">
        <label for="tel">Horraire souhaité:</label>
        <div></div>
        <input type="time" name="heurerdv"  class="box"> </div>
        <div class="erreur"><?php if(isset($err_email)){echo $err_email;}?></div>
        </div>

    <div class="title"> Forfait<span>*</span></div>

    <label for="forfait">Forfait:</label>
    <select id="prestation" name="prestation" class="box"  required>
    <option value="" selected disabled>Choisissez votre forfait:</option>
    <option value="1">65€ pour 30min</option>
    <option value="2">95€ pour 1h</option>
    <option value="3">125€ pour 1h30</option>
    </select>
    </div>
    <div class="btn_contact">
    <button type="submit" name="rendez-vous" class="btn-contact">Nous Contacter</button>
    </div>
</form>
</div>

<?php include_once('footer.php'); ?>
    
</body>
</html>