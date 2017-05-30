<?php
class FinancialClass{
    private $idFinancial;
    private $registerBuy;
    private $userFinancial;
    private $product;
    private $valueProduct;
    private $description;


    function __construct(){
        //
    }

    function FinancialClass($idFinancial, $registerBuy, $userFinancial, $product, $valueProduct, $description){
         $this->idFinancial = $idFinancial;
         $this->registerBuy = $registerBuy;
         $this->userFinancial = $userFinancial;
         $this->product = $product;
         $this->valueProduct = $valueProduct;
         $this->description = $description;
         
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