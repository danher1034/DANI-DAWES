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

    function addMechanic(Mechanic $mecha){
        $this->mechanic[]=$mecha;    
    }

    function addRider(Rider $ride){        
        $this->rider[]=$ride;
    }

    public function __toString()
    {
        $Therider='';
        $Themechanic='';

        foreach($this->rider as $value){
           $Therider .= '<p>'.$value.'</p>
                         <p>Fecha de nacimiento: '.$value->dateBirthday().'</p>';
        }
        foreach($this->mechanic as $value){
            $Themechanic .= '<p>'.$value.'</p>';
        }

        return '<div>
                    <h2>Equipo: '.$this->name.'</h2>
                    <p>País: '.$this->country.'</p>
                    <div>'.
                        $Therider
                    .'</div>
                    <div>'.
                        $Themechanic
                    .'</div>
                </div>';
            
    }
}