<?php
class LoginClass
{
    private $idLogin;
    private $nameLogin;
    private $passwordLogin;
    private $role;

    public function __construct()
    {
        //
    }

    public function iterateVisible()
    {
        $list = array();
        foreach ($this as $key => $value) {
            if($key == 'role')  
                $key = 'role_idRole';  
            $list[$key] = $value;
        }
        return $list;
    }

    public function LoginClass($nameLogin, $passwordLogin, $role = null)
    {
        $this->nameLogin = $nameLogin;
        $this->passwordLogin = $passwordLogin;
        $this->role = $role;

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

    public function toJson()
    {
        return '{
            "idLogin":"' . $this->idLogin .'",
            "nameLogin":"' . $this->nameLogin . '",
            "passwordLogin": "' . $this->passwordLogin . '",
            "role": "' . $this->role . '"
        }';
    }
}
