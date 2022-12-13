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
        $commentaire = secure($commentaire);
        $prestation = secure($prestation);
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

        // verifications du mail

        if(empty($email)){
            $valide = false;
            $message_erreur = "Le champ adresse email ne peut etre vide";

        }
        
        elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $valide = false;
            $message_erreur = "Votre Adresse email est invalide";

        }

        elseif($email<>$confemail){

            $valide = false;
            $message_erreur = "L'adresse email que vous avez saisis est différente de sa confirmation";
        
        
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
            $req = $DB->prepare("SELECT id_utilisateur FROM `utilisateurs` WHERE email = ?");
            $req->execute(array($email));
            $req = $req->fetch();

            // si l'utilisateur existe deja dans nos BDD

            if(isset($req['id_utilisateur'])){

                $date = date('d/m/y');
                $status = 0;
                $utilisateur = $req['id_utilisateur'];

                switch($prestation) {
                    case "reparation":
                        $prestation = 1;
                        break;
                    case "depannage":
                        $prestation = 2;
                        break;
                    case "casse":
                        $prestation = 3;
                        break;

                }

                //on cree une demande dand notre tableau demandes_devis

                $requete = $DB->prepare('INSERT INTO demandes_devis(date_demande, commentaire, status, id_type_prestation, id_utilisateur) VALUES (?, ?, ?, ?, ?)'); 

                $requete->execute(array($date, $commentaire, $status, $prestation, $utilisateur));

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
    
                    switch($prestation) {
                        case "reparation":
                            $prestation = 1;
                            break;
                        case "depannage":
                            $prestation = 2;
                            break;
                        case "casse":
                            $prestation = 3;
                            break;
    
                    }
                    // creer la demande de devis

                    $requete = $DB->prepare('INSERT INTO demandes_devis(date_demande, commentaire, status, id_type_prestation, id_utilisateur) VALUES (?, ?, ?, ?, ?)'); 
    
                    $requete->execute(array($date, $commentaire, $status, $prestation, $utilisateur));

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

        $contenu = $commentaire;
        			
        mail($mail_to, "Demande de devis", $contenu, $header);

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
    <div class="form-container" >
        <form action="" method="post" id="devis">
            <h3>Demande de Devis</h3>
            <label for="nom">Nom:</label>
            <input type="text" name="nom" class="box" value="<?php if(isset($nom)){echo $nom;} ?>">
            <label for="prenom">Prenom:</label>
            <input type="text" name="prenom" class="box" value="<?php if(isset($prenom)){echo $prenom;} ?>">
            <label for="elephone">Telephone:</label>
            <input type="text" name="telephone" class="box" value="<?php if(isset($telephone)){echo $telephone;} ?>">
            <label for="email">Email:</label>
            <input type="text" name="email" class="box" value="<?php if(isset($email)){echo $email;} ?>">
            <label for="confemail">Confirmez Email:</label>
            <input type="text" name="confemail" class="box" value="<?php if(isset($confemail)){echo $confemail;} ?>">
            <label for="commentaire">Commentaire:</label>
            <textarea type="textarea" rows="10" name="commentaire" class="text" wrap><?php if(isset($commentaire)){echo $commentaire;} ?></textarea>
            <label for="prestation">Prestation concerneé:</label>
            <select id="prestation" name="prestation" required>
            <option value="" selected disabled>--Vueillez choisir une option--</option>
            <option value="reparation">Reparation</option>
            <option value="depannage">Depanage</option>
            <option value="casse">Casse</option>
            </select>
            <input type="submit" name="devis" value="Soumettre Demande" class="btn">
        </form>
        <div class="erreur" > <?php if(isset($message_erreur)) {echo $message_erreur;}  ?></div>
    </div>
<?php include_once('footer.php'); ?>
</body>
</html>
