<?php
class AddressClass{
    private $idAddress;
    private $district;
    private $street;
    private $valuation;

    function __construct(){
        //
    }

    function AddressClass($idAddress, $district, $street, $valuation){
         $this->idAddress = $idAddress;
         $this->district = $district;
         $this->street = $street;
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