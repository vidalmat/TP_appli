<?php


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


    public function saveUser(): bool {

        //Je récupère le contenu de mon fichier users.json sous forme de chaîne de caractère
        $contenu = (file_exists("datas/users.json"))? file_get_contents("datas/users.json") : "";

        //Je décode mon JSON en structure PHP (tableau associatif)
        $users = json_decode($contenu);

        // Je demande si $users existe en tableau, si c'est le cas, il restera lui-même, si non, le créer en tant que tel
        $users = (is_array($users))? $users : [];

        //var_dump($users); // afin de vérifier ce que le tableau $users contient


        //Variable de vérification du bon résultat de l'appel à la méthode (utilisateur enregistré)
        $verif = true;

        // Je parcours mon tableau (ma liste d'utilisateurs) :
        foreach($users as $user) {
            //Si l'on rencontre un utilisateur ayant le même pseudo, on ne permettra pas l'enregistrement de l'utilisateur courant 
            if($user->pseudo == $this->pseudo) {
                $verif = false;
            }
        }

        if($verif) {

            $lastkey = (array_key_last($users) != null)? array_key_last($users) : 0;
            $this->user_id = (!empty($users))? $users[$lastkey]->user_id + 1 : 1;

            //Je crée un tableau avec mon nouvel objet courant car les $this ne peut pas être encoder après un json-encode
            $user = get_object_vars($this);

            //J'ajoute ce user à mon tableau des users (\$users)
            array_push($users, $user);

            //J'ouvre mon fichier users.json
            $handle = fopen("datas/users.json", "w");

            //Je réencode mon tableau au format JSON
            $json = json_encode($users);

            //J'écris ma chaîne JSON dans mon fichier users.json
            $verif = (fwrite($handle, $json))? true : false;
            //Je ferme mon fichier !
            fclose($handle);

        }

        return $verif;
    }


    // fonction de vérification des utilisateurs avec un booléen et en créant une variable récupérant les données du fichier json afin de comparer et vérifier le pseudo et mdp d'un utilisateur existant 
    public function verifyUser(): bool{
        $contenu = (file_exists("datas/users.json"))? file_get_contents("datas/users.json"): "" ;
        $users = json_decode($contenu);
        $users = ( is_array ($users))? $users : [];

        $verif = false;

        foreach ($users as $user) {
            if ($user->pseudo == $this->pseudo ) {
                $verif = password_verify($this->password , $user->password);
                $this->user_id = $user->user_id ;
            }
        }

        return  $verif ;
    }
}

?>


