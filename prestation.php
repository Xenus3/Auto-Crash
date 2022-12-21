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
    <title>Document</title>
</head>
<body>
<?php 
include_once('logo.php');
include_once('menu.php');?>

<div class="title"> Nos Prestations  <div class="title-nav">vous-êtes ici : <a href="index.php" class="nav-link">Acceuil</a>/ <span>Prestations</span></div></div>
<br />

<div class="title-tab">
<h3><span> Tarif Horaires</span></h3>
</div>

<table>
<thead>
<tr>
<th>Taux</th>
<th>HT</th>
<th>TTC</th>
</tr>
</thead>
<tbody>

<tr>
<td data-title="Taux">T1</td>
<td data-title="HT">45€</td>
<td data-title="TTC">54€</td>
</tr>

<tr>
<td data-title="Taux">T2</td>
<td data-title="HT">50€</td>
<td data-title="TTC">60€</td>
</tr>

<tr>
<td data-title="Taux">T3</td>
<td data-title="HT">55€</td>
<td data-title="TTC">66€</td>
</tr>
</tbody>
</table>

<div class="descrip-prest"> BON A SAVOIR <br /><br />
<span>T1 :</span> Opérations courantes, vidange, freinage... <br />
<span>T2 :</span> Opérations complexes électricité, distribution...<br />
<span>T3 :</span> Opérations Haute technicité outillage spécifique, diagnostique, intervention électronique, pièces fournies par le client...<br /><br />

<p>Durée déterminée approximativement selon le barème de temps constructeur, sous réserve de démontage et du temps réellement passé sur le véhicule.</p>
</div>

<div class="title-tab">
<h3><span> Vidange</span></h3>
</div>

<table>
<thead>
<tr>
<th>Prestations</th>
<th>Prix unitaire TTC</th>
</tr>
</thead>
<tbody>

<tr>
<td data-title="Prestations">Vidange 5W30 (5L max)</td>
<td data-title="Prix unitaire TTC">89€</td>
</tr>

<tr>
<td data-title="Prestations">Vidange 5W40 (5L max)</td>
<td data-title="Prix unitaire TTC">69€</td>
</tr>

<tr>
<td data-title="Prestations">Vidange 10W40 (5L max)</td>
<td data-title="Prix unitaire TTC">59€</td>
</tr>

<tr>
<td data-title="Prestations">Vidange 0W30 ou 0w20(5L max)</td>
<td data-title="Prix unitaire TTC">99€</td>
</tr>

<tr>
<td data-title="Prestations">Vidange boite de vitesse manuelle</td>
<td data-title="Prix unitaire TTC">58€</td>
</tr>

</tbody>
</table>


<div class="title-tab">
<h3><span> Pneumatiques</span></h3>
</div>

<table>
<thead>
<tr>
<th>Prestations</th>
<th>Prix unitaire TTC</th>
</tr>
</thead>
<tbody>

<tr>
<td data-title="Prestations">Montage pneus unitaire</td>
<td data-title="Prix unitaire TTC">10€</td>
</tr>

<tr>
<td data-title="Prestations">Equilibrage roue unitaire</td>
<td data-title="Prix unitaire TTC">6€</td>
</tr>

<tr>
<td data-title="Prestations">Forfait montage + Equilibrage</td>
<td data-title="Prix unitaire TTC">15€</td>
</tr>

<tr>
<td data-title="Prestations">Reparation pneu unitaire (mèche)</td>
<td data-title="Prix unitaire TTC">10€</td>
</tr>

<tr>
<td data-title="Prestations">Reglage parallelisme avant</td>
<td data-title="Prix unitaire TTC">69€</td>
</tr>

</tbody>
</table>

<div class="title-tab">
<h3><span> Freinage</span></h3>
</div>

<table>
<thead>
<tr>
<th>Prestations</th>
<th>Prix unitaire TTC</th>
</tr>
</thead>
<tbody>

<tr>
<td data-title="Prestations">Pose plaquettes avant</td>
<td data-title="Prix unitaire TTC">30€</td>
</tr>

<tr>
<td data-title="Prestations">Pose plaquettes arrière</td>
<td data-title="Prix unitaire TTC">40€</td>
</tr>

<tr>
<td data-title="Prestations">Pose disques et plaquettes avant</td>
<td data-title="Prix unitaire TTC">50€</td>
</tr>

<tr>
<td data-title="Prestations">Pose disques et plaquettes arrière</td>
<td data-title="Prix unitaire TTC">60€</td>
</tr>

<tr>
<td data-title="Prestations">Pose kit de frein arrière</td>
<td data-title="Prix unitaire TTC">60€</td>
</tr>

</tbody>
</table>


<div class="title-tab">
<h3><span> Electronique</span></h3>
</div>

<table>
<thead>
<tr>
<th>Prestations</th>
<th>Prix unitaire TTC</th>
</tr>
</thead>
<tbody>

<tr>
<td data-title="Prestations">Diagnostic electronique valise</td>
<td data-title="Prix unitaire TTC">30€</td>
</tr>

<tr>
<td data-title="Prestations">Remise à zero indicateur maintenance</td>
<td data-title="Prix unitaire TTC">10€</td>
</tr>

<tr>
<td data-title="Prestations">Reglage phares</td>
<td data-title="Prix unitaire TTC">15€</td>
</tr>

</tbody>
</table>

<div class="title-tab">
<h3><span> Antipollution</span></h3>
</div>

<table>
<thead>
<tr>
<th>Prestations</th>
<th>Prix unitaire TTC</th>
</tr>
</thead>
<tbody>

<tr>
<td data-title="Prestations">Antipollution</td>
<td data-title="Prix unitaire TTC">20€</td>
</tr>

<tr>
<td data-title="Prestations">Netoyage filtre à particules warm up</td>
<td data-title="Prix unitaire TTC">250€</td>
</tr>

<tr>
<td data-title="Prestations">30 min de decalaminage</td>
<td data-title="Prix unitaire TTC">65€</td>
</tr>

<tr>
<td data-title="Prestations">60 min de decalaminage (1h)</td>
<td data-title="Prix unitaire TTC">95€</td>
</tr>

<tr>
<td data-title="Prestations">90 min de decalaminage (1h30)</td>
<td data-title="Prix unitaire TTC">125€</td>
</tr>

<tr>
<td data-title="Prestations">Complement de charge climatisation</td>
<td data-title="Prix unitaire TTC">a partir de 69€* devis sur demande</td>
</tr>

</tbody>
</table>

<div class="descrip-prest-d"> Pour tout autre tarif, devis sur demande            

<div class="btn_contact">
            <button type="submit" name="devis" class="btn-contact"><a href="devis.php"> Demande de devis </a></button>
            </div>

            </div>  

<?php include_once('footer.php'); ?>
<!-- JavaScript Bundle with Popper -->

<script src="assets/script.js"></script>
</body>
</html>