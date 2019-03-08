<?php
class DiaryClass
{
    private $idDiary;
    private $client;
    private $search;
    private $servic;
    private $price;
    private $servicVet;
    private $priceVet;
    private $deliveryPrice;
    private $totalPrice;
    private $dateHour;
    private $status;
    private $package;
    private $companion;
    private $checkinHourDiary;
    private $checkoutHourDiary;
    private $pay;
    private $store = 1;

    public function __construct()
    {
        //
    }

    public function DiaryClass($idDiary, $client, $search, $servic, $price,  $servicVet, $priceVet, $deliveryPrice, $totalPrice, $dateHour, $package)
    {
        $this->idDiary = $idDiary;
        $this->client = $client;
        $this->search = $search;
        $this->servic = $servic;
        $this->price = $price;
        $this->servicVet = $servicVet;
        $this->priceVet = $priceVet;
        $this->deliveryPrice = $deliveryPrice;
        $this->totalPrice = $totalPrice;
        $this->dateHour = $dateHour;
        $this->package = $package;
    }

    public function isPay()
    {
        return $this->pay;
    }

    public function price()
    {
        return $this->price + $this->priceVet;
    }
    
    public function valueSearch()
    {
        if($this->search == 1)
            return $this->totalPrice - $this->price;
        
        return 0;
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

    public function getNameServic()
    {
        $week = '';
        if($this->package){
            for($iPack = 1; $iPack<5; $iPack++){
                $datePack = 'date'.$iPack;
                $weekPack = 'week'.$iPack;
                if($this->dateHour == $this->package->${'datePack'}){
                    $week = $this->package->${'weekPack'};
                    break;
                }
            }
        }

        if(!empty($week)){
            return $this->servic->nameServic.' - Semana '.$week.' (Primeiro banho do Pacote '. date("d/m/Y H:i", strtotime($this->package->date1)).')';
        }

        return  $this->servic->nameServic;
    }
}
