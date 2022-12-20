<?php

include_once('../inclure.php');

function secure($donnees){
    $donnees = trim($donnees);
    $donnees = stripslashes($donnees);
    $donnees = htmlspecialchars($donnees);
    return $donnees;
}

$requete = 'SELECT * from demandes_prestations natural join utilisateurs natural join types_prestations';

$resultat = $DB->query($requete);

if(isset($_GET['id']) && $_GET['action'] === "traite") {
    $requete = "UPDATE demandes_prestations set status = 1 where id_demande_prestation = {$_GET['id']}";
    $DB->query($requete);
}

if(isset($_POST['nom']) or isset($_POST['prenom']) or isset($_POST['date']) or isset($_POST['prestation'])) { 

    $nom = secure($_POST['nom']);
    $prenom = secure($_POST['prenom']);
    $date= secure($_POST['date']);
    $prestation= secure($_POST['prestation']);
    
    $conditions = array();

    if(!empty($nom)) {
       $conditions[] = 'nom like "%'.$nom.'%"';
     }
     if(!empty($prenom)) {
       $conditions[] = 'prenom like "%'.$prenom.'%"';
     }
     if(!empty($date)) {
         $conditions[] = 'date_demande like "%'.$date.'%"';
     }
     if(!empty($prestation)) {
       $conditions[] = 'id_type_prestation like "%'.$prestation.'%"';
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
include_once('../logo.php');
include_once('../admin/admin_menu.php');
?>

    <form action="" method="post">
        <h3>Filtrez votre recherche par</h3>
        <input type="text" name="nom" placeholder="Par Nom">
        <input type="text" name="prenom" placeholder="Par Prenom">
        <label for="date">Date de la demande:</label>
        <input type="date" name="date" placeholder="Par Date">
        <label for="prestation">Prestation demandeé:</label>
        <select name="prestation" id="prestations">
            <option value="" selected desactivated>--Veuller choisir une option--</option>
            <option value="4">Decalaminage pendant 30 min</option>
            <option value="5">DDecalaminage pendant 60 min</option>
            <option value="6">Decalaminage pendant 90 min</option>
            
        </select>
        <input type="submit" name="filtrer" value="Filtrer recherche">
        <a href="http://localhost/php/auto-crash/admin/admin_decalaminage.php">Reinitialiser</a>
    </form>

    <div class="demandes_cg">
        <h1>Rendez-vous pour Decalaminage</h1>
        <table>
            <tr>
                <th>Nom</th>
                <th>Prenom</th>
                <th>Date de la demande</th>
                <th>Date souhaitée</th>
                <th>Heure souhaitée</th>
                <th>Type de prestation</th>
                <th></th>
                <th></th>
            </tr>
            <?php foreach($resultat as $donnee){ if($donnee['status'] === 0 && in_array($donnee['id_type_prestation'], [4, 5, 6])) {echo "<tr><td>{$donnee['nom']}</td><td>{$donnee['prenom']}</td><td>{$donnee['date_demande']}</td><td>{$donnee['date_souhaitee']}</td><td>{$donnee['heure_souhaitee']}</td><td>{$donnee['description']}</td><td><a href='decalaminage.php?id={$donnee["id_demande_prestation"]}&action=traite'>demande traité</a></td><td><a href='decalaminage.php?id={$donnee["id_demande_prestation"]}&action=paiement'>Paiement effectué</a></td></tr>";}} ?>
        </table>
           
        
    </div>

    <?php include_once('../footer.php'); ?>
    
</body>
</html>