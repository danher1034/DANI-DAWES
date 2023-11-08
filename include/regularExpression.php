<?php
    /**
     * @author Dani Agullo Heredia
     * @version 1.0
     */

$nameExpression ='/^[A-z 0-9]{1,50}$/';
$genderExpression ='/^[A-z ]{3,50}$/';
$countryExpression ='/^[A-z ]{5,50}$/';
$dateStartExpression ='/^[0-9]{0,4}$/';
$titleExpression ='/^[A-z 0-9]{1,50}$/';
$yearsExpression ='/^[0-9]{0,4}$/';
$dateBuyExpression ='/[0-9]{4}-[0-9]{2}-[0-9]{2}/';
$priceExpression ='/^[0-9]{0,4}$/';
$durationExpression ='/^[0-9]{0,4}$/';
$positionExpression ='/^[0-9]{0,4}$/';



$errors = []; 

if (isset($_POST['name'])) { //comprueba si el campo existe
    if (strlen($_POST['name'] > 0)) {
        if (!preg_match($nameExpression, $_POST['name'])) { //comprueba que el usuario introducido sea valido
            $errors['name'] = 'El nombre deber tener almenos un caracter y máximo 50';
        }
    } else {
        $errors['name'] = 'No se ha introducido ningun dato en el código';
    }
}

if (isset($_POST['gender'])) { //comprueba si el campo existe
    if (strlen($_POST['gender'] > 0)) {
        if (!preg_match($genderExpression, $_POST['gender'])) { //comprueba que el nombre introducido sea valido
            $errors['gender'] = 'El nombre debe ser solo letras (mínimo 3 y máximo 20)';
        }
    } else {
        $errors['gender'] = 'No se ha introducido ningun dato en el nombre';
    }
}

if (isset($_POST['country'])) { //comprueba si el campo existe
    if (strlen($_POST['country'] > 0)) {
        if (!preg_match($countryExpression, $_POST['country'])) { //comprueba que el usuario introducido sea valido
            $errors['country'] = 'El pais debe contener al menos 5 dígitos';
        }
    } else {
        $errors['country'] = 'No se ha introducido ningun dato en el código';
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

if (isset($_POST['title'])) { //comprueba si el campo existe
    if (strlen($_POST['title'] > 0)) {
        if (!preg_match($titleExpression, $_POST['title'])) { //comprueba que el usuario introducido sea valido
            $errors['title'] = 'El nombre deber tener almenos un caracter y máximo 50';
        }
    } else {
        $errors['title'] = 'No se ha introducido ningun dato en el código';
    }
}

if (isset($_POST['years'])) { //comprueba si el campo existe
    if (strlen($_POST['years'] > 0)) {
        if (!preg_match($yearsExpression, $_POST['years'])) { //comprueba que la fecha introducida sea valida
            $errors['years'] = 'La contraseña debe contener al menos 1 letra mayuscula, un caracter especial ;:\.,!¡\?¿@#\$%\^&\-_+= y un digito';
        }
    } else {
        $errors['years'] = 'No se ha introducido ninguna dato en la contraseña';
    }
}

if (isset($_POST['datebuy'])) { //comprueba si el campo existe
    if (strlen($_POST['datebuy'] > 0)) {
        if (!preg_match($dateBuyExpression, $_POST['datebuy'])) { //comprueba que la fecha introducida sea valida
            $errors['datebuy'] = 'La contraseña debe contener al menos 1 letra mayuscula, un caracter especial ;:\.,!¡\?¿@#\$%\^&\-_+= y un digito';
        }
    } else {
        $errors['datebuy'] = 'No se ha introducido ninguna dato en la contraseña';
    }
} 

if (isset($_POST['price'])) { //comprueba si el campo existe
    if (strlen($_POST['price'] > 0)) {
        if (!preg_match($priceExpression, $_POST['price'])) { //comprueba que el usuario introducido sea valido
            $errors['price'] = 'El nombre deber tener almenos un caracter y máximo 50';
        }
    } else {
        $errors['price'] = 'No se ha introducido ningun dato en el código';
    }
}

if (isset($_POST['duration'])) { //comprueba si el campo existe
    if (strlen($_POST['duration'] > 0)) {
        if (!preg_match($durationExpression, $_POST['duration'])) { //comprueba que el usuario introducido sea valido
            $errors['duration'] = 'El nombre deber tener almenos un caracter y máximo 50';
        }
    } else {
        $errors['duration'] = 'No se ha introducido ningun dato en el código';
    }
}

if (isset($_POST['position'])) { //comprueba si el campo existe
    if (strlen($_POST['position'] > 0)) {
        if (!preg_match($positionExpression, $_POST['position'])) { //comprueba que el usuario introducido sea valido
            $errors['position'] = 'El nombre deber tener almenos un caracter y máximo 50';
        }
    } else {
        $errors['position'] = 'No se ha introducido ningun dato en el código';
    }
}