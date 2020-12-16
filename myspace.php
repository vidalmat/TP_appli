<?php


require_once "index.php";




 
?>



<h1>Bienvenue <?= $_SESSION["pseudo"]; ?> dans votre espace personnel</h1>

<form action="index.php?route=inserttache" method="POST">
    <select name="tache" id="tache">
        <option value="">Listes des tâches</option>
        <option value="tache1">Tâche 1</option>
        <option value="tache2">Tâche 2</option>
        <option value="tache3">Tâche 3</option>
    </select>

    <input type="submit" id='submit' value='Envoyer'>

</form>


<form action="index.php?route=insertdate" method="POST">

    <select name="date" id="date">
        <option value="">Date limite</option>
        <option value="date1">1</option>
        <option value="date2">2</option>
        <option value="date3">3</option>
    </select>

    <input type="submit" id='submit' value='Envoyer'>

</form>