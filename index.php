<?php

require_once('inclure.php');

if(isset($_SESSION['id'])) {
    $saluer = "Bonjour " . $_SESSION['nom'];
}else{
    $saluer = "Bonjour Etranger";
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
 <?php  include ('navbar.php') ?>
    <h1><?= $saluer ?></h1>

    <script type="module" src="https://cookieconsent.popupsmart.com/js/CookieConsent.js" ></script>
    <script type="text/javascript" src="https://cookieconsent.popupsmart.com/js/App.js"></script>
    <script>
    popupsmartCookieConsentPopup({
        "siteName" : "Garage Auto Crash" ,
        "notice_banner_type": "simple-dialog",
        "consent_type": "gdpr",
        "palette": "dark",
        "language": "French",
        "privacy_policy_url" : "#" ,
        "preferencesId" : "#" ,
        
    });
    </script>

    <noscript>Cookie Consent by <a href="https://popupsmart.com/" rel="nofollow noopener">Popupsmart Website</a></noscript> 
</body>
</html>

