<?php
/**
 * @author Dani Agullo Heredia
 * @version 1.0
 */

 class Person{
    protected $name;
    protected $birthday;


    public function __construct(string $name ,int $birthday) //contructor del usuario
    {
     $this->name =$name;    
     $this->birthday =$birthday;
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

    public function dateBirthday(){//funcion para sacar la fecha de nacimiento del usuario
        $months = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre']; // array para los meses en español
        $day = date('d',$this->birthday);
        $monthnumber = date('n',$this->birthday);
        $month = $months[$monthnumber-1];
        $year= date('Y',$this->birthday);
        return $day.' de '.$month.' de '.$year;
    } 
  
    public function __toString(){ // metodo toString
        return  '<p>Nombre: '.$this->name.'</p>
                <p>Fecha de nacimiento: '.$this->dateBirthday().'</p>';
    }
}