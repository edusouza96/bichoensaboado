<?php
class FinancialClass
{
    private $idFinancial;
    private $registerBuy;
    private $sales;
    private $valueProduct;
    private $description;
    private $dateDueFinancial;
    private $datePayFinancial;
    private $centerCost;
    private $methodPayment;
    private $numberPlotsFinancial;
    private $typeTreasurerFinancial;
    private $valueAliquot;
    private $store;

    public function __construct()
    {
        //
    }

    public function iterateVisible()
    {
        $list = array();
        foreach ($this as $key => $value) {
            if ($key == 'centerCost') {
                $key = 'center_cost_idCenterCost';
            }

            $list[$key] = $value;
        }
        return $list;
    }

    public function FinancialClass($idFinancial, $registerBuy, $sales, $product, $valueProduct, $description, $dateDueFinancial, $datePayFinancial, $methodPayment = null, $numberPlotsFinancial = null, $typeTreasurerFinancial = null, $valueAliquot = null, $store = null)
    {
        $this->idFinancial = $idFinancial;
        $this->registerBuy = $registerBuy;
        $this->sales = $sales;
        $this->product = $product;
        $this->valueProduct = $valueProduct;
        $this->description = $description;
        $this->dateDueFinancial = $dateDueFinancial;
        $this->datePayFinancial = $datePayFinancial;
        $this->methodPayment = $methodPayment;
        $this->numberPlotsFinancial = $numberPlotsFinancial;
        $this->typeTreasurerFinancial = $typeTreasurerFinancial;
        $this->valueAliquot = $valueAliquot;
        $this->store = $store;
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
}
