<?php
include_once('../inclure.php');

function secure($donnees){
    $donnees = trim($donnees);
    $donnees = stripslashes($donnees);
    $donnees = htmlspecialchars($donnees);
    return $donnees;
}

$requete = ('SELECT * FROM utilisateurs natural join roles_utilisateurs');
$resultat = $DB->query($requete);

if(isset($_GET['id']) && $_GET['action'] === "supprimer") {
    $requete = "DELETE from utilisateurs where id_utilisateur = {$_GET['id']}";
    $DB->query($requete);
}

if(isset($_POST['nom']) or isset($_POST['prenom']) or isset($_POST['email']) or isset($_POST['role'])) { 

     $nom = secure($_POST['nom']);
     $prenom = secure($_POST['prenom']);
     $email= secure($_POST['email']);
     $role = secure($_POST['role']);
     
     $conditions = array();

     if(!empty($nom)) {
        $conditions[] = 'nom like "%'.$nom.'%"';
      }
      if(!empty($prenom)) {
        $conditions[] = 'prenom like "%'.$prenom.'%"';
      }
      if(!empty($email)) {
          $conditions[] = 'email like "%'.$email.'%"';
      }
      if(!empty($role)) {
        $conditions[] = 'role like "%'.$role.'%"';
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
    <link rel="stylesheet" href="../assets/style.css">
    <script src="../assets/script.js" defer></script>
    <title>Liste des Utilisateurs</title>
</head>
<body>
<?php 
include_once('../logo.php');
include_once('admin_menu.php');
?>
<h1>Liste des utilisateurs</h1>
    <form action="" method="post">
        <h3>Affiner votre recherche:</h3>
        <input type="text" name="nom" placeholder="Par Nom">
        <input type="text" name="prenom" placeholder="Par Prenom">
        <input type="text" name="email" placeholder="Par Email">
        <input type="text" name="role" placeholder="Par Role">
        <input type="submit" name="filtrer" value="Filtrer recherche">
        <a href="http://localhost/php/auto-crash/admin/admin_utilisateurs.php">Reinitialiser</a>
    </form>
    <table>
        <tr>
            <th>Nom</th>
            <th>Prenom</th>
            <th>Telephone</th>
            <th>Email</th>
            <th>Role</th>
            <th></th>
            <th></th>
        </tr>
        <?php foreach($resultat as $user){echo "<tr><td>".$user['nom']."</td><td>".$user['prenom']."</td><td>".$user['telephone']."</td><td>".$user['email']."</td><td>".$user['nom_role']."</td><td><a href='../dossiers/modifier.php?id={$user["id_utilisateur"]}' class='openButto'><strong>Modifier</strong></a></td><td><a href='admin_utilisateurs.php?id={$user["id_utilisateur"]}&action=supprimer'>Supprimer</a></td></tr>";} ?>
    </table>

    

<?php include_once('../footer.php'); ?>
</body>
</html>