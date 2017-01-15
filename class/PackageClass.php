<?php
class AddressClass{
    private $idPackage;
    private $date1;
    private $week1;
    private $date2;
    private $week2;
    private $date3;
    private $week3;
    private $date4;
    private $week4;

    function __construct(){
        //
    }

    function PackageClass($idPackage, $date1, $week1, $date2, $week2, $date3, $week3, $date4, $week4){
         $this->idPackage = $idPackage;
         $this->date1 = $date1;
         $this->week1 = $week1;
         $this->date2 = $date2;
         $this->week2 = $week2;
         $this->date3 = $date3;
         $this->week3 = $week3;
         $this->date4 = $date4;
         $this->week4 = $week4;
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