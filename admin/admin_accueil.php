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

<iframe src="https://calendar.zoho.eu/zc/ui/embed/#
calendar=dfc480420e014701e6ef408456b47d285772c727869a24ef156fb0d0ac66c1a6218a5455a61e55235dfb7bfc03042aec&title=Calendrier%20AutoCrash&type=1&language=en&timezone=Europe%2FParis&showTitle=1&showTimezone=1&view=day&showDetail=0&theme=1&eventColorType=light"width="350" height="500" frameBorder="0" scrolling="no"></iframe>
    
</body>
</html>