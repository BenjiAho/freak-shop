
<html>
<body>
    <?php
        // VERIFIER SI LE POST SUBMIT FONCTIONNE, SI OUI, POST LES VALEURS RENTREES POUR LES CHAMPS
        if(isset($_POST['submit'])){
            $name=$_¨POST["name"];
            $code=$_POST["code"];
            $prix=$_¨POST["prix"];
            $photo=$_¨POST["photo"];
            $description=$_¨POST["description"];  
        }
    
    ?>
    <!-- FORMULAIRE -->
    <div class="form_contain">
        <!-- ACTION RENVOIE AU CATALOGUE -->
        <form class="form_article" action="index.php?page=catalogue" method="post">

            <p>
                <label for="Name">Nom de l'article :</label>
                <input type="text" name="name" id="Name" placeholder="Entrez appellation de l'article..." required>
            </p>
            <p>
                <label for="Photo">Photo de l'article :</label>
                <input type="url" name="photo" id="Photo" placeholder= "Entrez le lien URL de votre image" required>
            </p>
            
            <p>
                <label for="Prix">Prix :</label>
                <input type="number" step="0.01" name="prix" id="Prix" placeholder="Entrez le prix de l'article..." required>
            </p>
            <p>
                <label for="Code">Code de l'article :</label>
                <input type="text" name="code" id="code" placeholder="Entrez le code de l'article..." required>
            </p>
            <p>
                <label for="Name">Description de l'article:</label>
                <input type="text" name="description" id="Description" placeholder="Entrez la description de l'article" required>
            </p>

            <button id="form_button" type="submit" name="submit">Envoyer</button>


            <!-- echo "<script>alert(\"Le nouvel article a bien été ajouté au catalogue\")</script>"; -->

        </form>
    </div>
</html>
