<?php 
include_once('inclure.php');

if(isset($_POST['rendez-vous'])){

            function secure($donnees){
        $donnees = trim($donnees);
        $donnees = stripslashes($donnees);
        $donnees = htmlspecialchars($donnees);
        return $donnees;
    }

    $nom =  secure($_POST['nom']);
    $prenom =  secure($_POST['prenom']);
    $email = secure($_POST['email']);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    $tel = secure($_POST['tel']);
    $daterdv = secure($_POST['daterdv']);
    $heurerdv = secure($_POST['heurerdv']);
    $forfait = secure($_POST['forfait']);

    $select_rdv= $DB->prepare("SELECT * FROM demandes_prestations WHERE nom = ?");
    $select_rdv->execute(array($nom));

     
    if($select_rdv->rowCount() > 0){
        $message[] = 'le RDV à été pris';
    }




    else{

           $message[] = 'le RDV à été pris';
           $rdv= $DB->prepare ("INSERT INTO demandes_prestations 
           (date_demande, heure_debut, forfait, nom, prenom, email, tel) 
           VALUES(?, ?, ?, ?, ?, ?, ?)");
           $rdv->execute(array($daterdv, $heurerdv, $forfait, $nom, $prenom, $email, $tel));
           $rdv = $rdv->fetch();
           

    
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

<div class="form-container">
    
  <form method="post">

  <h3> Reservez une date pour decalaminage</h3>

          <label for="nom">Nom:</label>
        <div class="erreur"><?php if(isset($err_nom)){echo $err_nom;}?></div>
        <input type="text" name="nom" class="box"> 

        <label for="prenom">prenom:</label>
        <div class="erreur"><?php if(isset($err_nom)){echo $err_nom;}?></div>
        <input type="text" name="prenom" class="box"> 

        <label for="email">Mail:</label>
        <div class="erreur"><?php if(isset($err_email)){echo $err_email;}?></div>
        <input type="email" name="email"  class="box"> 

        <label for="tel">Téléphone:</label>
        <div class="erreur"><?php if(isset($err_email)){echo $err_email;}?></div>
        <input type="text" name="tel"  class="box"> 

        <label for="tel">Date Souhaiteé</label>
        <div class="erreur"><?php if(isset($err_email)){echo $err_email;}?></div>
        <input type="date" name="daterdv"  class="box"> 

        <label for="tel">Horraire souhaité:</label>
        <div class="erreur"><?php if(isset($err_email)){echo $err_email;}?></div>
        <input type="time" name="heurerdv"  class="box"> 

    <div class="bttn">
    <select name="forfait" class="input" required>
    <option value="" selected disabled>Choisissez votre forfait:</option>
    <option value="1">65€ pour 30min</option>
    <option value="2">95€ pour 1h</option>
    <option value="3">125€ pour 1h30</option>
    </select>
    </div>
    <div class="bttn">
    <button type="submit" name="rendez-vous" class="btn">Nous Contacter</button>
    </div>
</form>
</div>

<?php include_once('footer.php'); ?>
    
</body>
</html>