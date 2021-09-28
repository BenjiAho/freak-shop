<?php

// POUR QUE LA BASE DE DONNEE PRENNE BIEN LES PARAMETRES APRES SUBMIT DU FORMULAIRE D'AJOUTE
// DECLARER LA VARIBLE $BDD  POUR SE CONNECTER A MYSQL GRACE A NEW PDO
$BDD = new PDO('mysql:host=localhost:3306; dbname=dbBoutique', "benji", "campusnum");

//si $_POST les valeurs
if (isset($_POST['name']) && isset($_POST['photo']) && isset($_POST['prix']) && isset($_POST['code']) && isset($_POST['description'])) {

	//essaye d'attraper
	try {
		//la variable article est égal aux 5valeurs name photo prix code description
		//PDO::prepare — Prépare une requête à l'exécution et retourne un objet, "prepare" va avec  "execute"
		$article = $BDD->prepare('INSERT INTO articles(name, photo, prix, code,description) VALUES(?, ?, ?, ?, ?)');
		//PDOStatement::execute — Exécute une requête préparée
		$article->execute(array(($_POST['name']), ($_POST['photo']), $_POST['prix'], ($_POST['code']), $_POST['description']));
	} catch (PDOException $e) {
		//affiche cela si l'on pas pu traiter les données
		echo 'Impossible de traiter les données!' . $e->getMessage();
	}
}
// FIN FONCTIONNALITE FORMULAIRE D'AJOUT DANS DB

// UTILISER LE FICHIER DBController.PHP QUI NOUS CONNECTE A LA BASE DE DONNEES
require_once("dbcontroller.php");
$db_handle = new DBController();
//RECUPERER L'ACTION DU FORMULAIRE
if (!empty($_GET["action"])) {
	//commencer la méthode switch case , break.
	switch ($_GET["action"]) {
		// AJOTUER UN ARTICLE
		case "add":
			// SI CE N'EST PAS VIDE ,ALORS POST QUANTITY
			if (!empty($_POST["quantity"])) {
				//déclarer variable $productByCode qui est égal aux "codes" dans la table "articles" qui se trouve dans la base de donnée $db_handle
				//runquery poour retourner les valeurs d'une colonne
				$productByCode = $db_handle->runQuery("SELECT * FROM articles WHERE code='" . $_GET["code"] . "'");
				//déclarer variable $donneeArray, est égal au tableau avec comme paramètres les valeurs name,code,quantity,prix,photo,tout commençant par l'index [0] du tableau
				$donneeArray = array($productByCode[0]["code"] => array('name' => $productByCode[0]["name"], 'code' => $productByCode[0]["code"], 'quantity' => $_POST["quantity"], 'prix' => $productByCode[0]["prix"], 'photo' => $productByCode[0]["photo"]));

				//si les paramètres ne sont pas vides, alors cart_item(le panier)  
				if (!empty($_SESSION["cart_item"])) {
					//si in_array(dans le tableau) le code commence à [0] et array_keys(les clés primaires) du panier
					if (in_array($productByCode[0]["code"], array_keys($_SESSION["cart_item"]))) {
						//pour chaque clé ayant une valeur dans le tableau du panier
						foreach ($_SESSION["cart_item"] as $k => $v) {
							//si le code est strictement égal à la clé
							if ($productByCode[0]["code"] == $k) {
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
?>
<HTML>

<HEAD>
	<TITLE>CATALOGUE</TITLE>
	<link href="style.css" type="text/css" rel="stylesheet" />
</HEAD>

<BODY>

	<div class="txt-heading">ARTICLE</div>
	<div class="catalogue_main" ID="product-grid">

		<?php
		//connect to database
		require_once("dbcontroller.php");

		//déclare variable $product_array est égal tout de la table articles dans bdd dans un ordre ascendant
		//ASC = pour préciser ordre ascendant.
		$product_array = $db_handle->runQuery("SELECT * FROM articles ORDER BY ID ASC");
		//si ce notre product_array n'est pas vide
		if (!empty($product_array)) {
			//alors pour chaque clé et valeurs dans le tableau ($product_array)
			//passe en revue le tableau $product_array. À chaque itération, la valeur de l'élément courant est assignée à $value et assignera en plus la clé de l'élément courant à la variable $key (avec $key => $value). source : https://www.php.net/manual/fr/control-structures.foreach.php
			foreach ($product_array as $key => $value) {
                if ($_GET['code'] == $product_array[$key]["code"]){
		?>

				<div class="product-item contain_catalogue ">
					<!-- CONTENU DU CATALOGUE -->
					<form class="" method="post" action="index.php?page=catalogue&action=add&code=<?php echo $product_array[$key]["code"]; ?>">
						<div class="texte_description">
							<div class="product-image img">
							<a href =""> <img class="img" src="<?php echo $product_array[$key]["photo"]; ?>"> </a>
							</div>
							<div class="product-tile-footer">
								<div class="donnee_name product-title"><?php echo $product_array[$key]["name"]; ?></div>
								<div class="prix product-price"><?php echo "€" . $product_array[$key]["prix"]; ?></div>
								<div class="cart-action"><input type="text" class="product-quantity" name="quantity" value="1" size="2" /><input id="add_btn" type="submit" value="Ajouter Au Panier" class="btnAddAction" /></div>
							</div>

						</div>
					</form>
				</div>

		<?php
                }
                else{
                    echo "le produit n'existe pas";
                }
			}
		}
		?>
	</div>
</BODY>

</HTML>