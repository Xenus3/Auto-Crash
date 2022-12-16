<?php
include_once('../inclure.php');


if(!in_array($_SESSION['role'], [1,2])){
    header('location: /');
    exit;
}

if(isset($_POST['update_payment'])){
$order_id = $_POST['order_id'];
$payment_status = $_POST['payment_status'];
$update_status = $DB->prepare("UPDATE demandes_devis SET status = ? WHERE id_demande_devis = ?");
$update_status->execute([$payment_status, $order_id]);
}

if(isset($_GET['delete'])){
$delete_id = $_GET['delete'];
$delete_order = $DB->prepare("DELETE FROM demandes_devis WHERE id_demande_devis = ?");
$delete_order->execute([$delete_id]);
header('location:admin_devis.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Commandes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/admin_style.css">
</head>
<body>
    <?php 
include_once('../logo.php');
include_once('../admin/admin_menu.php');?>

<section class="placed-orders">
<h1 class="title"> Les commanndes</h1>
<div class="box-container">

    
<?php 
$select_orders = $DB->prepare("SELECT * FROM demandes_devis natural join utilisateurs natural join types_prestations");
$select_orders->execute();

if($select_orders->rowCount() > 0) {
while($fetch_orders =$select_orders->fetch()) {
?>

<div class="box">


<p>Nom : <span><?= $fetch_orders['nom']; ?></span></p>
<p>Prenom : <span><?= $fetch_orders['prenom']; ?></span></p>
<p>Mail : <span><?= $fetch_orders['email']; ?></span></p>
<p>Numero de téléphone : <span><?= $fetch_orders['telephone']; ?></span></p>
<p>Nom de la prestation: <span><?= $fetch_orders['nom_prestation']; ?></span></p>
<p>Description : <span><?= $fetch_orders['description']; ?></span></p>
<p>Date de Demande: <span><?= $fetch_orders['date_demande']; ?></span></p>
<p>Date d'expiration : <span><?= $fetch_orders['date_expiration']; ?></span></p>



 <form action="" method="POST">
<input type="hidden" name="order_id" value="<?= $fetch_orders['id_demande_devis']; ?>">
<select name="payment_status" class="drop-down">
<option value="Selectionnez" selected disabled><?= $fetch_orders['status']; ?> 
<option value="en attente">en attente</option>
<option value="completer">completer</option>
</option>
</select>

<div class="flex-btn">
    <input type="submit" value="modifier" class="btn" name="update_payment">
    <a href="admin_devis.php?delete=<?php echo $fetch_orders['id_demande_devis']?>" class="delete-btn" onclick="return confirm('Voulez-vous supprimer la commande ?');">Supprimer</a>
</div>

</form>
</div>

<?php 
}
}

else {
    echo '<p class="empty"> Pas de commande</p>';
}
?>


</div>
</section>

<script src="../assets/admin_script.js"></script>
</body>
</html>