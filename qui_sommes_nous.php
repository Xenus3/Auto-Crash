<?php 
include_once('inclure.php');



if(isset($_SESSION['id'])){
    $var = "Bonjour " . $_SESSION['nom'] . " " .  $_SESSION['prenom'];
} else
{
    $var = "Bonjour à tous";
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
<body >
<?php 
include_once('logo.php');
include_once('menu.php');?>

<div class="title"> Qui sommes nous ?  <div class="title-nav">vous-êtes ici : <a href="index.php" class="nav-link">Acceuil</a>/ <span>Qui sommes nous ?</span></div></div>
<br />


<div class= "content-descript">
    <div class="descript">
    <div class="title-tab">
<h3><span> Qui sommes nous ? </span></h3>
</div>

Le Garage Autocrash est une entreprise familiale en activité depuis 1996 . Forte d'une expérience de plus de 30 ans elle intervient dans le secteur de l'entretien et la réparation de véhicules avec des employés qualifiés et passionnés
Propose également la vente de véhicules d'occasion, révises et garanties </div> <img src="image/img1.jpg"></div>


<div class="title-tab">
<h3><span> L'équipe</span></h3>
</div>



<div class="content-equip">
<div class="content-equipe">
<img src="image/avatar.png"><br />
<span> Patrick </span><br />
Gérant mécanicien </div>

<div class="content-equipe">
<img src="image/avatar.png"><br />
<span> Mélissa </span> <br />
Assistante de direction </div>

<div class="content-equipe">
<img src="image/avatar.png"><br />
<span> Brenda </span><br />
Chargé d'accueil </div>

<div class="content-equipe">
<img src="image/avatar.png"><br />
<span> Kevin </span><br />
Mécanicien 
</div>
</div>



<?php include_once('footer.php'); ?>

</body>
</html>