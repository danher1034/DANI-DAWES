<?php

/**
 * @author Dani Agullo Heredia
 * @version 1.0
 */

/**
 * El siguiente php funciona para comprobar que los campos introducidos en el formulario sigan las siguientes directrices:
 * 
 * Código -> una letra seguida de un guion seguido de 5 dígitos.
 * Nombre -> solo letras (mínimo 3 y máximo 20).
 * Precio -> decimal.
 * Descripción -> alfanumérico (mínimo 50 letras).
 * Fabricante -> alfanumérico (entre 10 y 20 letras).
 * Fecha de adquisición -> fecha.
 * Ningún campo puede estar en blanco.
 */

$names = ["Usuario", "Nombre", "Apellido", "DNI", "Direccion", "Mail", "Teléfono", "Fecha de nacimiento", "Curriculum", "Foto"];
$auxiliary = 0;

$userExpression = '/[A-z0-9 ]{3,20}/';
$nameExpression = '/^[A-z ]{3,20}$/';
$surnameExpression = '/^[A-z ]{3,20}$/';
$dniExpression = '/^[0-9]{8}[A-Z]$/';
$addressExpression = '/[A-z0-9 ]{10,}/';
$mailExpression = '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,4}$/';
$phoneExpression = '/[0-9]{9}/';
$dateExpression = '/[0-9]{2}-[0-9]{2}-[0-9]{4}/';


$errors = [];

if (isset($_POST['user'])) { //comprueba si el campo existe
    if (strlen($_POST['user'] > 0)) {
        if (!preg_match($userExpression, $_POST['user'])) {
            $errors['user'] = 'El código debe ser una letra seguida de un guion seguido de 5 dígitos';
        }
    } else {
        $errors['user'] = 'No se ha introducido ningun dato en el código';
    }
}

if (isset($_POST['name'])) { //comprueba si el campo existe
    if (strlen($_POST['name'] > 0)) {
        if (!preg_match($nameExpression, $_POST['name'])) {
            $errors['name'] = 'El nombre debe ser solo letras (mínimo 3 y máximo 20)';
        }
    } else {
        $errors['name'] = 'No se ha introducido ningun dato en el nombre';
    }
}

if (isset($_POST['surname'])) { //comprueba si el campo existe
    if (strlen($_POST['surname'] > 0)) {
        if (!preg_match($surnameExpression, $_POST['surname'])) {
            $errors['surname'] = 'El precio debe ser decimal.';
        }
    } else {
        $errors['surname'] = 'No se ha introducido ningun dato en el precio';
    }
}

if (isset($_POST['dni'])) { //comprueba si el campo existe
    if (strlen($_POST['dni'] > 0)) {
        if (!preg_match($dniExpression, $_POST['dni'])) {
            $errors['dni'] = 'La descripción debe ser alfanumérica (mínimo 50 letras)';
        }
    } else {
        $errors['dni'] = 'No se ha introducido ningun dato en la descripción';
    }
}

if (isset($_POST['address'])) { //comprueba si el campo existe
    if (strlen($_POST['address'] > 0)) {
        if (!preg_match($addressExpression, $_POST['address'])) {
            $errors['address'] = 'El dirección debe ser alfanumérico (mínimo 10 letras)';
        }
    } else {
        $errors['address'] = 'No se ha introducido ningun dato en la dirección';
    }
}

if (isset($_POST['mail'])) { //comprueba si el campo existe
    if (strlen($_POST['mail'] > 0)) {
        if (!preg_match($mailExpression, $_POST['mail'])) {
            $errors['mail'] = 'El mail deber serguir el siguiente ***@***.*** .';
        }
    } else {
        $errors['mail'] = 'No se ha introducido ningun dato en el mail';
    }
}

if (isset($_POST['phone'])) { //comprueba si el campo existe
    if (strlen($_POST['phone'] > 0)) {
        if (!preg_match($phoneExpression, $_POST['phone'])) {
            $errors['phone'] = 'El telefono debe contener 9 digitos.';
        }
    } else {
        $errors['phone'] = 'No se ha introducido ningun dato en el telefono';
    }
}

if (isset($_POST['date'])) { //comprueba si el campo existe
    if (strlen($_POST['date'] > 0)) {
        if (!preg_match($dateExpression, $_POST['date'])) {
            $errors['date'] = 'La fecha tiene que seguir el siguiente modelo 00-00-0000.';
        }
    } else {
        $errors['date'] = 'No se ha introducido ningun dato en la fecha';
    }
}

if (!empty($_POST['curriculum'])) { //comprueba si el campo existe
    if ($_FILES['curriculum']['error'] != UPLOAD_ERR_OK) {
        if ($_FILES['curriculum']['type'] != 'application/pdf') {
            $errors['curriculum'] = 'Tiene que ser un archivo pdf';
        } else {
            if (is_uploaded_file($_FILES['curriculum']['tmp_name']) == true) {
                $newroute = __DIR__.'/cvs/'. $_POST['dni'].'-'.$_POST['name'].'-'.$_POST['surname'].'.pdf';
                if(is_file($newroute)==true){
                    echo 'Ya existe un archivo con tu nombre';
                }
                if(!move_uploaded_file($_FILES['curriculum']['tmp_name'],$newroute)){
                    echo 'No se ha podido mover el fichero correctamente';
                }
            }else{
                echo 'Ataque potencial notificado a la policia';
            }
        }
    } else {
        $errors['curriculum'] = 'No se ha introducido ningun archivo';
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
        echo 'Usuario: <input type="text" name="user">';
        if (isset($errors['user'])) {
            echo '<br>' . $errors['user'] . '<br>';
        }
        echo '<br> Nombre: <input type="text" name="name">';
        if (isset($errors['name'])) {
            echo '<br>' . $errors['name'] . '<br>';
        }
        echo '<br> Apellido: <input type="text" name="surname">';
        if (isset($errors['surname'])) {
            echo '<br>' . $errors['surname'] . '<br>';
        }
        echo '<br> Dni: <input type="text" name="dni">';
        if (isset($errors['dni'])) {
            echo '<br>' . $errors['dni'] . '<br>';
        }
        echo '<br> Dirección: <input type="text" name="address">';
        if (isset($errors['address'])) {
            echo '<br>' . $errors['address'] . '<br>';
        }
        echo '<br> Mail: <input type="text" name="mail">';
        if (isset($errors['mail'])) {
            echo '<br>' . $errors['mail'] . '<br>';
        }
        echo '<br> Teléfono: <input type="text" name="phone">';
        if (isset($errors['phone'])) {
            echo '<br>' . $errors['phone'] . '<br>';
        }
        echo '<br> Fecha: <input type="text" name="date">';
        if (isset($errors['date'])) {
            echo '<br>' . $errors['date'] . '<br>';
        }
        echo '<br> Curriculum (Formato .pdf): <input type="file" name="curriculum">';
        if (isset($errors['curriculum'])) {
            echo '<br>' . $errors['curriculum'] . '<br>';
        }
        echo '<br>';
        echo '<br>';
        echo '<input type="submit" value="Enviar">';
        ?>
    </form>


</body>

</html>