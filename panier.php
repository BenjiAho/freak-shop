<?php

// UTILISER LE FICHIER DBController.PHP QUI NOUS CONNECTE A LA BASE DE DONNEES
// dbcontroller();
// $db_handle = new DBController();
//RECUPERER L'ACTION DU FORMULAIRE

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
				header('location:index.php?page=panier');
			}
			break;
    // SUPPRIMER UN ARTICLE DU PANIER
	case "remove":
		if(!empty($_SESSION["cart_item"])) {
			foreach($_SESSION["cart_item"] as $k => $v) {
					if($_GET["code"] == $k)
						unset($_SESSION["cart_item"][$k]);				
					if(empty($_SESSION["cart_item"]))
						unset($_SESSION["cart_item"]);
			}
			// REFRESH LA PAGE APRES L'ACTION DE LA FONCTION
			header('location:index.php?page=panier');
		}
	break;
    // VIDER LE PANIER
	case "empty":
		unset($_SESSION["cart_item"]);
		// REFRESH LA PAGE APRES L'ACTION DE LA FONCTION
		header('location:index.php?page=panier');
	break;	
}
}
?>
<HTML>
<HEAD>
<TITLE>Panier</TITLE>
<link href="style.css" type="text/css" rel="stylesheet" />
</HEAD>
<BODY>
    <!-- DEBUT LIST CARD ITEMS -->
<!-- <div id="shopping-cart">
<div class="txt-heading">Panier</div> -->
<div id="btnEmpty">
<a id="sub_btnEmpty" href="index.php?page=panier&idArticle=&action=empty">Vider Le Panier<img src="https://img.icons8.com/material-outlined/24/000000/delete-trash.png"/></a>
</div>
<?php
//vérifie si la session panier existe, puis initialise $total_quantity et $total_price avec comme valeur de départ 0
if(isset($_SESSION["cart_item"])){
    $total_quantity = 0;
    $total_price = 0;
?>	
<table cellpadding="0" cellspacing="0" class="tbl-cart">
<tbody class="trbody">
<tr>
<th style="text-align:center;">PANIER</th>
<th style="text-align:center;">Nom</th>
<th style="text-align:center;">Code</th>
<th style="text-align:right;" width="5%">Quantité</th>
<th style="text-align:right;" width="10%">Prix/unité</th>
<th style="text-align:right;" width="10%">Prix</th>
<th style="text-align:center;" width="5%">Supprimer</th>
</tr>
	
<?php	
    // FOREACH POUR AFFICHER LES ITEMS DU PANIER
	//passe en revue le tableau iterable_expression. À chaque itération, la valeur de l'élément courant est assignée à $value. source: https://www.php.net/manual/fr/control-structures.foreach.php
    foreach ($_SESSION["cart_item"] as $donnee){
		//déclare $donnee_price est égal à la quantité d'items * le prix
        $donnee_price = $donnee["quantity"]*$donnee["prix"];
		?>
				<tr class="">
				<td>
					<!-- affiche avec echo les valeurs correspondantes dans le tableau -->
					<img src="
						<?php 
							echo $donnee["photo"]; 
						?>
					" class="cart-item-image img"/>
				</td>
				<td><?php echo $donnee["name"]; ?></td>
				<td><?php echo $donnee["code"]; ?></td>
				<td style="text-align:right;"><?php echo $donnee["quantity"]; ?></td>
				<td  style="text-align:right;"><?php echo "€ ".$donnee["prix"]; ?></td>
				<!-- number_format Pour afficher 2 chiffres après la virgule A Rust crate for producing string representations of numbers, formatted according to international standards, e.g. -->
				<td  style="text-align:right;"><?php echo "€ ". number_format($donnee_price,2); ?></td>
                                                        <!-- AFFICHE APRES VIDE PANIER -->
				<td style="text-align:center;">
					<a href="index.php?page=panier&action=remove&code=
						<?php echo $donnee["code"]; ?>
					" class="btnRemoveAction">
					<img src="https://img.icons8.com/plumpy/24/000000/delete-sign--v2.png" alt="Supprimer Cet Article Du Panier"/>
					</a>
				</td>
				</tr>
				<?php
				//quantité total est égal à total quantité + quantité
				$total_quantity += $donnee["quantity"];
				//prix total est égal à prix total + prix
				$total_price += ($donnee["prix"]*$donnee["quantity"]);
	}
				?>

<tr>
<td colspan="3" align="right"></td>
<td align="right">Total:<?php echo $total_quantity; ?></td>
<!-- number_format A Rust crate for producing string representations of numbers, formatted according to international standards, e.g. -->
<td align="right" colspan="3"><strong><?php echo "€ ".number_format($total_price, 2); ?></strong></td>
<td></td>
</tr>
</tbody>
</table>		
  <?php
} else {
?>
<div class="no-records"><img id="sad_face" src="https://img.icons8.com/nolan/128/sad.png"/>Votre panier est vide </div>
<?php 
}
?>
</div>
<!-- FIN LIST CART -->
<div class="txt-heading">Ces articles pourraient vous intéresser =D</div>
<div ID="product-grid" class="catalogue_main">
	
	<?php
	//déclare variable $product_array est égal tout de la table articles dans bdd dans un ordre ascendant
		//ASC = pour préciser ordre ascendant.
		$reponse = $bdd->query("SELECT * FROM articles ");
	//si ce notre product_array n'est pas vide
	if (!empty($product_array)) { 
		//alors pour chaque clé et valeurs dans le tableau ($product_array)
		//passe en revue le tableau $product_array. À chaque itération, la valeur de l'élément courant est assignée à $value et assignera en plus la clé de l'élément courant à la variable $key (avec $key => $value).
		foreach($product_array as $key=>$value){
	?>

		<div class="product-item">
            <!-- AFFICHE APRES AJOUT D'ARTICLE -->
			<form class="contain_catalogue" method="post" action="index.php?page=panier&action=add&code=<?php echo $product_array[$key]["code"]; ?>">
            <div class="texte_description">
			<div class="product-image img">
                <img class="img" src="<?php echo $product_array[$key]["photo"]; ?>">
            </div>
			<div class="product-tile-footer">
			<div class="donnee_name product-title"><?php echo $product_array[$key]["name"]; ?></div>
			<div class="prix product-price"><?php echo "€".$product_array[$key]["prix"]; ?></div>
			<div class="cart-action"><input type="text" class="product-quantity" name="quantity" value="1" size="2" /><input id="add_btn"  type="submit" value="Add to Cart" class="btnAddAction" /></div></div>
            
			</div>
			</form>
		</div>
    
	<?php
		}
	}
	afficheCatalogue2();
	?>
</div>
</BODY>
</HTML>