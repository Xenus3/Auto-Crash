<?php 
include_once('../inclure.php');
if(!in_array($_SESSION['role'], [1,2])){
    header('location: index.php');
    exit;
}

// conteur utilisateurs

$requete = $DB->query('SELECT count(id_utilisateur) as nombre_util FROM utilisateurs');
$requete = $requete->fetch();

//conteur carte grise

$requete_2 = $DB->query('SELECT count(id_demande_prestation) as nombre_demande_cg FROM demandes_prestations WHERE status = 0 AND id_type_prestation IN (4,5,6)');
$requete_2 = $requete_2->fetch();

// conteur decalaminage

$requete_3 = $DB->query('SELECT count(id_demande_prestation) as nombre_demande_deca FROM demandes_prestations WHERE status = 0 AND id_type_prestation IN (7,8,9,10)');
$requete_3 = $requete_3->fetch();

// compteur contact

$requete_4 = $DB->query('SELECT count(id_demande_contact) as nombre_contact FROM demandes_contact WHERE status = 0');
$requete_4 = $requete_4->fetch();

// conmpteur devis

$requete_5 = $DB->query('SELECT count(id_demande_devis) as nombre_devis FROM demandes_devis WHERE status = 0');
$requete_5 = $requete_5->fetch();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/style.css">
    <script src="../assets/script.js" defer></script>
    
    <title>Document</title>
</head>
<body>

<?php 

include_once('../admin/admin_menu.php');?>

<div class="admin_panneau">

    
    <div class="panneau" onclick="location.href='admin_carte_grise.php';" style="cursor: pointer;">
        <h4>Nombre de demandes de cartes Grises en attente:</h4>
        <div class="conteur"><?= $requete_2['nombre_demande_cg'] ?></div>
    </div>
    
    <div class="panneau" onclick="location.href='admin_decalaminage.php';" style="cursor: pointer;">
        <h4>Nombre de demandes de Decalaminage en attente:</h4>
        <div class="conteur"><?= $requete_3['nombre_demande_deca'] ?></div>
    </div>

    <div class="panneau" onclick="location.href='admin_utilisateurs.php';" style="cursor: pointer;">
        <h4>Utilisateurs inscrits:</h4>
        <div class="conteur"><?= $requete['nombre_util'] ?></div>
    </div>

    <div class="panneau" onclick="location.href='admin_contact.php';" style="cursor: pointer;">
        <h4>Nombre de demandes de Contact en attente:</h4>
        <div class="conteur"><?= $requete_4['nombre_contact'] ?></div>
    </div>

    <div class="panneau" onclick="location.href='admin_devis.php';" style="cursor: pointer;">
        <h4>Nombre de demandes de Devis en attente:</h4>
        <div class="conteur"><?= $requete_5['nombre_devis'] ?></div>
    </div>
    
</div>

<div class="calendrier">
  <h1>Calendrier</h1>
  <iframe src="https://calendar.google.com/calendar/embed?height=600&wkst=1&bgcolor=%23ffffff&ctz=Europe%2FParis&src=Zjg0ZGQ0ZTZmNDViNjAwMTc5ZGFhZjFkZjcxOTZkMTg3Mzc2OGM0NzE4MTBiYzdlMDYwYjE5ODYwYjY4MzliOEBncm91cC5jYWxlbmRhci5nb29nbGUuY29t&src=ZW4uZnJlbmNoI2hvbGlkYXlAZ3JvdXAudi5jYWxlbmRhci5nb29nbGUuY29t&color=%23D81B60&color=%23F6BF26" style="border:solid 1px #777" width="100%" height="600" frameborder="0" scrolling="no"></iframe>
</div>
    
</body>
</html>