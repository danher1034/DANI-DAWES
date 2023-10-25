<?php
    /**
     * @author Dani Agullo Heredia
     * @version 1.0
     */

$mailAnduserExpression ='/^([a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,4}$)|[A-z]{3,20}/';
$mailAndphoneExpression ='/^([a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,4}$)|([0-9]{9})/';
$nameExpression ='/^[A-z ]{5,50}$/';
$userExpression ='/[A-z0-9 ]{3,20}/';
$passwordExpression ='/^((?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=\S+$)(?=.*[;:\.,!¡\?¿@#\$%\^&\-_+=\(\)\[\]\{\}])).{8,20}$/';
 
if (isset($_POST['mail|phone'])) { //comprueba si el campo existe
    if (strlen($_POST['mail|phone'] > 0)) {
        if (!preg_match($mailAndphoneExpression, $_POST['mail|phone'])) { //comprueba que el correo introducido sea valido
            $errors['mail|phone'] = 'El mail deber serguir el siguiente ***@***.***  y el telefono debe contener 9 digitos ';
        }
    } else {
        $errors['mail|phone'] = 'No se ha introducido ningun dato en el mail ni telefono';
    }
}

if (isset($_POST['user'])) { //comprueba si el campo existe
    if (strlen($_POST['user'] > 0)) {
        if (!preg_match($userExpression, $_POST['user'])) { //comprueba que el usuario introducido sea valido
            $errors['user'] = 'El código debe ser una letra seguida de un guion seguido de 5 dígitos';
        }
    } else {
        $errors['user'] = 'No se ha introducido ningun dato en el código';
    }
}

if (isset($_POST['name'])) { //comprueba si el campo existe
    if (strlen($_POST['name'] > 0)) {
        if (!preg_match($nameExpression, $_POST['name'])) { //comprueba que el nombre introducido sea valido
            $errors['name'] = 'El nombre debe ser solo letras (mínimo 3 y máximo 20)';
        }
    } else {
        $errors['name'] = 'No se ha introducido ningun dato en el nombre';
    }
}

if (isset($_POST['password'])) { //comprueba si el campo existe
    if (strlen($_POST['password'] > 0)) {
        if (!preg_match($passwordExpression, $_POST['password'])) { //comprueba que la fecha introducida sea valida
            $errors['password'] = 'La contraseña debe contener al menos 1 letra mayuscula, un caracter especial ;:\.,!¡\?¿@#\$%\^&\-_+= y un digito';
        }
    } else {
        $errors['password'] = 'No se ha introducido ninguna dato en la contraseña';
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
