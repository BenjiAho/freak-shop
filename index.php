<?php
    //Vu que la session doit durée tout le temps, je la start ici au tout début, avant même d'include les pages 
    session_start();
    
    try
    {
        $bdd = new PDO('mysql:host=localhost;dbname=dbBoutique;charset=utf8', 'benji', 'campusnum');
    }
    catch (Exception $e)
    {
            die('Erreur : ' . $e->getMessage());
    }

    include 'header.php';
    //on a inclus le fichier functions.php 
    require 'functions.php';
    if (isset($_GET['page'])) {
        if ($_GET['page'] == 'accueil') {
            include 'main.php';
        }
        if ($_GET['page'] == 'catalogue') {
            include 'catalogue.php';
        }
        if ($_GET['page'] == 'article') {
            include 'article.php';
        }
        if ($_GET['page'] == 'form') {
            include 'form.php';
        }
        if ($_GET['page'] == 'panier') {
            include 'panier.php';
        }
    } else {
        include 'main.php';
    }

    include 'footer.php';
?>


