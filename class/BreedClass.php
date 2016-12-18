<?php
class BreedClass{
    private $idBreed;
    private $nameBreed;

    function __construct(){
        //
    }

    function BreedClass($idBreed, $nameBreed){
         $this->idBreed = $idBreed;
         $this->nameBreed = $nameBreed;
    }

     public function __get($property) {
            if (property_exists($this, $property)) {
                return $this->$property;
            }
    }

    public function __set($property, $value) {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }
}

?>