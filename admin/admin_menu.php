<?php 

include_once('../inclure.php');

if(!isset($_SESSION['id']) or !in_array($_SESSION['role'], [1,2])){
    header('location:index.php');
    exit;
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
    <title>Acceuil</title>
</head>
<body>

<header class="header"> 
<div class="flex">

    <nav class="navbar">
        <a href="admin_accueil.php" class="nav-link">Panneau d'Administration</a>
        <a href="../index.php" class="nav-link">Retour au site</a>

</nav>
    <div class="icons">
    <div id="menu-btn" class="fas fa-bars"></div>
    </div>





</div>

</div>
</header>


</body>
</html>