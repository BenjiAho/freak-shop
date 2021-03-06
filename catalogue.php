<?php

// POUR QUE LA BASE DE DONNEE PRENNE BIEN LES PARAMETRES APRES SUBMIT DU FORMULAIRE D'AJOUTE
// DECLARER LA VARIBLE $BDD  POUR SE CONNECTER A MYSQL GRACE A NEW PDO
try
    {
        $bdd = new PDO('mysql:host=localhost;dbname=dbBoutique;charset=utf8', 'benji', 'campusnum');
    }
    catch (Exception $e)
    {
            die('Erreur : ' . $e->getMessage());
    }
  



if (!empty($_GET["action"])) {
	//commencer la méthode switch case , break.
	switch ($_GET["action"]) {
		// AJOTUER UN ARTICLE
		case 'add':
			
			// SI CE N'EST PAS VIDE ,ALORS POST QUANTITY
			if (!empty($_POST["quantity"])) {
				//déclarer variable $productByCode qui est égal aux "codes" dans la table "articles" qui se trouve dans la base de donnée $db_handle
				//runquery poour retourner les valeurs d'une colonne
				$productByCode = $bdd->query("SELECT * FROM articles WHERE code='" . $_GET["code"] . "'");
				$donnees = $productByCode->fetch();
				//déclarer variable $donneeArray, est égal au tableau avec comme paramètres les valeurs name,code,quantity,prix,photo,tout commençant par l'index [0] du tableau
				$donneeArray = array($donnees["code"] => array('name' => $donnees["name"], 'code' => $donnees["code"], 'quantity' => $_POST["quantity"], 'prix' => $donnees["prix"], 'photo' => $donnees["photo"]));

				//si les paramètres ne sont pas vides, alors cart_item(le panier)  
				if (!empty($_SESSION["cart_item"])) {
					//si in_array(dans le tableau) le code commence à [0] et array_keys(les clés primaires) du panier
					if (in_array($donnees["code"], array_keys($_SESSION["cart_item"]))) {
						//pour chaque clé ayant une valeur dans le tableau du panier
						foreach ($_SESSION["cart_item"] as $k => $v) {
							//si le code est strictement égal à la clé
							if ($donnees["code"] == $k) {
								//si le tableau(panier), la clé et la quantity sont vides
								if (empty($_SESSION["cart_item"][$k]["quantity"])) {
									//alors panier clé et quantity égal zéro
									$_SESSION["cart_item"][$k]["quantity"] = 0;
								}
								//ou si ce n'est pas vide , panier ,clé, quantity s'additionnent aux POST["quantity"]
								$_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
							}
						}
					} else {
						//sinon déclarer que le panier, devient tableau du panier PLUS (+) les Valeurs name,code,prix,quantity etc... se trouvant dans donneeArray
						$_SESSION["cart_item"] = array_merge($_SESSION["cart_item"], $donneeArray);
					}
				} else {
					//ou bien panier est égal aux valeurs
					$_SESSION["cart_item"] = $donneeArray;
				}
				//refresh la page
				header('location:index.php?page=catalogue');
			}
			break;
			//PARTIE INUTILE pour supprimer ou vider la panier, vu qu'on se trouve dans le catalogue et le panier ne s'affiche pas ici
			// SUPPRIMER UN ARTICLE DU PANIER
			// case "remove":
			// 	if(!empty($_SESSION["cart_item"])) {
			// 		foreach($_SESSION["cart_item"] as $k => $v) {
			// 				if($_GET["code"] == $k)
			// 					unset($_SESSION["cart_item"][$k]);				
			// 				if(empty($_SESSION["cart_item"]))
			// 					unset($_SESSION["cart_item"]);
			// 		}
			// 	}
			// break;
			// // VIDER LE PANIER
			// case "empty":
			// 	unset($_SESSION["cart_item"]);
			// break;	
	}
}

$BDD = new PDO('mysql:host=localhost:3306; dbname=dbBoutique', "benji", "campusnum");
//si $_POST les valeurs
if (isset($_POST['name']) && isset($_POST['photo']) && isset($_POST['prix']) && isset($_POST['code']) && isset($_POST['description'])) {
	
	//essaye
	try {
		//la variable article est égal aux 5valeurs name photo prix code description
		//PDO::prepare — Prépare une requête à l'exécution et retourne un objet, "prepare" va avec  "execute"
		$article = $BDD->prepare('INSERT INTO articles(name, photo, prix, code,description) VALUES(?, ?, ?, ?, ?)');
		//PDOStatement::execute — Exécute une requête préparée
		$article->execute(array(($_POST['name']), ($_POST['photo']), $_POST['prix'], ($_POST['code']), $_POST['description']));
	} catch (PDOException $e) {
		//affiche cela si l'on a pas pu traiter les données
		echo 'Impossible de traiter les données!' . $e->getMessage();
	}
}
// FIN FONCTIONNALITE FORMULAIRE D'AJOUT DANS DB

// UTILISER LE FICHIER DBController.PHP QUI NOUS CONNECTE A LA BASE DE DONNEES
// require_once("dbcontroller.php");
// $db_handle = new DBController();

    $reponse = $bdd->query('SELECT * FROM articles WHERE code');
    while($donnees = $reponse->fetch()) {

	}
//RECUPERER L'ACTION DU FORMULAIRE

?>
<HTML>

<HEAD>
	<TITLE>CATALOGUE</TITLE>
	<link href="style.css" type="text/css" rel="stylesheet" />
</HEAD>

<BODY>

	<div class="txt-heading">CATALOGUE</div>
	<div class="catalogue_main" ID="product-grid">

		<?php
		
		// on appelle la fonction runQuery qu'on  a créer dans le fichier functions.php 
		afficheCatalogue();
		
		?>
	</div>
</BODY>

</HTML>