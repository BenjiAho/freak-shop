<?php
	class Database{
		// Propriétés de la base de données
		private $host = "localhost";
		private $db_name = "dbBoutique";
		private $username = "benji";
		private $password = "campusnum";
		public $connexion;

		// getter pour la connexion
		public function getConnection(){
			// On commence par fermer la connexion si elle existait
			$this->connexion = null;

			// On essaie de se connecter
			try{
				$this->connexion = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
				$this->connexion->exec("set names utf8"); // On force les transactions en UTF-8
			}catch(PDOException $exception){ // On gère les erreurs éventuelles
				echo "Erreur de connexion : " . $exception->getMessage();
			}

			// On retourne la connexion
			return $this->connexion;
		}   
	}
	// try
    // {
    //     $bdd = new PDO('mysql:host=localhost;dbname=dbBoutique;charset=utf8', 'benji', 'campusnum');
    // }
    // catch (Exception $e)
    // {
    //         die('Erreur : ' . $e->getMessage());
    // }

?>