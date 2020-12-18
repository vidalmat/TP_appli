<?php

class Tache {

    private $idtache;
    private $limitdate;
    private $description;
    private $user_id;

    public function __construct(string $desc, string $user, string $limitdate, int $id = 0) {
        $this->idtache = $id;
        $this->description = $desc;
        $this->user_id = $user;
        $this->limitdate = $limitdate;
    }


    // Application des getters et des setters permettant d'accéder aux valeurs des propriétés 

    public function getIdTache(): int {
        return $this->idtache;
    }

    public function setTache(int $id) {
        $this->idtache = $id;
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

        //Je récupère le contenu de mon fichier users.json :<br>";
        $contenu = (file_exists("datas/taches.json"))? file_get_contents("datas/taches.json") : "";
 
        //Je décode mon JSON en structure PHP (tableau associatif) :<br>";
        $taches = json_decode($contenu);
    
        $taches = (is_array($taches))? $taches : [];


        // Variable de vérification du bon résultat de l'appel à la méthode (utilisateur enregistré)

        $lastkey = (array_key_last($taches) != null)? array_key_last($taches) : 0;
        $this->user_id = (!empty($taches))? $taches[$lastkey]->user_id + 1 : 1;

        //Je crée un tableau avec mon nouvel objet courant car les $this ne peut pas être encoder après un json-encode: <br>";
        $tache = get_object_vars($this);
 
        //J'ajoute cette tache à mon tableau de taches (\$taches)";
         array_push($taches, $tache);
        // var_dump($taches);

        //J'ouvre mon fichier users.json <br>";
        $handle = fopen("datas/taches.json", "w");
 
        $verif = (fwrite ($handle, json_encode($taches)))? true : false;
        fclose($handle);
   
        return $verif;
    }

    static function getUserTache(int $id): array {

        //Je récupère le contenu de mon fichier users.json :<br>";
        $contenu = (file_exists("datas/taches.json"))? file_get_contents("datas/taches.json") : "";
        var_dump($contenu);
        //Je décode mon JSON en structure PHP (tableau associatif) :<br>";
        $taches = json_decode($contenu);
    
        $taches = (is_array($taches))? $taches : [];


        $userTaches = []; 
        foreach($taches as $tache) {
            if($tache->user_id == $id) {
                array_push($userTaches, $tache);
            }
        }


        usort($userTaches, function ($a,$b) {

            if($a->limitdate == $b->limitdate) {
                return 0;
            }
            return ($a->limitdate < $b->limitdate) ? -1 : 1;

        });

        return $userTaches;
    }

    }


?>