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

    public function toJson(){
        return '{
            "idReport": "'.$this->idReport.'",
            "column1Report": "'.$this->column1Report.'",
            "column2Report": "'.$this->column2Report.'",
            "column3Report": "'.$this->column3Report.'",
            "column4Report": "'.$this->column4Report.'",
            "column5Report": "'.$this->column5Report.'",
            "column6Report": "'.$this->column6Report.'",
            "column7Report": "'.$this->column7Report.'",
            "column8Report": "'.$this->column8Report.'",
            "column9Report": "'.$this->column9Report.'",
            "column10Report": "'.$this->column10Report.'"
        }';
    }
}

?>