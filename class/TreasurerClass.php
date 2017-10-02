<?php
class TreasurerClass{
    private $idTreasurer;
    private $startingMoneyDayTreasurer;
    private $closingMoneyDayTreasurer;
    private $moneyDrawerTreasurer;
    private $moneySavingsTreasurer;
    private $moneyBankTreasurer;
    private $dateRegistryTreasurer;

    function __construct(){
            //

    }

    function TreasurerClass($idTreasurer, $startingMoneyDayTreasurer, $closingMoneyDayTreasurer, $moneyDrawerTreasurer, $moneySavingsTreasurer, $moneyBankTreasurer, $dateRegistryTreasurer){
        $this->idTreasurer = $idTreasurer;
        $this->startingMoneyDayTreasurer = $startingMoneyDayTreasurer;
        $this->closingMoneyDayTreasurer = $closingMoneyDayTreasurer;
        $this->moneyDrawerTreasurer = $moneyDrawerTreasurer;
        $this->moneySavingsTreasurer = $moneySavingsTreasurer;
        $this->moneyBankTreasurer = $moneyBankTreasurer;
        $this->dateRegistryTreasurer = $dateRegistryTreasurer;
    }   

    function iterateVisible() {
       $list = array();
       foreach ($this as $key => $value) {
            $list[$key] = $value;
       }
       return $list;
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