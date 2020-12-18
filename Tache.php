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

         //Je récupère le contenu de mon fichier users.json :<br>";
         $contenu = (file_exists("datas/taches.json"))? file_get_contents("datas/taches.json") : "";
 
         //Je décode mon JSON en structure PHP (tableau associatif) :<br>";
         $taches = json_decode($contenu);
    
         $taches = (is_array($taches))? $taches : [];
 
         //Je crée un tableau avec mon nouvel objet courant car les $this ne peut pas être encoder après un json-encode: <br>";
         $tache = get_object_vars($this);
 
         //J'ajoute cette tache à mon tableau de taches (\$taches)";
         array_push($taches, $tache);
         // var_dump($users);
 
         //J'ouvre mon fichier users.json <br>";
         $handle = fopen("datas/taches.json", "w");
 
         //Je réencode mon tableau au format JSON : <br>";
         $json = json_encode($taches);
         // var_dump($json);
 
         //J'écris ma chaîne JSON dans mon fichier taches.json<br>";
         fwrite($handle, $json);
         //Je ferme mon fichier !";
         fclose($handle);

           //Variable de vérification du bon résultat de l'appel à la méthode (utilisateur enregistré)
           $verif = true;

           // Je parcours mon tableau (ma liste des tâches) :
           foreach($taches as $tache) {
               if($tache->description == $this->description) {
                   $verif = false;
               }
           }
   
           if($verif) {
   
               $lastkey = (array_key_last($taches) != null)? array_key_last($taches) : 0;
               $this->user_id = (!empty($taches))? $taches[$lastkey]->user_id + 1 : 1;
   
               //Je crée un tableau avec mon nouvel objet courant car les $this ne peut pas être encoder après un json-encode
               $tache = get_object_vars($this);
   
               //J'ajoute ce user à mon tableau des taches (\$taches)
               array_push($taches, $tache);
   
               //J'ouvre mon fichier taches.json
               $handle = fopen("datas/taches.json", "w");
   
               //Je réencode mon tableau au format JSON
               $json = json_encode($taches);
   
               //J'écris ma chaîne JSON dans mon fichier taches.json
               $verif = (fwrite($handle, $json))? true : false;
               //Je ferme mon fichier !
               fclose($handle);
   
           }
   
           return $verif;
     }

    }

//     // fonction appelé sur l'index qui instancie les tâches dans un tableau (array)
//     static function getTaches(): array {

//         $contenu = (file_exists("datas/taches.json"))? file_get_contents("datas/taches.json") : "";

//         $taches = json_decode($contenu);
   
//         $taches = (is_array($taches))? $taches : [];

//         return $taches;

// }



?>