<?php

include_once('../inclure.php');

$requete = 'SELECT * from demandes_contact natural join utilisateurs';

$resultat = $DB->query($requete);

if(isset($_GET['id']) && $_GET['action'] === "traite") {
    $requete = "UPDATE demandes_contact set status = 1 where id_demande_contact = {$_GET['id']}";
    $DB->query($requete);
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

    <div class="demandes_contact">
        <h1>Demandes De Contact</h1>
        <table>
            <tr>
                
                <th>Nom</th>
                <th>Prenom</th>
                <th>Date de la demande</th>
                <th>Commentaire</th>
                <th></th>
                
            </tr>
            <?php foreach($resultat as $donnee){ if($donnee['status'] === 0) {echo "<tr><td>{$donnee['nom']}</td><td>{$donnee['prenom']}</td><td>{$donnee['date_contact']}</td><td>{$donnee['commentaire']}</td><td><a href='admin_contact.php?id={$donnee["id_demande_contact"]}&action=traite'>Demande traitée</a></td>";}} ?>
        </table>
           
        
    </div>

    <?php include_once('../footer.php'); ?>
    
</body>
</html>