<?php
include_once('../inclure.php');

if(isset($_GET['id'])) {

    $id = $_GET['id'];
    $requete = $DB->prepare('SELECT * from utilisateurs where id_utilisateur=?');
    $requete->execute(array($id));
    $requete = $requete->fetch();

    if(!empty($_POST)){

        extract($_POST);

    if(isset($_POST['modifier'])) {

        function secure($donnees){
            $donnees = trim($donnees);
            $donnees = stripslashes($donnees);
            $donnees = htmlspecialchars($donnees);
            return $donnees;
        }

        $nom = secure($nom);
        $prenom = secure($prenom);
        $telephone = secure($telephone);
        $email = secure($email);
        $role = secure($role);

        $requete = $DB->prepare('UPDATE utilisateurs set nom=?, prenom=?, telephone=?, email=?, id_role=? where id_utilisateur=?');
        $requete->execute(array($nom, $prenom, $telephone, $email, $role, $id));

        header("location:../admin/admin_utilisateurs.php");
       

    }
}

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
    <title>Document</title>
</head>

<?php 
include_once('../logo.php');
include_once('../admin/admin_menu.php');
?>

<body>

<div class="form-container">

        <form action="" method="post" class="">

            <h3>Modifier les Donneés</h3>

            <label for="email"><strong>Nom</strong></label>
            <input type="text" id="email" name="nom" value="<?= $requete['nom'] ?>" class="box" required>

            <label for="psw"><strong>Prenom</strong></label>
            <input type="text" id="psw" name="prenom" value="<?= $requete['prenom'] ?>" class="box" required>

            <label for="psw"><strong>Telephone</strong></label>
            <input type="text" id="psw" name="telephone" value="<?= $requete['telephone'] ?>" class="box" required>

            <label for="psw"><strong>Email</strong></label>
            <input type="text" id="psw" name="email" value="<?= $requete['email'] ?>" class="box" required>

            <label for="role"><strong>Role:</strong></label>
            <div class="bttn">
            <select name="role" id="role">
                <option value="" selected required>--Veuillez choisir un role</option>
                <option value="1">Super Admin</option>
                <option value="2">Administrateur</option>
                <option value="3">Utilisateur</option>
                </select>
                </div>

                <div class="bttn">
            <button type="submit" class="btn" name="modifier">Modifier</button>
            </div>
        </form>
</div>
        
<?php include_once('../footer.php'); ?>

</body>
</html>