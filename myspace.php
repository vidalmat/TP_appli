<?php


$taches = $template["datas"];



 
?>



<h1>Bienvenue <?= $_SESSION["pseudo"]; ?> dans votre espace personnel</h1>

<form action="index.php?route=inserttache" method="POST">
    <select name="tache" id="tache">
        <option value="">Listes des tâches</option>
        <option value="tache1">Tâche 1</option>
        <option value="tache2">Tâche 2</option>
        <option value="tache3">Tâche 3</option>
    </select>

    <select name="date" id="date">
        <option value="">Date limite</option>
        <option value="date1">octobre</option>
        <option value="date2">novembre</option>
        <option value="date3">décembre</option>
    </select>

    <input type="submit" id='submit' value='Envoyer'>

</form>