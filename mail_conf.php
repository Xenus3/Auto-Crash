<?php

include_once('_db/connexionDB.php');

$id = (int) $_GET['id'];
$token = (String) htmlentities($_GET['token']); 
$valid = true;

if(!isset($id)){
	$valid = false;
	$err_mess = "Le lien est erroné";
 
}elseif(!isset($token)){
	$valid = false;
	$err_mess = "Le lien est erroné";
}
 
if($valid){
	$req = $DB->prepare("SELECT id_utilisateur
		FROM utilisateurs
		WHERE id_utilisateur = ? AND mail_token = ?");

    $req->execute(array($id, $token));
		
	$req = $req->fetch();
 
	if(!isset($req['id_utilisateur'])){
		$valid = false;
		$err_mess = "Le lien est erroné";
	}else{
		$requete = $DB->prepare("UPDATE utilisateurs SET mail_token = NULL, mail_confirmation = ? WHERE id_utilisateur = ?");

		$requete->execute(array(date('Y-m-d H:i:s'), $req['id_utilisateur']));
 
	 $info_mess = "Votre compte a bien été validé";
	}
}