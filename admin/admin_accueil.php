<?php 
include_once('../inclure.php');
if(!in_array($_SESSION['role'], [1,2])){
    header('location: index.php');
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
    <link rel="stylesheet" href="../assets/style.css">
    <title>Document</title>
</head>
<body>

<?php 
include_once('../logo.php');
include_once('../admin/admin_menu.php');?>

<div> Espace Admin</div>
    
</body>
</html>