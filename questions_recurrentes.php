<?php



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
    <script
  src="https://code.jquery.com/jquery-3.6.3.slim.js"
  integrity="sha256-DKU1CmJ8kBuEwumaLuh9Tl/6ZB6jzGOBV/5YpNE2BWc="
  crossorigin="anonymous" defer></script>
    <script src="assets/script.js" defer></script>
    <script src="https://kit.fontawesome.com/13b8658640.js" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body data-title="faq">
<?php
include_once('logo.php');
include_once('menu.php');
?>

<div class="qr">
<h1>Questions Recurrentes</h1>
<h3>Ici vous trouverez une liste des questions recurrentes si votre question ne figure pas dans la liste veuillez utilisez la forme de <b><a href="http://localhost/php/auto-crash/contact.php" target="_blank">contact</a></b>, nous allons vous repondre dans les meilleurs delais:</h3>

<p class="question_1 clickable" ><i class="fa-solid fa-chevron-right"></i>Comment transformer vos documents en fichiers PDF?</p>
<div class="reponse_1 hidden">
    <h4>transformer vos documents en fichiers PDF</h4>
    <p>pour telecharger vos fichiers commencez par prendre vos fichiers en photos avec votre mobile, le photos doit etre claire et nette, pour cela reprochez votre mobile du document et essayer de rester immobile en prenant la photos, vous pouvez aussi scannez vos documents avec un imprimante.</p>
    <p>une fois la photos ou le scan du document effectués, vous pouvez utliser cet <b><a href="https://www.adobe.com/acrobat/online/jpg-to-pdf.html#:~:text=Learn%20how%20to%20convert%20image,an%20image%20format%20to%20PDF." target="_blank">outil</a></b> pour transofrmer vos documents en PDF</p>
</div>

<p class="question_2 clickable"><i class="fa-solid fa-chevron-right"></i>Comment telecharger des documents pour la demande de carte grise?</p>
<div class="reponse_2 hidden">
    <h4>Comment telecharger vos fichiers :</h4>
    <p>pour commencer creer un dossier sur votre bureau par exemple et donenr lui le nom que vous voulez, ensuite mettez tout vos fichiers dans ce dossier, et assurez vous que tout les fichiers requis sont present dans ce dossier avant de faire votre demande</p>
    <p>
        ensuite sur la page demande de carte grise appuyez sur le boutton selectionnez fichiers et naviguer sur votre bureau et selectionnez le dossier qui contient tout vos fichiers
        <img src="image/telecharger_fichiers.PNG" alt="">
    </p>
</div>

<p class="question_3 clickable"><i class="fa-solid fa-chevron-right"></i>Quelle sont les documents requis pour faire une demande de carte grise?</p>
<div class="reponse_3 hidden">
    <h3> Documents requis :</h3>
    <h4>Carte Grise Francaise</h4>
    <ol>
        <li>Carte grise du véhicule</li>
        <li>Certificat de cession ou facture d'achat</li>
        <li>Carte d'identité ou Passeport ou Extrait k-bis de moins de 2 ans pour les professionnels</li>
        <li>Permis de conduire OBLIGATOIRE ou attestation provisoire d'obtention du permis correspondant a la catégorie du véhicule</li>
        <li>Contrôle technique de moins de 6 mois pour les véhicules de plus de 4 ans</li>
        <li>Justificatif de domicile de moins de 6 mois au nom du futur titulaire ( ou attestation d'hébergement + COPIE de la pièce d'identité de l'hébergeur)</li>
        <li>Attestation d'assurance du véhicule</li>
    </ol>
    <h4>Carte Grise Etrangere ou WW</h4>
    <ol>
        <li>Carte grise du véhicule ou déclaration de perte de carte grise</li>
        <li>Certificat de conformité (ou attestation de réception à titre isolé ou à type communautaire)</li>
        <li>Certificat de cession ou facture d'achat</li>
        <li>Carte d'identité ou Passeport ou Extrait k-bis de moins de 2 ans pour les professionnels</li>
        <li>Permis de conduire OBLIGATOIRE ou attestation provisoire d'obtention du permis correspondant a la catégorie du véhicule</li>
        <li>Contrôle technique de moins de 6 mois pour les véhicules de plus de 4 ans</li>
        <li>Justificatif de domicile de moins de 6 mois au nom du futur titulaire ( ou attestation d'hébergement + COPIE de la pièce d'identité de l'hébergeur)</li>
        <li>Quitus fiscal (si le véhicule a été acheté à l'étranger)</li>
    </ol>
    <h4>Changement Adresse du Titulaire</h4>
    <ol>
        <li>Carte grise du véhicule</li>
        <li>Carte d'identité ou Passeport ou Extrait k-bis de moins de 2 ans pour les professionnels</li>
        <li>Justificatif de domicile de moins de 6 mois au nom du futur titulaire ( ou attestation d'hébergement + COPIE de la pièce d'identité de l'hébergeur)</li>
        <li>Attestation d'assurance du véhicule</li>

    </ol>
    <h5>A Savoir!</h5>
    <ul>
        <li>i ancien format d'immatriculation, un nouveau numéro de plaques vous sera réattribué avec remise de l'ancien titre. Vous recevrez alors un certificat provisoire CPI. N'oubliez pas de changer vos plaques d'immatriculation! </li>
        <li>Si nouveau format, vous recevrez une étiquette à coller sur votre carte grise actuelle.</li>
    </ul>
    <h4>Declaration de Cession</h4>
    <ol>
        <li>L'ancienne carte grise barrée</li>
        <li>Le certificat de cession <b><a href="https://www.service-public.fr/particuliers/vosdroits/R20300" target="_blank">Cerfa n° 15776*02</a></b></li>
        <li>Certificat de non-gage</li>
        <li>Contrôle technique de moins de 6 mois</li>
        
    </ol>
    <p>Vous aurez aussi besoin de 2 fichiers CERFA : <b><a href="https://www.service-public.fr/particuliers/vosdroits/R1137" target="_blank">cerfa n°13757*03</a></b> et <b><a href="https://www.service-public.fr/particuliers/vosdroits/R13567" target="_blank">cerfa n°13750*07</a></b></p>
</div>

<p class="question_2 clickable"><i class="fa-solid fa-chevron-right"></i>Quesion 4?</p>
<div class="reponse_2 hidden">
    <h4>comment telecharger vos fichiers pour le demande de carte grise</h4>
    <p>pour commencer creer un dossier sur votre bureau par exemple et donenr lui le nom que vous voulez, ensuite mettez tout vos fichiers dans ce dossier, et assurez tout les fichiers avant de faire votre demande, vous aurez besoin de 2 fichiers CERFA : <b><a href="https://www.service-public.fr/particuliers/vosdroits/R1137" target="_blank">cerfa n°13757*03</a></b> et <b><a href="https://www.service-public.fr/particuliers/vosdroits/R13567" target="_blank">cerfa n°13750*07</a></b></p>
</div>

<p class="question_2 clickable"><i class="fa-solid fa-chevron-right"></i>Question 5?</p>
<div class="reponse_2 hidden">
    <h4>comment telecharger vos fichiers pour le demande de carte grise</h4>
    <p>pour commencer creer un dossier sur votre bureau par exemple et donenr lui le nom que vous voulez, ensuite mettez tout vos fichiers dans ce dossier, et assurez tout les fichiers avant de faire votre demande, vous aurez besoin de 2 fichiers CERFA : <b><a href="https://www.service-public.fr/particuliers/vosdroits/R1137" target="_blank">cerfa n°13757*03</a></b> et <b><a href="https://www.service-public.fr/particuliers/vosdroits/R13567" target="_blank">cerfa n°13750*07</a></b></p>
</div>
</div>

<?php include_once('footer.php'); ?>

    
</body>
</html>