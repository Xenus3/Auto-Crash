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
            $message_erreur = "Le champ du nom ne peut pas etre vide!";
        } 
        elseif(grapheme_strlen($nom)<3){ // graphem_strLen permet de reduire les emot ou caractères spéciaux à 1

            $valide = false;
            $message_erreur = "le nom doit faire au moins 2 caractères";

        }
           elseif(grapheme_strlen($nom)>=30){ 
            $valide = false;
            $message_erreur = "ce nom doit faire au plus de 31 caractères (" . grapheme_strlen($nom) . "/30)";

        }
        
        // verifications du prenom
        
        if(empty($prenom)){
            $valide = false;
            $message_erreur= "Veuillez entrer votre prénom";
        }
            elseif(grapheme_strlen($prenom)<3){
            $valide = false;
            $message_erreur= "ce nom doit faire plus de 2 caractères";

        }

            elseif(grapheme_strlen($prenom)>30){
            $valide = false;
            $message_erreur= "ce nom doit faire moins de 31 caractères (" . grapheme_strlen($prenom) . "/30)";

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
            $message_erreur = "Le champ adresse email ne peut etre vide";

        }
        
        elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $valide = false;
            $message_erreur = "Votre Adresse email est invalide";

        }

       
        // si les verifications on reussi

        if($valide){
            $req = $DB->prepare("SELECT id_utilisateur FROM `utilisateurs` WHERE email = ?");
            $req->execute(array($email));
            $req = $req->fetch();

            // si l'utilisateur existe deja dans nos BDD

            if(isset($req['id_utilisateur'])){

                $date = date('d/m/y');
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

        $mail_to = $mail['email'];

        // Création du header de l'e-mail.

        $header = "From: acefofo9@gmail.com\n";
        $header .= "MIME-version: 1.0\n";
        $header .= "Content-type: text/html; charset=utf-8\n";
        $header .= "Content-Transfer-ncoding: 8bit";
        

        //Ajout du message au format HTML 

        switch($prestation){
            case 4 :
                $prestation = "Decalamainage pour 30 min";
                break;
            case 5 :
                $prestation = "Decalamainage pour 60 min";
                break;
            case 6 :
                $prestation = "Decalamainage pour 90 min";
                break;
            

        }

        $contenu = "
        <p>Bonjour $prenom $nom</p>
      
        <p>Votre demande a bien été prise en compte et nous allons la traiter dans les meilleurs delais</p>
        
        <p>Cordialement</p>";
        			
        mail($mail_to, "Demande Rendez-vous pour Decalamainage", $contenu, $header);

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
<div class="form-container">
    
    <form action="" method="post" enctype="multipart/form-data">

        <h3>Carte grise</h3>

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
        
        <label for="tel">Date Souhaiteé</label>
        <div class="erreur"><?php if(isset($err_email)){echo $err_email;}?></div>
        <input type="date" name="daterdv"  class="box"> 

        <label for="tel">Horraire souhaité:</label>
        <div class="erreur"><?php if(isset($err_email)){echo $err_email;}?></div>
        <input type="time" name="heurerdv"  class="box"> 

        <div class="bttn">
        <select id="prestation" name="prestation" class="input" required>
        <option value="" selected disabled>Choisissez votre forfait:</option>
        <option value="4">65€ pour 30min</option>
        <option value="5">95€ pour 1h</option>
        <option value="6">125€ pour 1h30</option>
        </select>
        </div>

        <div class="bttn">
        <button type="submit" name="decalaminage" class="btn">Nous Contacter</button>
        </div>


       

    </form>
</div>

<?php include_once('footer.php'); ?>
    
</body>
</html>