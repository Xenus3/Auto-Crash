<?php

class connexionDB {
    private $hote = 'localhost';
    private $nom = 'auto-crash';
    private $utilisateur = 'root';
    private $mdp = 'root';
    private $connexion;

    function __construct ($hote = null, $nom = null, $utilisateur = null, $mdp = null) {
        if($hote != null) {
            $this->hote = $hote;
            $this->nom = $nom;
            $this->utilisateur = $utilisateur;
            $this->mdp = $mdp;

        }
        try {
            $this->connexion = new PDO('mysql:host=' . $this->hote . ';dbname=' . $this->nom, $this->utilisateur, $this->mdp, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8MB4', PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        }catch(PDOExeption $e) {
            echo 'Erreur: Connexion a la base de donneés impossible';
            die();
        }
    }

    public function DB() {
        return $this->connexion;
    }

}

$DBB = new connexionDB();
$DB = $DBB->DB();