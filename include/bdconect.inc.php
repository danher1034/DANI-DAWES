<?php

/**
 * @author Dani Agullo Heredia
 * @version 1.0
 */

function bdconection($bd,$user,$pass,$options){
    $dsn='mysql:host=localhost;dbname='.$bd;
    try{
        return new PDO($dsn,$user,$pass,$options);
    }catch (PDOException $e){
        return 'Fallo de conexión: '.$e->getMessage();
    }

}