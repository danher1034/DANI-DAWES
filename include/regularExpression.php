<?php
    /**
     * @author Dani Agullo Heredia
     * @version 1.0
     */


$nameExpression ='/^[A-z 0-9]{1,50}$/';
$genderExpression ='/^[A-z ]{3,50}$/';
$countryExpression ='/^[A-z ]{5,50}$/';
$dateStartExpression ='/^[0-9]{0,4}$/';



if (isset($_POST['name'])) { //comprueba si el campo existe
    if (strlen($_POST['name'] > 0)) {
        if (!preg_match($nameExpression, $_POST['name'])) { //comprueba que el usuario introducido sea valido
            $errors['name'] = 'El nombre deber tener almenos un caracter y máximo 50';
        }
    } else {
        $errors['name'] = 'No se ha introducido ningun dato en el código';
    }
}

if (isset($_POST['country'])) { //comprueba si el campo existe
    if (strlen($_POST['country'] > 0)) {
        if (!preg_match($countryExpression, $_POST['country'])) { //comprueba que el usuario introducido sea valido
            $errors['country'] = 'El pais debe ser una letra contener al menos 5 dígitos';
        }
    } else {
        $errors['country'] = 'No se ha introducido ningun dato en el código';
    }
}

if (isset($_POST['gender'])) { //comprueba si el campo existe
    if (strlen($_POST['gernder'] > 0)) {
        if (!preg_match($genderExpression, $_POST['gender'])) { //comprueba que el nombre introducido sea valido
            $errors['gender'] = 'El nombre debe ser solo letras (mínimo 3 y máximo 20)';
        }
    } else {
        $errors['gender'] = 'No se ha introducido ningun dato en el nombre';
    }
}

if (isset($_POST['date'])) { //comprueba si el campo existe
    if (strlen($_POST['date'] > 0)) {
        if (!preg_match($dateStartExpression, $_POST['date'])) { //comprueba que la fecha introducida sea valida
            $errors['date'] = 'La contraseña debe contener al menos 1 letra mayuscula, un caracter especial ;:\.,!¡\?¿@#\$%\^&\-_+= y un digito';
        }
    } else {
        $errors['date'] = 'No se ha introducido ninguna dato en la contraseña';
    }
} 
 
if (isset($_POST['mail|user'])) { //comprueba si el campo existe
    if (strlen($_POST['mail|user'] > 0)) {
        if (!preg_match($mailAnduserExpression, $_POST['mail|user'])) { //comprueba que el correo introducido sea valido
            $errors['mail|user'] = 'El mail deber serguir el siguiente ***@***.*** ';
        }
    } else {
        $errors['mail|user'] = 'No se ha introducido ningun dato en el mail ni usuario';
    }
}
