<?php
    /**
     * @author Dani Agullo Heredia
     * @version 1.0
     */

$mailExpression ='/^([a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,4}$)/';
$nameExpression ='/^[A-z ]{5,50}$/';
$userExpression ='/[A-z0-9 ]{3,20}/';
$passwordExpression ='/^((?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=\S+$)(?=.*[;:\.,!¡\?¿@#\$%\^&\-_+=\(\)\[\]\{\}])).{8,20}$/';
$commentExpression ='/[A-z0-9 ]{1,50}/';
 
$errors = []; 

if (isset($_POST['comment'])) { //comprueba si el campo existe
    if (strlen($_POST['comment'] > 0)) {
        if (!preg_match($commentExpression, $_POST['comment'])) { //comprueba que el usuario introducido sea valido
            $errors['comment'] = 'El comentario debe tener al menos un caracter y máximo 50';
        }
    } else {
        $errors['comment'] = 'No se ha introducido ningun dato en el código';
    }
}

if (isset($_POST['mail'])) { //comprueba si el campo existe
    if (strlen($_POST['mail'] > 0)) {
        if (!preg_match($mailExpression, $_POST['mail'])) { //comprueba que el correo introducido sea valido
            $errors['mail'] = 'El mail deber serguir el siguiente ***@***.***';
        }
    } else {
        $errors['mail'] = 'No se ha introducido ningun dato en el mail ';
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

if (isset($_POST['password'])) { //comprueba si el campo existe
    if (strlen($_POST['password'] > 0)) {
        if (!preg_match($passwordExpression, $_POST['password'])) { //comprueba que la fecha introducida sea valida
            $errors['password'] = 'La contraseña debe contener al menos 1 letra mayuscula, un caracter especial ;:\.,!¡\?¿@#\$%\^&\-_+= y un digito';
        }
    } else {
        $errors['password'] = 'No se ha introducido ninguna dato en la contraseña';
    }
} 
 
