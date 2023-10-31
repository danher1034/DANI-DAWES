<?php
/**
 * @author Dani Agullo Heredia
 * @version 1.0
 */

class GrandPrix{
    private $date;
    private $riders;
    private Circuit $circuit;



    public function __construct(int $date) //contructor del usuario
    {
     $this->date =$date;
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
        foreach($this->circuit as $value){
            $circuitInfo = '<p>'.$value.'</p>';
         }
        return $circuitInfo.$this->date;
    }

    function addRider(Rider $rider,int $position){    
        $riders=[
            'Position'=> $position,
            'Rider'=> $rider
        ];
    }

    function result($circuit, $date, $riders ){
        usort($riders, function($a, $b) {
            return $a['Position'] - $b['Position'];
        });
        return $this->circuit.$this->date.print_r($this->riders);
    }

}










