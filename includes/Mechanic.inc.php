<?php
/**
 * @author Dani Agullo Heredia
 * @version 1.0
 */

 class Mechanic extends Person{
    private $speciality;


    public function __construct(string $name ,int $birthday,string $speciality) //contructor del usuario
    {
     parent::__construct($name,$birthday);
     $this->speciality =$speciality;
    }

    public function __toString()
    {
        return '<h4>Mecanico:</h4> '.
            parent::__toString().
            '<p>Especialidad: '.$this->speciality.'</p>';
    }

}