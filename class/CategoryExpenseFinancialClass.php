<?php
class CategoryExpenseFinancialClass{
    private $idCategoryExpenseFinancial;
    private $descCategoryExpenseFinancial;

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

    function CategoryExpenseFinancialClass($idCategoryExpenseFinancial, $descCategoryExpenseFinancial){
         $this->idCategoryExpenseFinancial = $idCategoryExpenseFinancial;
         $this->descCategoryExpenseFinancial = $descCategoryExpenseFinancial;         
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