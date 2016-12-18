<?php
class ClientClass{
    private $idClient;
    private $owner;
    private $nameAnimal;
    private $breed;
    private $address;
    private $addressNumber;
    private $addressComplement;
    private $phone1;
    private $phone2;
    private $email;

    function __construct(){
        //
    }

    function ClientClass($idClient, $owner, $nameAnimal, $breed, $address, $addressNumber, $addressComplement, $phone1, $phone2, $email){
         $this->idClient = $idClient;
         $this->owner = $owner;
         $this->nameAnimal = $nameAnimal;
         $this->breed = $breed;
         $this->address = $address;
         $this->addressNumber = $addressNumber;
         $this->addressComplement = $addressComplement;
         $this->phone1 = $phone1;
         $this->phone2 = $phone2;
         $this->email = $email;
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