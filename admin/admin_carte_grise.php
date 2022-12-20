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

// si le lien demande traité est cliqué

if(isset($_GET['id']) && $_GET['action'] === "traite") {
    $requete = "UPDATE demandes_prestations set status = 1 where id_demande_prestation = {$_GET['id']}";
    $DB->query($requete);
}

// si le lien telecharger fichiers annexe est cliqué

if(isset($_GET['id']) && $_GET['action'] === "telecharge") {

    // on recupere le lien vers le fichiers

    $requete = "SELECT * from demandes_prestations where id_demande_prestation = {$_GET['id']}";

    $chemin = $DB->query($requete);

    $chemin = $chemin->fetch();

    // on cree le fichier sous format ZIP

    $the_folder = '../'.$chemin['fichiers_annexe'];// on recupere le chemin di fichier a zip
    $zip_file_name = basename($the_folder).'.zip';
    $za = new FlxZipArchive;
    $res = $za->open($zip_file_name, ZipArchive::CREATE);
    if($res === TRUE) 
    {
    $za->addDir($the_folder, basename($the_folder));
    $za->close();
    }
    else{
    echo 'Could not create a zip archive';
    }

    // on envoit le fichier ZIP a l'administrateur

    header('Content-Type: application/zip');
    header('Content-disposition: attachment; filename='.$zip_file_name);
    header('Content-Length: ' . filesize($zip_file_name));
    readfile($zip_file_name);
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
            <option value="7">Demande carte grise pour vehicule d'occasion etranger ou vehicule neuf</option>
            <option value="8">Demande de carte grise pour vehicule d'occasion Francais</option>
            <option value="9">Changement d'adresse sur la carte grise</option>
            <option value="10">Changement de titulaire de la carte grise</option>
        </select>
        <input type="submit" name="filtrer" value="Filtrer recherche">
        <a href="http://localhost/php/auto-crash/admin/admin_carte_grise.php">Reinitialiser</a>
    </form>

    <div class="demandes_cg">
        <h1>Demandes Carte Grise</h1>
        <table>
            <tr>
                <th>Nom</th>
                <th>Prenom</th>
                <th>Date de la demande</th>
                <th>Type de prestation</th>
                <th></th>
                <th></th>
            </tr>
            <?php foreach($resultat as $donnee){ if($donnee['status'] === 0 && in_array($donnee['id_type_prestation'], [7, 8, 9, 10])) {echo "<tr><td>{$donnee['nom']}</td><td>{$donnee['prenom']}</td><td>{$donnee['date_demande']}</td><td>{$donnee['description']}</td><td><a href='admin_carte_grise.php?id={$donnee["id_demande_prestation"]}&action=traite'>demande traité</a></td><td><a href='admin_carte_grise.php?id={$donnee["id_demande_prestation"]}&action=telecharge'>telecharger fichiers annexe</a></td></tr>";}} ?>
        </table>
           
        
    </div>

    <?php include_once('../footer.php'); ?>
    
</body>
</html>