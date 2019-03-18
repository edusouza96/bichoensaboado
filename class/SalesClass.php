<?php
class SalesClass
{
    private $idSales;
    private $diarySales;
    private $productSales;
    private $quantityProductSales;
    private $valuationUnitSales;
    private $valueReceive;

    public function __construct()
    {
        //
    }

    public function SalesClass($idSales, $diarySales, $productSales, $quantityProductSales, $valuationUnitSales, $valueReceive)
    {
        $this->idSales = $idSales;
        $this->diarySales = $diarySales;
        $this->productSales = $productSales;
        $this->quantityProductSales = $quantityProductSales;
        $this->valuationUnitSales = $valuationUnitSales;
        $this->valueReceive = $valueReceive;
    }

    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }

    public function iterateVisible()
    {
        $list = array();
        foreach ($this as $key => $value) {
            $list[$key] = $value;
        }
        return $list;
    }

    public function serialize()
    {
        return json_encode(get_object_vars($this));
    }

    public function debtorValue()
    {
        return $this->valuationUnitSales - $this->valueReceive;
    }
}
