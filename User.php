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


    function saveUser(): bool {

        //Je récupère le contenu de mon fichier users.json sous forme de chaîne de caractère
        $contenu = (file_exists("datas/users.json"))? file_get_contents("datas/users.json") : "";

        //Je décode mon JSON en structure PHP (tableau associatif)
        $users = json_decode($contenu);

        // Je demande si $users existe en tableau, si c'est le cas, il restera lui-même, si non, le créer en tant que tel
        $users = (is_array($users))? $users : [];

        //Je crée un tableau avec mon nouvel objet courant car les $this ne peut pas être encoder après un json-encode
        $user = get_object_vars($this);

        //J'ajoute ce user à mon tableau des users (\$users)
        array_push($users, $user);

        //J'ouvre mon fichier users.json
        $handle = fopen("datas/users.json", "w");

        //Je réencode mon tableau au format JSON
        $json = json_encode($users);

        //J'écris ma chaîne JSON dans mon fichier users.json
        fwrite($handle, $json);
        //Je ferme mon fichier !
        fclose($handle);

        return false;
    }

    
    // fonction appelé sur l'index qui instancie les utilsateurs dans un tableau (array)
    static function getUsers(): array {

        $contenu = (file_exists("datas/users.json"))? file_get_contents("datas/users.json") : "";

        $users = json_decode($contenu);
   
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