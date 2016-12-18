<?php
class ServicClass{
    private $idServic;
    private $nameServic;
    private $breed;
    private $sizeAnimal;
    private $valuation;

    function __construct(){
        //
    }

    function ServicClass($idServic, $nameServic, $breed, $sizeAnimal, $valuation){
         $this->idServic = $idServic;
         $this->nameServic = $nameServic;
         $this->breed = $breed;
         $this->sizeAnimal = $sizeAnimal;
         $this->valuation = $valuation;
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