<?php

require_once "users.php";

class User {

    private $pseudo;
    private $password;
    private $password2;

    function __construct(string $pseudo, string $password, string $password2) {
        $this->pseudo = $pseudo;
        $this->password = $password;
        $this->password2 = $password2;
    }


    function saveUser() {

        // echo "Je récupère le contenu de mon fichier users.json :<br>";
        $contenu = (file_exists("datas/users.json"))? file_get_contents("datas/users.json") : "";
        // var_dump($contenu);

        // echo "Je décode mon JSON en structure PHP (tableau associatif) :<br>";
        $users = json_decode($contenu);
        // var_dump($users);
   
        $users = (is_array($users))? $users : [];

        // echo "Je crée un tableau avec mon nouvel objet courant car les $this ne peut pas être encoder après un json-encode: <br>";
        $user = get_object_vars($this);
        // var_dump($user);

        // echo "J'ajoute ce livre à mon tableau de livres (\$livres)";
        array_push($users, $user);
        // var_dump($users);

        // echo "J'ouvre mon fichier users.json <br>";
        $handle = fopen("datas/users.json", "w");

        // echo "Je réencode mon tableau au format JSON : <br>";
        $json = json_encode($users);
        // var_dump($json);

        // echo "J'écris ma chaîne JSON dans mon fichier livres.json<br>";
        fwrite($handle, $json);
        // echo "Je ferme mon fichier !";
        fclose($handle);
    }

    static function getUsers(): array {

        $contenu = (file_exists("datas/users.json"))? file_get_contents("datas/users.json") : "";
        // var_dump($contenu);

        $users = json_decode($contenu);
        // var_dump($users);
   
        $users = (is_array($users))? $users : [];

        return $users;
    }



    function verifyUser(){
        $connect = false;
        $tab = json_decode(file_get_contents("datas/users.json"));
        $tab = (is_array($tab))? $tab : [];
        
        foreach($tab as $value) {
            if($value->pseudo == $this->pseudo && $value->password == $this->password) {
                $connect = true; 

            }
        }
        return $connect;
    }
}

?>