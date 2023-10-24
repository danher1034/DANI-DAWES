<?php
/**
 * @author Dani Agullo Heredia
 * @version 1.0
 */

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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Login</title>
</head>
<body class="body-login">
<h2>REVELS</h2>
<h4>Regístrate para ver revels de tus amigos.
</h4>
<form action="#" method="post" enctype="multipart/form-data">
<?php
        if (isset($_POST['user'])) {
            if (count($errors) < 1) {
                header('Location: /index.php');
                exit;
            }
        }
        echo '<br> Mail o Teléfono: <input type="text" name="mail|phone"><br>'; // Los siguiente if se encargan de crear los input para cada apartado
        if (isset($errors['mail|phone'])) {
            echo '<br>' . $errors['mail|phone'] . '<br>';
        }
        echo '<br> Nombre: <input type="text" name="name"><br>';
        if (isset($errors['name'])) {
            echo '<br>' . $errors['name'] . '<br>';
        }
        echo 'Usuario: <input type="text" name="user"><br>';  
        if (isset($errors['user'])) {
            echo '<br>' . $errors['user'] . '<br>';
        }
        echo '<br> Contraseña : <input type="text" name="password"><br>';
        if (isset($errors['password'])) {
            echo '<br>' . $errors['password'] . '<br>';
        }
        echo '<br>';
        echo '<br>';
        echo '<input type="submit" value="Enviar">';
        ?>
</form>
</body>
</html>