<?php

require_once('inclure.php');







?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
    <script src="assets/script.js" defer></script>
    <title>Demande de devis</title>
</head>
<body>

<?php include_once('logo.php'); include_once('menu.php'); ?>
    <div class="form-container" >
        <form action="" method="post" id="devis">
            <h3>Demande de Devis</h3>
            <label for="nom">Nom:</label>
            <input type="text" name="nom" class="box">
            <label for="prenom">Prenom:</label>
            <input type="text" name="prenom" class="box">
            <label for="elephone">Telephone:</label>
            <input type="text" name="telephone" class="box">
            <label for="email">Email:</label>
            <input type="text" name="email" class="box">
            <label for="commentaire">Commentaire:</label>
            <textarea type="textarea" rows="10" name="commentaire" class="text" wrap></textarea>
            <label for="prestation">Prestation concerneé:</label>
            <select id="prestation">
            <option value="">--Vueillez choisir une option--</option>
            <option value="reparation">Reparation</option>
            <option value="depanage">Depanage</option>
            <option value="casse">Casse</option>
            </select>
            <input type="submit" name="devis" value="Soumettre Demande" class="btn">
        </form>
    </div>
<?php include_once('footer.php'); ?>

</body>
</html>