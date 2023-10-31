<?php
/**
 * @author Dani Agullo Heredia
 * @version 1.0
 */

 class Circuit{
    private $name;
    private $country;
    private $laps;


    public function __construct(string $name ,string $country, int $laps) //contructor del usuario
    {
     $this->name =$name;    
     $this->country =$country;
     $this->laps =$laps;
    }

    public function __set ($property, $value){  //metodo set porque los atributos son privados
        if(isset($this->$property)){
            $this->$property = $value;
        }
    }

    public function __get ($property){ //metodo get porque los atributos son privados
        if(isset($this->$property)){
            return $this->$property;
        }
    }
  
    public function __toString(){ // metodo toString
        return $this->name.$this->country.$this->laps;
    }
}