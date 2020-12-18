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
    case "insertuser" : insert_user(); // on ne met pas le $template car il s'agit d'une redirection avec le header
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
    require_once "User.php";
    if(!empty($_POST["pseudo"]) && !empty($_POST["password"])){
    
        $user = new User($_POST["pseudo"], $_POST["password"]);
        if($user->verifyUser()){
            $_SESSION["user"] ["user_id"] = $user->getUserId();
            $_SESSION["user"] ["pseudo"] = $user->getUserPseudo();

            header("Location:index.php?route=formuser");
            exit;
        }else{
            $_SESSION["errors"] ["connexion"] = "Une erreur s'est produite, identifiant et/ou mot de passe incorrect";
        }
        }else{
            $_SESSION["errors"] ["champs"] = "l'ensemble des champs est obligatoire";
        }
    header("Location:index.php?route=accueil");
    exit;
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

    if(!empty($_POST["pseudo"]) && !empty($_POST["password"]) && $_POST["password"] === $_POST["password2"]){

        require_once "User.php";

        $user = new User($_POST["pseudo"], password_hash($_POST["password"], PASSWORD_DEFAULT)); // ajout de la fonctionnalité password_hash afin de crypter le mdp
        echo "Résultats : ";
        $user->saveUser();

    }else{

        // Je ne peux pas procéder à la suite de l'ajout d'un utilisateur
        $_SESSION [ "errors" ] [ "connexion" ] = "Erreur lors de l'enregistrement" ;
    }

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