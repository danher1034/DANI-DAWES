<?php
/**
 * @author Dani Agullo Heredia
 * @version 1.0
 */

class GrandPrix{
    private $date;
    private $rider;
    private Circuit $circuit;



    public function __construct(int $date,Circuit $circuit) //contructor del usuario
    {
     $this->circuit=$circuit;
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
        return '<h2>Fecha: '.$this->date.'</h2>
                <p>Circuito: '.$this->circuit.'</p>';

    }


    

    function addRider(Rider $rider,int $position){ 
        
        $this->rider[]=$rider;

        if(isset($this->rider[$position])){
            return false;
        }else{
            $this->rider[$position]=$rider;
            return true;
        }
    }

    function result($circuit, $date, $riders ){
        usort($riders, function($a, $b) {
            return $a['Position'] - $b['Position'];
        });
        return '<div>
                    <h2>Fecha: '.$this->date.'</h2>
                    <p>Circuito: '.$this->circuit.'</p>
                </div>';
    }

}










