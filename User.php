<?php

require_once "users.php";

class User {

    
    private $user_id;
    private $pseudo;
    private $password;

    public function __construct(string $pseudo, string $password, int $id = 0) {
        $this->user_id = $id;
        $this->pseudo = $pseudo;
        $this->password = $password;
    }


    // Application des getters et des setters permettant d'accéder aux valeurs des propriétés 

    public function getUserId(): int {
        return $this->user_id;
    }

    public function setUserId(int $id) {
        $this->user_id = $id;
    }


    public function getUserPseudo(): string {
        return $this->pseudo;
    }

    public function setUserPseudo(string $pseudo) {
        $this->pseudo = $pseudo;
    }


    
    public function getUserPassword(): string {
        return $this->password;
    }

    public function setUserpassword(string $password) {
        $this->password = $password;
    }

    // Fin des getters et setters


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

    
    // fonction appelé sur l'index qui instancie les utilsateurs dans un tableau (array)
    static function getUsers(): array {

        $contenu = (file_exists("datas/users.json"))? file_get_contents("datas/users.json") : "";
        // var_dump($contenu);

        $users = json_decode($contenu);
        // var_dump($users);
   
        $users = (is_array($users))? $users : [];

        return $users;
    }


    // fonction de vérification des utilisateurs avec un booléen et en créant une variable récupérant les données du fichier json afin de comparer et vérifier le pseudo et mdp d'un utilisateur existant 
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