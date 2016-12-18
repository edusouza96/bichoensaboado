<?php
class DiaryClass{
    private $idDiary;
    private $client;
    private $servic;
    private $search;
    private $price;
    private $deliveryPrice;
    private $totalPrice;
    private $dateHour;

    function __construct(){
        //
    }

    function DiaryClass($idDiary, $client, $servic, $search, $price, $deliveryPrice, $totalPrice, $dateHour){
         $this->idDiary = $idDiary;
         $this->client = $client;
         $this->servic = $servic;
         $this->search = $search;
         $this->price = $price;
         $this->deliveryPrice = $deliveryPrice;
         $this->totalPrice = $totalPrice;
         $this->dateHour = $dateHour;
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