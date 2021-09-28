<?php


//fonction pour afficher les articles sur page catalogue
function afficheCatalogue() {
    try
    {
        $bdd = new PDO('mysql:host=localhost;dbname=dbBoutique;charset=utf8', 'benji', 'campusnum');
    }
    catch (Exception $e)
    {
            die('Erreur : ' . $e->getMessage());
    }
    $reponse = $bdd->query('SELECT * FROM articles WHERE code');
    while($donnees = $reponse->fetch()) {

	
    
    }


    $reponse = $bdd->query('SELECT * FROM articles');
    while($donnees = $reponse->fetch()) {
        //si ce notre donnees n'est pas vide
		// if (!empty($donnees)) {
			//alors pour chaque clé et valeurs dans le tableau ($donnees)
			//passe en revue le tableau $donnees. À chaque itération, la valeur de l'élément courant est assignée à $value et assignera en plus la clé de l'élément courant à la variable $key (avec $key => $value). source : https://www.php.net/manual/fr/control-structures.foreach.php
			// foreach ($donnees as $key => $value) {
		

				echo '<div class="product-item contain_catalogue ">
					<!-- CONTENU DU CATALOGUE -->
					<form class="" method="post" action="index.php?page=catalogue&action=add&code='.$donnees["code"].'">
						<div class="texte_description">
							<div class="product-image img">
							<a href ="index.php?page=article&code=' .$donnees["code"].'"> <img class="img" src="' .$donnees["photo"]. '"> </a>
							</div>
							<div class="product-tile-footer">
								<div class="donnee_name product-title">'.$donnees["name"]. '</div>
								<div class="prix product-price">'. $donnees["prix"]. ' €</div>
								<div class="cart-action"><input type="text" class="product-quantity" name="quantity" value="1" size="2" /><input id="add_btn" type="submit" value="Ajouter Au Panier" class="btnAddAction" /></div>
							</div>

						</div>
					</form>
				</div>';
        		// echo ''.$donnees['name'].'<br>';
        		// echo '<img src="'.$donnees['photo'].'"/><br>';
        		// echo ''.$donnees['prix'].'<br>';
        		// echo ''.$donnees['code'].'<br>';
        		// echo ''.$donnees['description'].'<br>';
        	// }		
        	// if(!empty())
        	// 	return ;
        // }        
}}




// fonction pour afficher les articles sur page panier après un ajout d'article
function afficheCatalogue2() {
    try
    {
        $bdd = new PDO('mysql:host=localhost;dbname=dbBoutique;charset=utf8', 'benji', 'campusnum');
    }
    catch (Exception $e)
    {
            die('Erreur : ' . $e->getMessage());
    }
    $reponse = $bdd->query('SELECT * FROM articles WHERE code');
    while($donnees = $reponse->fetch()) {

	
    
    }


    $reponse = $bdd->query('SELECT * FROM articles');
    while($donnees = $reponse->fetch()) {
       
		

				echo '<div class="product-item contain_catalogue ">
					<!-- CONTENU DU CATALOGUE -->
					<form class="" method="post" action="index.php?page=panier&action=add&code='.$donnees["code"].'">
						<div class="texte_description">
							<div class="product-image img">
							<a href ="index.php?page=article&code=' .$donnees["code"].'"> <img class="img" src="' .$donnees["photo"]. '"> </a>
							</div>
							<div class="product-tile-footer">
								<div class="donnee_name product-title">'.$donnees["name"]. '</div>
								<div class="prix product-price">'. $donnees["prix"]. ' €</div>
								<div class="cart-action"><input type="text" class="product-quantity" name="quantity" value="1" size="2" /><input id="add_btn" type="submit" value="Ajouter Au Panier" class="btnAddAction" /></div>
							</div>

						</div>
					</form>
				</div>';    
    }
}



// fonction pour n'afficher qu'un seul article après l'avoir cliqué et l'ajout de cet article au panier est tjs possible
function afficheUnArticle ($code){
    try
    {
        $bdd = new PDO('mysql:host=localhost;dbname=dbBoutique;charset=utf8', 'benji', 'campusnum');
    }
    catch (Exception $e)
    {
            die('Erreur : ' . $e->getMessage());
    }
    $reponse = $bdd->query("SELECT * FROM articles WHERE code = '$code'");
    while($donnees = $reponse->fetch()){
    echo '<div class="product-item contain_catalogue ">
					<!-- CONTENU DU CATALOGUE -->
					<form class="" method="post" action="index.php?page=catalogue&action=add&code='.$donnees["code"].'">
						<div class="texte_description">
							<div class="product-image img">
							<a href ="index.php?page=article&code=' .$donnees["code"].'"> <img class="img" src="' .$donnees["photo"]. '"> </a>
							</div>
							<div class="product-tile-footer">
								<div class="donnee_name product-title">'.$donnees["name"]. '</div>
                                <div id="donnee_description" class="product-title"><i>'.$donnees["description"]. '<i></div>
								<div class="prix product-price">'. $donnees["prix"]. ' €</div>
								<div class="cart-action"><input type="text" class="product-quantity" name="quantity" value="1" size="2" /><input id="add_btn" type="submit" value="Ajouter Au Panier" class="btnAddAction" /></div>
							</div>

						</div>
					</form>
				</div>';
    }
}



 ?>

