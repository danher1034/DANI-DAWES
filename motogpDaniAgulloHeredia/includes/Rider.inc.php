<?php
/**
 * @author Dani Agullo Heredia
 * @version 1.0
 */

 class Rider extends Person{
    private $number;


    public function __construct(string $name ,int $birthday,int $number) //contructor del usuario
    {
     parent::__construct($name,$birthday);
     $this->number =$number;
    }

    public function __toString()
    {
        return '<h4>Piloto</h4> '.
            '<p>Nombre: '.$this->name.'</p>'.
            '<p>Dorsal: '.$this->number.'</p>';
            
    }

}