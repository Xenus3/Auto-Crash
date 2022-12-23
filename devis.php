<?php

require_once('inclure.php');
// si $_post n'est pas vide
if(!empty($_POST)){

    extract($_POST);

    $valide = (boolean) true;

    if(isset($_POST['devis'])){

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
        $confemail = secure($confemail);
        $matricule = secure($matricule);
        $commentaire = secure($commentaire);
        

        // verifications du nom

        if(empty($nom)){
            $valide = false;
            $erreur_nom = "Le champ du nom ne peut pas etre vide!";
        } 
        elseif(grapheme_strlen($nom)<3){ // graphem_strLen permet de reduire les emot ou caractères spéciaux à 1

            $valide = false;
            $$erreur_nom = "le nom doit faire au moins 2 caractères";

        }
           elseif(grapheme_strlen($nom)>=30){ 
            $valide = false;
            $$erreur_nom = "ce nom doit faire au plus de 31 caractères (" . grapheme_strlen($nom) . "/30)";

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

        elseif($email<>$confemail){

            $valide = false;
            $erreur_mail = "L'adresse email que vous avez saisis est différente de sa confirmation";
        
        
        }

        // verifications du matricule

        if(empty($matricule)){
            $valide = false;
            $erreur_matricule = "Le champ du matricule ne peut pas etre vide!";
        } 
       
        

        // verifications du commentaire

        if(empty($commentaire)){
            $valide = false;
            $message_erreur = "Le champ de commentaire ne peut pas etre vide";
        } 
        elseif(grapheme_strlen($commentaire)<30){ // graphem_strLen permet de reduire les emot ou caractères spéciaux à 1

            $valide = false;
            $message_erreur = "le commentaire doit faire au moins 30 caractères";

        }
           elseif(grapheme_strlen($commentaire)>=500){ 
            $valide = false;
            $message_erreur = "le commentaire doit faire au plus 500 caractères";

        }

        // si les verifications on reussi

        if($valide){
            $req = $DB->prepare("SELECT id_utilisateur FROM utilisateurs WHERE email = ?");
            $req->execute(array($email));
            $req = $req->fetch();

            // si l'utilisateur existe deja dans nos BDD

            if(isset($req['id_utilisateur'])){

                $date = date('y/m/d');
                $status = 0;
                $utilisateur = $req['id_utilisateur'];

                

                //on cree une demande dand notre tableau demandes_devis

                $requete = $DB->prepare('INSERT INTO demandes_devis(date_demande, commentaire, matricule, status, id_utilisateur) VALUES (?, ?, ?, ?, ?)'); 

                $requete->execute(array($date, $commentaire, $matricule, $status, $utilisateur));

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

                    $requete = $DB->prepare('INSERT INTO demandes_devis(date_demande, commentaire, matricule, status, id_utilisateur) VALUES (?, ?, ?, ?, ?)'); 

                    $requete->execute(array($date, $commentaire, $matricule, $status, $utilisateur));

                }
            }

        // envoit de mails 

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

        $contenu_admin = $commentaire;
        $contenu_user = "
        <p>Bonjour $prenom $nom</p>
      
        <p>Votre demande de devis a bien été prise en compte et nous allons la traiter dans les meilleurs delais</p>
        
        <p>Cordialement</p>";
        
        // mail a l'admin

        mail($mail_to_admin, "Nouvelle Demande de Devis", $contenu_admin, $header);

        // mail de confirmation a l'utilisateur

        mail($mail_to_user, "Demande Confirmeé", $contenu_user, $header);


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
    <link rel="stylesheet" href="assets/style.css">
    <script src="assets/script.js" defer></script>
    <title>Demande de devis</title>
</head>
<body>

<?php include_once('logo.php'); include_once('menu.php'); ?>

<div class="title"> Demande de devis <div class="title-nav">vous-êtes ici : <a href="index.php" class="nav-link">Acceuil</a>/ <span>Devis</span></div></div>
<br />
    <div class="form-container-contact" >
        <form action="" method="post" id="devis">

            <h3><span>Demande de Devis</span></h3>

            <div class="title"> Informations <span>*</span></div>


            <div class="form-contact"> 
            <div class="form-div">
            <label for="nom">Nom:</label>
            <div></div>
            <input type="text" name="nom" class="box" value="<?php if(isset($nom)){echo $nom;} ?>">
            </div>

            <div class="form-div">
            <label for="prenom">Prenom:</label>
            <div></div>
            <input type="text" name="prenom" class="box" value="<?php if(isset($prenom)){echo $prenom;} ?>">
            </div>
            </div>

            <div class="form-div">
            <label for="matricule">Matricule:</label>
            <div class="erreur"><?php if(isset($erreur_matricule)){echo $erreur_matricule;}?></div>
            <input type="text" name="matricule" class="box" value="<?php if(isset($matricule)){echo $matricule;} ?>">
            </div>




            <div class="title"> Contact <span>*</span></div>
            <div class="form-contact"> 
            <div class="form-div">
            <label for="elephone">Telephone:</label>
            <div></div>
            <input type="text" name="telephone" class="box" value="<?php if(isset($telephone)){echo $telephone;} ?>"> </div>

            <div class="form-div">
            <label for="email">Email:</label>
            <div></div>
            <input type="text" name="email" class="box" value="<?php if(isset($email)){echo $email;} ?>">
            </div>
            </div>

            <div class="form-div">
            <label for="confemail">Confirmez Email:</label>
            <div></div>
            <input type="text" name="confemail" class="box" value="<?php if(isset($confemail)){echo $confemail;} ?>"></div><br /><br />


            <div class="title"> Messages et Prestation <span>*</span></div>
            <label for="commentaire">Commentaire:</label>
            <div></div>
            <textarea type="textarea" rows="10" name="commentaire" class="box" wrap><?php if(isset($commentaire)){echo $commentaire;} ?></textarea>
            <div class="bttn">
            <label for="prestation">Prestation concerneé:</label>
            <select id="prestation" name="prestation" class="box" required>
            <option value="" selected disabled>--Vueillez choisir une option--</option>
            <option value="reparation">Reparation</option>
            <option value="depannage">Depanage</option>
            <option value="casse">Casse</option>
            </select>
            </div>

            
            <div class="btn_contact">
            <input type="submit" name="devis" value="Soumettre Demande" class="btn-contact">
            </div>
        </form>
        <div class="erreur" > <?php if(isset($message_erreur)) {echo $message_erreur;}  ?></div>
    </div>
<?php include_once('footer.php'); ?>
</body>
</html>
