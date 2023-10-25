<?php
/**
 * @author Dani Agullo Heredia
 * @version 1.0
 */

class User{
    private $id;
    private $name;
    private $surname1;
    private $surname2;
    private $email;
    private $birthday;
    private $phone;


    public function __construct($id ,$email ,$name ,$surname1=' ' ,$surname2=' ' ,$birthday=' ',$phone=0) //contructor del usuario
    {
     $this->id =$id;
     $this->name =$name;
     $this->surname1 =$surname1;
     $this->surname2 =$surname2;
     $this->email =$email;
     $this->birthday =$birthday;
     $this->phone =$phone;
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

    private function yearsUser(){ //funcion para sacar la edad del usuario
        return date('Y',time())-date('Y',time()-$this->birthday);
    } 

    private function dateBirthday(){//funcion para sacar la fecha de nacimiento del usuario
        $months = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre']; // array para los meses en español
        $day = date('d',$this->birthday);
        $monthnumber = date('n',$this->birthday);
        $month = $months[$monthnumber-1];
        $year= date('y',$this->birthday);
        return $day.' de '.$month.' de '.$year;
    } 
  
    public function __toString(){ // metodo toString
        return '<article class="css_user">
                    <h1>'.$this->name.' '.$this->surname1.' '.$this->surname2.' ('.$this->id.')</h1>                 
                        <div> 
                            <p>'.$this->yearsUser().' años - '.$this->dateBirthday().'</p> 
                            <p>Email: <a href="#">'.$this->email.'</a></p>
                            <p>Teléfono : '.$this->phone.'</p>        
                        </div>                   
                </article>';
    }
}