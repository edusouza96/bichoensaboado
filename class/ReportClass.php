<?php
class ReportClass{
    private $idReport;
    private $column1Report;
    private $column2Report;
    private $column3Report;
    private $column4Report;
    private $column5Report;
    private $column6Report;
    private $column7Report;
    private $column8Report;
    private $column9Report;
    private $column10Report;
    
    function __construct(){
        //
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