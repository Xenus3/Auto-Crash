<?php

require_once('inclure.php');
// si $_post n'est pas vide
if(!empty($_POST)){

    extract($_POST);

    $valide = (boolean) true;

    if(isset($_POST['carte_grise'])){

        // fonction pour securiser les zones de saisie

       function securiser($donnees){
        $donnees = trim($donnees);
        $donnees = stripslashes($donnees);
        $donnees = htmlspecialchars($donnees);
        return $donnees;
    }

        $nom = securiser($nom);
        $prenom = securiser($prenom);
        $telephone = securiser($telephone);
        $email = securiser($email);
        $matricule = securiser($matricule);
        $prestation = securiser($prestation);

// telechargement des fichiers

       // on genere un fichier avec un nom unique pour stocker les fichiers

        
        $token = random_int(1,10000);
        $location = "assets/fichiers/". $nom . "_" . $prenom. "_" . date('dmyHis') . $token ;
        
        // on cree le dossier si celui ci n'existe pas deja

        if(!is_dir($location)){
        mkdir($location, 0755); 
        }

        // on stock le chemin dans un variable pour rensigner la base de donneés

        $chemin_fichier = $location  ;

        // on verifie que le formulaire a ete poste et que le fichier nest pas vide

        if(isset($_POST["carte_grise"]) && !empty($_FILES["fichiers"]["name"])){

            $fichiers_autorisé = array('jpg','png','jpeg','gif','pdf', 'jfif');// on declare les extentions autorisés

            
         
            foreach($_FILES['fichiers']['name'] as $i => $name){

                $type_fichier = pathinfo($name,PATHINFO_EXTENSION);// on compare l'extention des fichiers avec la liste des extentions autorisé

                  if(strlen($_FILES['fichiers']['name'][$i]) > 1 && in_array($type_fichier , $fichiers_autorisé))
                  {  
                    
                    move_uploaded_file($_FILES['fichiers']['tmp_name'][$i], $chemin_fichier ."/".$name);

                  }
              }

            
        }
                
//------- fin du telechargement des fichiers

        // verifications du nom

        if(empty($nom)){
            $valide = false;
            $message_erreur = "Le champ du nom ne peut pas etre vide!";
        } 
        elseif(grapheme_strlen($nom)<3){ // graphem_strLen permet de reduire les emot ou caractères spéciaux à 1

            $valide = false;
            $message_erreur = "Le nom doit faire au moins 2 caractères";

        }
           elseif(grapheme_strlen($nom)>=30){ 
            $valide = false;
            $message_erreur = "Le nom doit faire au plus de 31 caractères";

        }
        
        // verifications du prenom
        
        if(empty($prenom)){
            $valide = false;
            $message_erreur= "Le champ du prenom ne peut pas etre vide!";
        }
            elseif(grapheme_strlen($prenom)<3){
            $valide = false;
            $message_erreur= " Le prenom doit faire plus de 2 caractères";

        }

            elseif(grapheme_strlen($prenom)>30){
            $valide = false;
            $message_erreur= "Le prenom doit faire moins de 31 caractères";

        }

         // verifications du telephone

         if(empty($telephone)){
            $valide = false;
            $erreur_tel = "Le champ du telephone ne peut pas etre vide!";

        }
        
        elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $valide = false;
            $erreur_tel = "Votre adresse mail est invalide";

        }

        // verifications du mail

        if(empty($email)){
            $valide = false;
            $message_erreur = "Le champ adresse email ne peut etre vide!";

        }
        
        elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $valide = false;
            $message_erreur = "Votre adresse mail est invalide";

        }

        // verifications du matricule

        if(empty($matricule)){
            $valide = false;
            $erreur_matricule = "Le champ du matricule ne peut pas etre vide!";
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

                
                

                //on cree une demande dans notre tableau demandes_devis

                $requete = $DB->prepare('INSERT INTO demandes_prestations(date_demande, matricule, status, id_type_prestation, id_utilisateur, fichiers_annexe) VALUES (?, ?, ?, ?, ?, ?)'); 

                $requete->execute(array($date, $matricule, $status, $prestation, $utilisateur, $chemin_fichier ));

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

                    $requete = $DB->prepare('INSERT INTO demandes_prestations(date_demande, matricule, status, id_type_prestation, id_utilisateur, fichiers_annexe) VALUES (?, ?, ?, ?, ?, ?)'); 

                    $requete->execute(array($date, $matricule, $status, $prestation, $utilisateur, $chemin_fichier ));

                }
            }

        // envoyer un mail a l'utilisateur et a l'admin

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
            case 7 :
                $prestation = "1ere immatriculation en France d'un vehicule acquis a l'etranger";
                break;
            case 8 :
                $prestation = "Changement de titulaire de carte grise francaise";
                break;
            case 9 :
                $prestation = "Changment d'adresse";
                break;
            case 10 :
                $prestation = "Certificat de session";
                break;

        }

        $contenu_user = "
        <p>Bonjour $prenom $nom</p>
      
        <p>Votre demande de carte a bien été prise en compte et nous allons la traiter dans les meilleurs delais</p>
        
        <p>Cordialement</p>";

        $contenu_admin = "
        <p> Vous avez reçu une demande de la part de:</p>
        <p><strong>Nom :</strong> $nom</p>
        <p><strong>Prenom :</strong> $prenom</p>
        <p><strong>Téléphone :</strong> $telephone</p>
        <p><strong>Email :</strong> $email</p>
        <p><strong>Prestation:</strong> $prestation </p>";

        // envoit des mails
        			
        mail($mail_to_user, "Votre Demande de Carte Grise", $contenu_user , $header);
        mail($mail_to_admin, "Demande de Carte Grise", $contenu_admin, $header);

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

<div class="title"> Carte grise  <div class="title-nav">vous-êtes ici : <a href="index.php" class="nav-link">Acceuil</a>/ <span>Carte grise</span></div></div>
<br />

    <div class= "content-descript">
    <div class="descript">
    <div class="title-tab">
<h3><span> CARTE GRISE FRANCAISE </span></h3>
</div>


1. Carte grise du véhicule <br />
2. Certificat de cession ou facture d'achat<br />
3. Carte d'identité ou Passeport ou Extrait k-bis de moins de 2 ans pour les professionnels<br />
4. Permis de conduire OBLIGATOIRE ou attestation provisoire d'obtention du permis correspondant a la catégorie du véhicule<br />
5. Contrôle technique de moins de 6 mois pour les véhicules de plus de 4 ans<br />
6. Justificatif de domicile de moins de 6 mois au nom du futur titulaire ( ou attestation d'hébergement + COPIE de la pièce d'identité de l'hébergeur)<br />
7. Attestation d'assurance du véhicule <br /><br />

    <div class="title-tab">
<h3><span> CARTE GRISE ETRANGERE OU WW </span></h3>
</div>

1. Carte grise du véhicule ou déclaration de perte de carte grise<br />
2. Certificat de conformité (ou attestation de réception à titre isolé ou à type communautaire)<br />
3. Certificat de cession ou facture d'achat<br />
4. Carte d'identité ou Passeport ou Extrait k-bis de moins de 2 ans pour les professionnels<br />
5. Permis de conduire OBLIGATOIRE ou attestation provisoire d'obtention du permis correspondant a la catégorie du véhicule<br />
6. Contrôle technique de moins de 6 mois pour les véhicules de plus de 4 ans<br />
7. Justificatif de domicile de moins de 6 mois au nom du futur titulaire ( ou attestation d'hébergement + COPIE de la pièce d'identité de l'hébergeur)<br />
8. Quitus fiscal (si le véhicule a été acheté à l'étranger)<br /><br />
</div> 

<img src="image/photo_2.jpeg">
</div></div>


<div class="content">
<div class="content-q">
    

    <h4><span> Changement Adresse du Titulaire </span></h4>
    
        1. Carte grise du véhicule<br />
        2. Carte d'identité ou Passeport ou Extrait k-bis de moins de 2 ans pour les professionnels<br />
        3. Justificatif de domicile de moins de 6 mois au nom du futur titulaire ( ou attestation d'hébergement + COPIE de la pièce d'identité de l'hébergeur)<br />
        5. Attestation d'assurance du véhicule<br /><br />
    <h5>A Savoir!</h5>
    <ul>
        i ancien format d'immatriculation, un nouveau numéro de plaques vous sera réattribué avec remise de l'ancien titre. Vous recevrez alors un certificat provisoire CPI. N'oubliez pas de changer vos plaques d'immatriculation! <br />
        Si nouveau format, vous recevrez une étiquette à coller sur votre carte grise actuelle.
    </ul>
    <h4><span> Declaration de Cession </span></h4>

        1. L'ancienne carte grise barrée<br />
        2. Le certificat de cession <b><a href="https://www.service-public.fr/particuliers/vosdroits/R20300" target="_blank">Cerfa n° 15776*02</a></b><br />
        3. Certificat de non-gage<br />
        4. Contrôle technique de moins de 6 mois<br /><br />
        

    <p>Vous aurez aussi besoin de 2 fichiers CERFA : <b><a href="https://www.service-public.fr/particuliers/vosdroits/R1137" target="_blank">cerfa n°13757*03</a></b> et <b><a href="https://www.service-public.fr/particuliers/vosdroits/R13567" target="_blank">cerfa n°13750*07</a></b></p>
</div>
        </div>
        </div>


        <div class="form-container-contact">
    
    <form action="" method="post" enctype="multipart/form-data">

        <h3><span> Carte grise</span></h3>

    <div class="title"> Informations <span>*</span></div>



    <div class="form-contact"> 
            <div class="form-div">
        <label for="nom">Nom:</label>
        <div></div>
        <input type="text" name="nom" value="<?php if(isset($nom)){echo $nom;}?>" class="box"> </div>
        <div class="erreur"><?php if(isset($erreur_nom)){echo $erreur_nom;}?></div>

            <div class="form-div">
        <label for="prenom">prenom:</label>
        <div></div>
        <input type="text" name="prenom" value="<?php if(isset($prenom)){echo $prenom;}?>" class="box"> </div>
        <div class="erreur"><?php if(isset($erreur_prenom)){echo $erreur_prenom;}?></div>
        </div>


        <div class="title"> Contact <span>*</span></div>

        <div class="form-contact"> 
        <div class="form-div">
        <label for="tel">Téléphone:</label>
        <div></div>
        <input type="text" name="telephone" value="<?php if(isset($telephone)){echo $telephone;}?>"  class="box"></div>
        <div class="erreur"><?php if(isset($erreur_tel )){echo $erreur_tel ;}?></div>

        <div class="form-div">
        <label for="email">Mail:</label>
        <div></div>
        <input type="email" name="email" value="<?php if(isset($email)){echo $email;}?>"  class="box"></div>
        <div class="erreur"><?php if(isset($erreur_mail)){echo $erreur_mail;}?></div>
        </div>

        <div class="form-div">
        <label for="matricule">Matricule:</label>
        <div class="erreur"><?php if(isset($erreur_matricule)){echo $erreur_matricule;}?></div>
        <input type="text" name="matricule" class="box" value="<?php if(isset($matricule)){echo $matricule;} ?>">
        </div>
        
        <div class="form-div">
        <div class="title"> Prestation et dossier <span>*</span></div>
        <label for="prestations">Veuillez choisir votre prestation:</label>
        <select name="prestation" id="prestations" required class="box">
            <option value="" selected desactivated>--Veuller choisir une option--</option>
            <option value="7">1ere immatriculation en France d'un vehicule acquis a l'etranger a 40 euro</option>
            <option value="8">Changement de titulaire de carte grise francaise a 25 euro</option>
            <option value="9">Changment d'adresse a 20 euro</option>
            <option value="10">Chertificat de cession a 10 euro</option>
        </select>
        </div>
        


         <div class="form-div">
        <label for="fichiers">Veuillez telecharger votre dossier:</label>
        <input type="file" name="fichiers[]" multiple directory="" webkitdirectory="" moxdirectory="" class="box" required/>
        </div>

 
        <div class="btn_contact">
            <input type="submit" name="carte_grise" value="Soumettre Demande" class="btn-contact">
            </div>
    </form>
</div>

<?php include_once('footer.php'); ?>
    
</body>
</html>