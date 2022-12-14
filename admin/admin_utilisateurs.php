<?php
include_once('../inclure.php');

$requete = $DB->query('SELECT * FROM utilisateurs natural join roles_utilisateurs');






?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
    <script src="../assets/script.js" defer></script>
    <title>Document</title>
</head>
<body>
<?php 
include_once('../logo.php');
include_once('../menu.php');
?>
<h1>Liste des utilisateurs</h1>
    <table>
        <tr>
            <th>Nom</th>
            <th>Prenom</th>
            <th>Telephone</th>
            <th>Email</th>
            <th>Role</th>
        </tr>
        <?php foreach($requete as $user){echo "<tr><td>".$user['nom']."</td><td>".$user['prenom']."</td><td>".$user['telephone']."</td><td>".$user['email']."</td><td>".$user['id_role']."</td></tr> <button></button>";} ?>
    </table>

<?php include_once('../footer.php'); ?>
</body>
</html>