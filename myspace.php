<?php

var_dump($template);

$taches = $template["datas"];


?>


<div class="title">
    <h1>Bienvenue <span><?= $_SESSION["pseudo"]; ?></span> dans votre espace personnel</h1>
</div>



<form action="index.php?route=inserttache" method="POST">
    <select name="description" id="description">
        <option value="">Listes des tâches</option>
        <option value="tache1">Tâche 1</option>
        <option value="tache2">Tâche 2</option>
        <option value="tache3">Tâche 3</option>
    </select>

    <select name="deadline" id="deadline">
        <option value="">Date limite</option>
        <option value="octobre">octobre</option>
        <option value="novembre">novembre</option>
        <option value="decembre">décembre</option>
    </select>

    <input type="submit" id='submit' value='Envoyer'>

</form>


<ul class="li">
    <?php foreach($taches as $tache):?>

        <li>la tache choisie est la <?= $tache->description ?> ainsi que la date <?= $tache->limitdate ?></li>
        
	<?php endforeach ?>
</ul>