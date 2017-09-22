<?php
class ProductClass{
    private $idProduct;
    private $nameProduct;
    private $valuationProduct;
    private $quantityProduct;
    private $valuationBuyProduct;
    private $barcodeProduct;

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

    function ProductClass($idProduct, $nameProduct, $valuationProduct, $quantityProduct, $valuationBuyProduct, $barcodeProduct){
         $this->idProduct = $idProduct;
         $this->nameProduct = $nameProduct;
         $this->valuationProduct = $valuationProduct;
         $this->quantityProduct = $quantityProduct;
         $this->valuationBuyProduct = $valuationBuyProduct;
         $this->barcodeProduct = $barcodeProduct;
         
    }

     public function __get($property) {
            if (property_exists($this, $property)) {
                return $this->$property;
            }
    }

    public function __set($property, $valuation) {
        if (property_exists($this, $property)) {
            $this->$property = $valuation;
        }
    }

    public function serialize(){
        return json_encode(get_object_vars ($this));
    }  
}

?>