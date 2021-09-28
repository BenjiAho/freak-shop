
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Freak-Boutik-website</title>
</head>
<body>
<header>

<?php
// PASTILLE : check si la session cart_item existe, count le nombre d'item différents dans le panier
if(isset($_SESSION["cart_item"])){
    //count compte les items
    $pastille= count($_SESSION["cart_item"]);
}
//sinon rien 
else{
    $pastille = 0;
}

?>

<a href="index.php?page=accueil"><h1>Freak-Boutik</h1></a>
<nav class="nav_bar">
    <ol>
        <li class=""><a href="index.php?page=accueil">Accueil</a></li>
        <li class=""><a href="index.php?page=catalogue">catalogue</a></li>
        <li class=""><a href="index.php?page=form">Formulaire D'ajout</a></li>
        <!-- PANIER -->
        <li class="">
            <a href="index.php?page=panier">
                <img src="https://img.icons8.com/ios-filled/30/000000/shopping-cart.png" class="fas fa-shopping-cart"/>
                <span id="pastille">
                    <?php 
                        //affiche le nombre d'item différents dans le panier sur la pastille 
                        echo $pastille;
                    ?>
                </span>
            </a>
        </li>
    </ol>
</nav>
</header>


