<?php
class FinancialClass{
    private $idFinancial;
    private $registerBuy;
    private $sales;
    private $valueProduct;
    private $description;
    private $dateDueFinancial;
    private $datePayFinancial;


    function __construct(){
        //
    }

    function iterateVisible() {
       $list = array();
       foreach ($this as $key => $value) {
            $list[$key] = $value;
       }
       return $list;
    }
    
    function FinancialClass($idFinancial, $registerBuy, $sales, $product, $valueProduct, $description, $dateDueFinancial,$datePayFinancial){
         $this->idFinancial = $idFinancial;
         $this->registerBuy = $registerBuy;
         $this->sales = $sales;
         $this->product = $product;
         $this->valueProduct = $valueProduct;
         $this->description = $description;
         $this->dateDueFinancial = $dateDueFinancial;
         $this->datePayFinancial = $datePayFinancial;
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