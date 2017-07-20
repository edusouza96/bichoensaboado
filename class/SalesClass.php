<?php
class SalesClass{
    private $idSales;
    private $diarySales;
    private $productSales;
    private $quantityProductSales;
    private $valuationUnitSales;
 
    function __construct(){
        //
    }

    function SalesClass($idSales, $diarySales, $productSales, $quantityProductSales, $valuationUnitSales){
         $this->idSales = $idSales;
         $this->diarySales = $diarySales;
         $this->productSales = $productSales;
         $this->quantityProductSales = $quantityProductSales;
         $this->valuationUnitSales = $valuationUnitSales;
         
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