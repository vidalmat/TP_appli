<?php



// Début de la session PHP
session_start();


require_once "utils/autoload.php";


// Début de la récupération pour mon router en utilisant GET venant de l'utilisateur 
$route = (isset($_GET["route"]))? $_GET["route"] : "accueil";


// Liste des routes: 
// Par défaut: Affichage de la page d'accueil
// index.php? route = accueil => Affichage de la page d'accueil
// index.php? route = insertuser => Ajout d'un nouvel utilisateur, redirigée vers l'affichage de la page d'accueil
// index.php? route = connectuser => Connexion d'un utilisateur, redirigée vers espace membre
// index.php? route = formuser => Affichage de l'espace membre
//index.php?route=inserttache => Ajout d'une nouvelle tâche qui sera redirigée vers la page myspace

// Début du router
switch($route) {

    case "accueil" : $template = showHome();
    break;
    case "formuser" : $template = showFormUser();//affichage de my space
    break;
    case "connectuser" : $template = connectUser();//Redirigé vers my space
    break;
    case "insertuser" : insert_user(); //Redirigé vers la page d'accueil, on ne met pas le $template car il s'agit d'une redirection avec le header
    break;
    case "inserttache" : insertTache(); //redirigée vers la page myspace
    break;
    default : $template = showHome();
    // Le default est défini au cas où aucune route n'est apporté 
}
// fin du router 


// cette fonction permet de définir la route de ma page d'accueil 
function showHome(): array {

    return ["template" => "accueil.php", "datas" => null ];
}


// elle affiche l'espace membre 
function showFormUser(): array {

    $taches = Tache::getUserTache($_SESSION["user"]["user_id"]);

    return ["template" => "myspace.php", "datas" => $taches];
}



// cette fonction permet de définir la connexion d'un nouvel utilisateur, incluant une fonction verifyUser afin de vérifier le pseudo et le mdp
function connectUser(){

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
            $_SESSION["errors"] ["champs"] = "L'ensemble des champs est obligatoire";
        }
    header("Location:index.php?route=accueil");
    exit;
}



// fonction d'ajout d'un nouvel utilisateur et ensuite sauvegardé via la fonction saveUser dans la class User
function insert_user() {

    if(!empty($_POST["pseudo"]) && !empty($_POST["password"]) && $_POST["password"] === $_POST["password2"]){

        $user = new User($_POST["pseudo"], password_hash($_POST["password"], PASSWORD_DEFAULT)); // ajout de la fonctionnalité password_hash afin de crypter le mdp
        echo "Résultats : ";
        $user->saveUser();

    }else{

        // Je ne peux pas procéder à la suite de l'ajout d'un utilisateur
        $_SESSION [ "errors" ] [ "connexion" ] = "Erreur lors de l'enregistrement" ;
    }

      // Redirection temporaire pour débuguer (via var_dump)
      header("Location:index.php?route=accueil");
      exit;
      var_dump($user);
      
}


// fonction d'ajout d'une nouvelle tâche et ensuite sauvegardé via la fonction saveTache dans la class Tache
function insertTache(){

    var_dump($_POST);
        // 'description' =>  chaîne  'tache1'  (longueur = 6) 
        // 'date limite' =>  chaîne  'octobre'  (longueur = 7)


    $tache = new Tache($_POST["description"], $_POST["limitdate"], $_SESSION["user"] ["user_id"]);
    $tache->saveTache();

    header("Location:index.php?route=formuser");
    exit;
}


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
<?php require $template["template"] ?>
    
</body>
</html>