<?php


// ***************************** SESSION ***********************************
// Lancement du mécanisme de session PHP
session_start();

$_SESSION = array();

var_dump($_SESSION);
// ****************************** ROUTER ***********************************
// Récupération de la route via la requête utilisateur (GET) ?route=<route>
// Si aucune route n'est définie, on lui donne pour valeur "default"
$route = (isset($_GET["route"]))? $_GET["route"] : "accueil";



switch($route) {

    case "accueil" : $template = include("accueil.php");
    break;
    case "formuser" : $template = showFormUser();
    break;
    case "connectuser" : $template = connectUser();
    break;
    case "myspace" : $template = include("myspace.php");
    break;
    case "insertuser" : insert_user();
    break;
    // On ajoute une nouvelle route pour chaque fonctionnalités
    default : $template = showFormUser();
}

// ************************* FONCTIONS DE CONTROLE *************************
// On déclare ici toutes les fonctions appelées par le router, en fonction du choix de l'utilisateur





// ******************************* AFFICHAGE *******************************
// L'affichage des templates se fait grâce à la variable $template (qui doit avoir une valeur)



function connectUser(){
    require "User.php";
    $user = new User($_POST["pseudo"], $_POST["password"]);
    if($user->verifyUser()){
        return ["template" => "myspace"];
    }else{
        echo "une erreur s'est produite";
        return ["template" => "accueil"];
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
    
}



// function password_hash(){

// }

// ******************************* AFFICHAGE *******************************
// L'affichage des templates se fait grâce à la variable $template (qui doit avoir une valeur)


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



    
</body>
</html>