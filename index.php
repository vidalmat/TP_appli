<?php



// Début de la session PHP
session_start();


// Début de la récupération pour mon router en utilisant GET venant de l'utilisateur 
$route = (isset($_GET["route"]))? $_GET["route"] : "accueil";


// Début du router
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
    // Le default est défini au cas où aucune route n'est apporté 
}
// fin du router 


// cette fonction permet de définir la route de ma page d'accueil 
function showHome(): array {

    return ["template" => "accueil.php"];
}

// cette fonction permet de définir la connexion d'un nouvel utilisateur, incluant une fonction verifyUser afin de vérifier le pseudo et le mdp
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

// elle définie la fonction pour voir le formulaire utilisateur sous forme de tableau (array) appelant également getUsers (le tableau des utilisateurs)
function showFormUser(): array {

    require_once "User.php";

    $users = User::getUsers();

     var_dump($users);

    return ["template" => "accueil.php"];
}


// fonction d'ajout d'un nouvel utilisateur et ensuite sauvegardé via la fonction saveUser dans la class User
function insert_user() {
    
    require_once "User.php";

    $user = new User($_POST["pseudo"], $_POST["password"]);
    $user->saveUser();

    // Redirection temporaire pour débuguer (via var_dump)
    header("Location:index.php?route=formuser");
    exit;
    var_dump($user);
}



// elle définie la fonction pour voir le formulaire des tâches sous forme de tableau (array) appelant également getTaches (le tableau des tâches) de la class Tache
function showFormTache(): array {

    require_once "Tache.php";

    $taches = Tache::getTaches();

    return ["template" => "myspace.php", "datas" => $taches];
}


// fonction d'ajout d'une nouvelle tâche et ensuite sauvegardé via la fonction saveTache dans la class Tache
function insertTache(){

    require_once "Tache.php";

    $tache = new Tache($_POST["tache"], $_POST["date"]);
    $tache->saveTache();

    // Redirection temporaire pour débuguer (via var_dump)
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

<!-- appel du template -->
<?php require $template['template']; ?>
    
</body>
</html>