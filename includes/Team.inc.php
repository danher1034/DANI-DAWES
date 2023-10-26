<?php
/**
 * @author Dani Agullo Heredia
 * @version 1.0
 */

class Team{
    private $name;
    private $country;
    private $rider;
    private $mechanic;

    public function __construct(string $name ,string $country) //contructor del usuario
    {
     $this->name =$name;    
     $this->country =$country;
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

    function addMechanic(Mechanic $m){
            $mechanic[]=$m;    
    }

    function addRider(Rider $m){        
            $rider[]=$m;
    }

    public function __toString()
    {
        foreach($this->rider as $value){
           $Therider = '<p>'.$value.'</p>';
        }
        foreach($this->mechanic as $value){
            $Themechanic = '<p>'.$value.'</p>';
        }
            
    }
}