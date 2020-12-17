<?php

class Tache {

    private $tache;
    private $limitdate;
    private $description;
    private $user_id;

    public function __construct(string $desc, string $user, string $limitdate, int $tache = 0) {
        $this->tache = $tache;
        $this->description = $desc;
        $this->user_id = $user;
        $this->limitdate = $limitdate;
    }


    // Application des getters et des setters permettant d'accéder aux valeurs des propriétés 

    public function getTache(): int {
        return $this->tache;
    }

    public function setTache(int $tache) {
        $this->tache = $tache;
    }


    public function getDescription(): string {
        return $this->description;
    }

    public function setDescription(string $desc) {
        $this->description = $desc;
    }



    public function getUser(): string {
        return $this->user_id;
    }

    public function setUser(string $user) {
        $this->user_id = $user;
    }


    public function getLimitDate(): string {
        return $this->limitdate;
    }

    public function setLimitDate(string $limitdate) {
        $this->limitdate = $limitdate;
    }

     // Fin des getters et setters


    function saveTache(){

         // echo "Je récupère le contenu de mon fichier users.json :<br>";
         $contenu = (file_exists("datas/taches.json"))? file_get_contents("datas/taches.json") : "";
         // var_dump($contenu);
 
         // echo "Je décode mon JSON en structure PHP (tableau associatif) :<br>";
         $taches = json_decode($contenu);
         // var_dump($users);
    
         $taches = (is_array($taches))? $taches : [];
 
         // echo "Je crée un tableau avec mon nouvel objet courant car les $this ne peut pas être encoder après un json-encode: <br>";
         $tache = get_object_vars($this);
         // var_dump($user);
 
         // echo "J'ajoute ce livre à mon tableau de livres (\$livres)";
         array_push($taches, $tache);
         // var_dump($users);
 
         // echo "J'ouvre mon fichier users.json <br>";
         $handle = fopen("datas/taches.json", "w");
 
         // echo "Je réencode mon tableau au format JSON : <br>";
         $json = json_encode($taches);
         // var_dump($json);
 
         // echo "J'écris ma chaîne JSON dans mon fichier livres.json<br>";
         fwrite($handle, $json);
         // echo "Je ferme mon fichier !";
         fclose($handle);

    }

    // fonction appelé sur l'index qui instancie les tâches dans un tableau (array)
    static function getTaches(): array {

        $contenu = (file_exists("datas/taches.json"))? file_get_contents("datas/taches.json") : "";
        // var_dump($contenu);

        $taches = json_decode($contenu);
        // var_dump($users);
   
        $taches = (is_array($taches))? $taches : [];

        return $taches;
    }

}



?>