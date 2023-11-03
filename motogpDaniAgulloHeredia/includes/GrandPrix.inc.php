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

    private function dates(){//funcion para sacar la fecha de nacimiento del usuario
        $months = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre']; // array para los meses en español
        $day = date('d',$this->date);
        $monthnumber = date('n',$this->date);
        $month = $months[$monthnumber-1];
        $year= date('Y',$this->date);
        return $day.' de '.$month.' de '.$year;
    }
  
    public function __toString(){ // metodo toString
        return $this->circuit.'<p>Fecha: '.$this->dates().'</p>';

    }  

    function addRider(Rider $rider,int $position){ 

        if(isset($this->rider[$position])){
            return false;
        }else{
            
            $this->rider[$position]=$rider;  
            return true;     
        }
    }

    function result(){
        $Therider='';

        for($i=1; $i<count($this->rider)+1;$i++){
           $Therider .= '<div class="pilot">
                         <p>'.$this->rider[$i].'</p>
                         <p>Posición:'.$i.'</p>
                         </div>';
        }
        return $Therider;
    }

}










