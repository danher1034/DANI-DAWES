<?php

/**
 * @author Dani Agullo Heredia
 * @version 1.0
 */

/**
 * El siguiente php funciona para comprobar los datos de un candidato para una oferta de trabajo (usuario, nombre, apellidos, DNI, dirección, mail, teléfono, fecha de nacimiento)
 * También almacenara su curriculum (pdf) y foto (png) y asiganara el nombre segun los datos introducidos
 * 
 * 
 */

$userExpression = '/[A-z0-9 ]{3,20}/';
$nameExpression = '/^[A-z ]{3,20}$/';
$surnameExpression = '/^[A-z ]{3,20}$/';
$dniExpression = '/^[0-9]{8}[A-Z]$/';
$addressExpression = '/[A-z0-9 ]{10,}/';
$mailExpression = '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,4}$/';
$phoneExpression = '/[0-9]{9}/';
$dateExpression = '/[0-9]{2}-[0-9]{2}-[0-9]{4}/';


$apellido_parts = explode(' ', $_POST['surname']);
$primer_apellido = $apellido_parts[0];


$errors = [];

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

if (isset($_POST['surname'])) { //comprueba si el campo existe
    if (strlen($_POST['surname'] > 0)) {
        if (!preg_match($surnameExpression, $_POST['surname'])) { //comprueba que los apellidos introducidos sean validos
            $errors['surname'] = 'El precio debe ser decimal.';
        }
    } else {
        $errors['surname'] = 'No se ha introducido ningun dato en el precio';
    }
}

if (isset($_POST['dni'])) { //comprueba si el campo existe
    if (strlen($_POST['dni'] > 0)) {
        if (!preg_match($dniExpression, $_POST['dni'])) { //comprueba que el dni introducido sea valido
            $errors['dni'] = 'La descripción debe ser alfanumérica (mínimo 50 letras)';
        }
    } else {
        $errors['dni'] = 'No se ha introducido ningun dato en la descripción';
    }
}

if (isset($_POST['address'])) { //comprueba si el campo existe
    if (strlen($_POST['address'] > 0)) {
        if (!preg_match($addressExpression, $_POST['address'])) { //comprueba que la dirección introducida sea valida
            $errors['address'] = 'El dirección debe ser alfanumérico (mínimo 10 letras)';
        }
    } else {
        $errors['address'] = 'No se ha introducido ningun dato en la dirección';
    }
}

if (isset($_POST['mail'])) { //comprueba si el campo existe
    if (strlen($_POST['mail'] > 0)) {
        if (!preg_match($mailExpression, $_POST['mail'])) { //comprueba que el correo introducido sea valido
            $errors['mail'] = 'El mail deber serguir el siguiente ***@***.*** .';
        }
    } else {
        $errors['mail'] = 'No se ha introducido ningun dato en el mail';
    }
}

if (isset($_POST['phone'])) { //comprueba si el campo existe
    if (strlen($_POST['phone'] > 0)) {
        if (!preg_match($phoneExpression, $_POST['phone'])) { //comprueba que el telefono introducido sea valido
            $errors['phone'] = 'El telefono debe contener 9 digitos.';
        }
    } else {
        $errors['phone'] = 'No se ha introducido ningun dato en el telefono';
    }
}

if (isset($_POST['date'])) { //comprueba si el campo existe
    if (strlen($_POST['date'] > 0)) {
        if (!preg_match($dateExpression, $_POST['date'])) { //comprueba que la fecha introducida sea valida
            $errors['date'] = 'La fecha tiene que seguir el siguiente modelo 00-00-0000.';
        }
    } else {
        $errors['date'] = 'No se ha introducido ningun dato en la fecha';
    }
}

if (isset($_FILES['curriculum'])) { //comprueba si el campo existe
    if ($_FILES['curriculum']['error'] != UPLOAD_ERR_OK) { // comprueba si el curriculum sea ha introducido
        $errors['curriculum'] = 'No se ha introducido ningun archivo';

        switch ($_FILES['photo']['error']) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $errors['curriculum'] =  'El fichero es demasiado grande.'; break;
            case UPLOAD_ERR_PARTIAL:
                $errors['curriculum'] = 'El fichero nos se ha podido subir entero.'; break;
            case UPLOAD_ERR_NO_FILE:
                $errors['curriculum'] =  'No se ha podido subir el fichero.'; break;
            default:
                $errors['curriculum'] =  'Error indeterminado.';
        }
    } else if ($_FILES['curriculum']['type'] != 'application/pdf') { // comprueba que sea del tipo adecuado
        $errors['curriculum'] = 'Tiene que ser un archivo pdf';
    } else if (is_uploaded_file($_FILES['curriculum']['tmp_name']) == true) { //
        $CVnewroute = __DIR__ . '/cvs/' . $_POST['dni'] . '-' . $_POST['name'] . '-' . $primer_apellido . '.pdf';
        if (is_file($CVnewroute) == true) {
            $errors['curriculum'] = 'Ya existe un archivo con tu nombre';
        }
        if (!move_uploaded_file($_FILES['curriculum']['tmp_name'], $CVnewroute)) {
            $errors['curriculum'] = 'No se ha podido mover el fichero correctamente';
        }
    } else {
        $errors['curriculum'] = 'Ataque potencial notificado a la policia';
    }
}

if (isset($_FILES['photo'])) { //comprueba si el campo existe
    if ($_FILES['photo']['error'] != UPLOAD_ERR_OK) {
        $errors['photo'] = 'No se ha introducido ninguna foto';
        unlink($CVnewroute);
        switch ($_FILES['photo']['error']) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $errors['photo'] =  'La foto es demasiado grande.'; break;
                unlink($CVnewroute);
            case UPLOAD_ERR_PARTIAL:
                $errors['photo'] = 'La foto nos se ha podido subir entero.'; break;
                unlink($CVnewroute);
            case UPLOAD_ERR_NO_FILE:
                $errors['photo'] =  'No se ha podido subir la foto.'; break;
                unlink($CVnewroute);
            default:
                $errors['photo'] =  'Error indeterminado.';
                unlink($CVnewroute);
        }
    } else if ($_FILES['photo']['type'] != 'image/png') {
        $errors['photo'] = 'Tiene que ser un archivo png';
        unlink($CVnewroute);
    } else if (is_uploaded_file($_FILES['photo']['tmp_name']) == true) {
        $Photonewroute = __DIR__ . '/candidates/' . $_POST['dni']. '.png';
        if (is_file($Photonewroute) == true) {
            $errors['photo'] = 'Ya existe una foto con tu dni';
            unlink($CVnewroute);
        }
        if (!move_uploaded_file($_FILES['photo']['tmp_name'], $Photonewroute)) {
            $errors['photo'] = 'No se ha podido mover la foto correctamente';
            unlink($CVnewroute);
        }
    } else {
        $errors['photo'] = 'Ataque potencial notificado a la policia';
        unlink($CVnewroute);
    }
}




?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply</title>
</head>

<body>
    <br>
    <form action="#" method="post" enctype="multipart/form-data">
        <?php
        if (isset($_POST['user'])) {
            if (count($errors) < 1) {
                echo '<h2>Todo correcto</h2>';
                exit;
            }
        }
        echo 'Usuario: <input type="text" name="user"><br>';
        if (isset($errors['user'])) {
            echo '<br>' . $errors['user'] . '<br>';
        }
        echo '<br> Nombre: <input type="text" name="name"><br>';
        if (isset($errors['name'])) {
            echo '<br>' . $errors['name'] . '<br>';
        }
        echo '<br> Apellido: <input type="text" name="surname"><br>';
        if (isset($errors['surname'])) {
            echo '<br>' . $errors['surname'] . '<br>';
        }
        echo '<br> Dni: <input type="text" name="dni"><br>';
        if (isset($errors['dni'])) {
            echo '<br>' . $errors['dni'] . '<br>';
        }
        echo '<br> Dirección: <input type="text" name="address"><br>';
        if (isset($errors['address'])) {
            echo '<br>' . $errors['address'] . '<br>';
        }
        echo '<br> Mail: <input type="text" name="mail"><br>';
        if (isset($errors['mail'])) {
            echo '<br>' . $errors['mail'] . '<br>';
        }
        echo '<br> Teléfono: <input type="text" name="phone"><br>';
        if (isset($errors['phone'])) {
            echo '<br>' . $errors['phone'] . '<br>';
        }
        echo '<br> Fecha: <input type="text" name="date"><br>';
        if (isset($errors['date'])) {
            echo '<br>' . $errors['date'] . '<br>';
        }
        echo '<br> Curriculum (Formato .pdf): <input type="file" name="curriculum"><br>';
        if (isset($errors['curriculum'])) {
            echo '<br>' . $errors['curriculum'] . '<br>';
        }
        echo '<br> photo (Formato .png): <input type="file" name="photo"><br>';
        if (isset($errors['photo'])) {
            echo '<br>' . $errors['photo'] . '<br>';
        }
        echo '<br>';
        echo '<br>';
        echo '<input type="submit" value="Enviar">';
        ?>
    </form>


</body>

</html>