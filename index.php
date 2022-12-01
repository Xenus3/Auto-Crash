<?php

include('_db/connexionDB.php');

$requete = 'select * from chantiers';
$data = $DB->query($requete);




while($donneé = $data->fetch()) 
{
?>


<li><?=$donneé["Ville"]?></li>

<?php
}  

