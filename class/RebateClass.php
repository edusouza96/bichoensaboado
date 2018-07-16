<?php
class RebateClass
{
    private $idRebate;
    private $descriptionRebate;
    private $valueRebate;
    private $active;

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

    public function RebateClass($descriptionRebate, $valueRebate, $active = true)
    {
        $this->descriptionRebate = $descriptionRebate;
        $this->valueRebate = $valueRebate;
        $this->active = $active;

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
