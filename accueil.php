<?php

require_once("index.php");


?>

<div class="conteneur_connexion">

    <div class="creation_compte">
        

        <h1 class="parconnexion">Vous n'avez pas de compte?</h1>


        <form action="index.php?route=insertuser" method="POST">

            <input type="text" placeholder="Pseudo" name="pseudo" required><br>
                        
            <input type="password" placeholder="Mot de passe" name="password" required ><br>

            <input type="password" placeholder="Confirmez le mot de passe" name="password2" required ><br>
            
            <input type="submit" id='submit' value='Inscription' >

        </form>

    </div>

    <span class="span2"></span>

    <div class="connexion">


        <form action="index.php?route=connectuser" method="POST">
            
                <h2>Se connecter</h2>
            
                <input type="text" placeholder="Pseudo" name="pseudo" required>
                
                <input type="password" placeholder="Mot de passe" name="password" required >
                
                <input type="submit" id='submit' value='Envoyer'>
            
        </form>

    </div>

</div>

