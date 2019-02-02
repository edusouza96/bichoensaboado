<?php
class SangriaClass
{
    private $idSangria;
    private $value;
    private $date;
    private $store;

    public function __construct()
    {
        //
    }

    public function iterateVisible()
    {
        $list = array();
        foreach ($this as $key => $value) {
            $list[$key] = $value;
        }
        return $list;
    }

    public function SangriaClass($value, $date, $store)
    {
        $this->value = $value;
        $this->date = $date;
        $this->store = $store;

    }

    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $valuation)
    {
        if (property_exists($this, $property)) {
            $this->$property = $valuation;
        }
    }

    public function serialize()
    {
        return json_encode(get_object_vars($this));
    }

}
