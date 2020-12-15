<?php

class Tache {

    private $tache;
    private $description;
    private $limitdate;
    private $name;

    function __construct(string $tache, string $description, string $limitdate, string $name) {
        $this->tache = $tache;
        $this->description = $description;
        $this->limitdate = $limitdate;
        $this->name = $name;
    }


}



?>