<?php
class CenterCostClass{
    private $idCenterCost;
    private $nameCenterCost;
    private $categoryExpenseFinancial;

    function __construct(){
        //
    }

    function iterateVisible() {
       $list = array();
       foreach ($this as $key => $value) {
        if($key == 'categoryExpenseFinancial')  
            $key = 'category_expense_financial_idCategoryExpenseFinancial';  
        $list[$key] = $value;
       }
       return $list;
    }

    function CenterCostClass($idCenterCost, $nameCenterCost, $categoryExpenseFinancial){
         $this->idCenterCost = $idCenterCost;
         $this->nameCenterCost = $nameCenterCost;
         $this->categoryExpenseFinancial = $categoryExpenseFinancial;
         
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

    public function toJson(){
        return '{
            "idCenterCost":   "'.$this->idCenterCost.'",
            "nameCenterCost": "'.$this->nameCenterCost.'"
        }';
    }
}

?>