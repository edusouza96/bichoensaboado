<?php
class ServicClass
{
    private $idServic;
    private $nameServic;
    private $breed;
    private $sizeAnimal;
    private $valuation;
    private $package;

    public function __construct()
    {
        //
    }

    public function ServicClass($idServic, $nameServic, $breed, $sizeAnimal, $valuation, $package)
    {
        $this->idServic = $idServic;
        $this->nameServic = $nameServic;
        $this->breed = $breed;
        $this->sizeAnimal = $sizeAnimal;
        $this->valuation = $valuation;
        $this->package = $package;
    }

    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }

}
