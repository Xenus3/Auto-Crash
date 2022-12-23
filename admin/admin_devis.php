<?php

include_once('../inclure.php');

function secure($donnees){
    $donnees = trim($donnees);
    $donnees = stripslashes($donnees);
    $donnees = htmlspecialchars($donnees);
    return $donnees;
}

$requete = 'SELECT * from demandes_devis natural join utilisateurs';

$resultat = $DB->query($requete);

if(isset($_GET['id']) && $_GET['action'] === "traite") {
    $requete = "UPDATE demandes_contact set status = 1 where id_demande_contact = {$_GET['id']}";
    $DB->query($requete);
}

// filtres pour les demandes de contact

if(isset($_POST['nom']) or isset($_POST['prenom']) or isset($_POST['date']) or isset($_POST['matricule'])) { 

    $nom = secure($_POST['nom']);
    $prenom = secure($_POST['prenom']);
    $date= secure($_POST['date']);
    $matricule = secure($_POST['matricule']);
    
    $conditions = array();

    if(!empty($nom)) {
       $conditions[] = 'nom like "%'.$nom.'%"';
     }
     if(!empty($prenom)) {
       $conditions[] = 'prenom like "%'.$prenom.'%"';
     }
     if(!empty($date)) {
         $conditions[] = 'date_contact like "%'.$date.'%"';
     }
     if(!empty($matricule)) {
         $conditions[] = 'matricule like "%'.$matricule.'%"';
     }
    

     
   if (count($conditions) > 0) {
       $requete  .= " WHERE " . implode(' AND ', $conditions);
   }
   $resultat = $DB->query($requete);


}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/admin_style.css">
    <script src="../assets/admin_script.js" defer></script>
    <link rel="stylesheet" href="../assets/style.css">
    <script src="../assets/script.js" defer></script>
    <title>Document</title>
</head>
<body>
<?php

include_once('../admin/admin_menu.php');
?>

<div class="recherche">
    <form action="" method="post">
        <h3>Affiner votre recherche:</h3>
        <input type="text" name="nom" placeholder="Par Nom" class="box">
        <input type="text" name="prenom" placeholder="Par Prenom" class="box">
        <input type="date" name="date" placeholder="Par Date" class="box">
        <input type="text" name="matricule" placeholder="Par Matricule" class="box">
        <input type="submit" name="filtrer" value="Affiner recherche" class="btn">
        <a href="http://localhost/php/auto-crash/admin/admin_devis.php" class="btn">Reinitialiser</a>
    </form>
</div>

    <div class="title-tab">
<h3><span> Carte grise</span></h3>
</div>

<table>
 <thead>
  <tr>
                <th>Nom</th>
                <th>Prenom</th>
                <th>Date de la demande</th>
                <th>Commentaire</th>
                <th>matricule</th>
                <th></th>
 </thead>
<tbody>

            <?php foreach($resultat as $donnee){ if($donnee['status'] === 0) {echo "<tr><td>{$donnee['nom']}</td><td>{$donnee['prenom']}</td><td>{$donnee['date_demande']}</td><td>{$donnee['commentaire']}</td><td>{$donnee['matricule']}</td><td><a href='admin_contact.php?id={$donnee["id_demande_devis"]}&action=traite'>Demande traitée</a></td>";}} ?></tbody>
</table>

        
    </div>

    <?php include_once('../footer.php'); ?>
    
</body>
</html>