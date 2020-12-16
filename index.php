<?php



// Début de la session PHP
session_start();


// ****************************** ROUTER ***********************************
// Récupération de la route via la requête utilisateur (GET) ?route=<route>
// Si aucune route n'est définie, on lui donne pour valeur "default"

// Début de la récupération pour mon router en utilisant GET venant de l'utilisateur 
$route = (isset($_GET["route"]))? $_GET["route"] : "accueil";



switch($route) {

    case "accueil" : $template = showHome();
    break;
    case "formuser" : $template = showFormUser();
    break;
    case "connectuser" : $template = connectUser();
    break;
    case "insertuser" : insert_user();
    break;
    case "formtache" : $template = showFormTache();
    break;
    case "inserttache" : insertTache();
    break;
    default : $template = showFormUser();
}


function showHome(): array {

    return ["template" => "accueil.php"];
}


function connectUser(){
    require "User.php";
    $user = new User($_SESSION["pseudo"] = $_POST["pseudo"],$_SESSION["password"] = $_POST["password"]);
    if($user->verifyUser()){
        header("Location:index.php?route=formtache");
        exit;
    }else{
        echo "une erreur s'est produite";
        return ["template" => "accueil.php"];
    }
    
}


function showFormUser(): array {

    require_once "User.php";

    $users = User::getUsers();

     var_dump($users);

    return ["template" => "accueil.php"];
}



function insert_user() {
    
    require_once "User.php";

    $user = new User($_POST["pseudo"], $_POST["password"]);
    $user->saveUser();

    // Pensez à commenter la redirection temporairement pour débuguer (voir vos var_dump)
    header("Location:index.php?route=formuser");
    exit;
    var_dump($user);
}




function showFormTache(): array {

    require_once "Tache.php";

    $taches = Tache::getTaches();

    return ["template" => "myspace.php", "datas" => $taches];
}



function insertTache(){

    require_once "Tache.php";

    $tache = new Tache($_POST["tache"], $_POST["date"]);
    $tache->saveTache();

    // Pensez à commenter la redirection temporairement pour débuguer (voir vos var_dump)
    header("Location:index.php?route=formtache");
    exit;

}



// function password_hash(){

// }




?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Application</title>
</head>
<body>

<nav>
    <ul>
        <li><a href="index.php?route=accueil">Accueil</a></li>
    </ul>
</nav>


<?php require $template['template']; ?>
    
</body>
</html>