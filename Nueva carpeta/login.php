<?php
/**
 * @author Dani Agullo Heredia
 * @version 1.0
 */
require_once(__DIR__.'/includes/User.inc.php');

$mailAnduserExpression ='/^([a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,4}$)|[A-z]{3,20}/';
$passwordExpression ='/^((?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=\S+$)(?=.*[;:\.,!¡\?¿@#\$%\^&\-_+=\(\)\[\]\{\}])).{8,20}$/';
 
if (isset($_POST['mail|user'])) { //comprueba si el campo existe
    if (strlen($_POST['mail|user'] > 0)) {
        if (!preg_match($mailAnduserExpression, $_POST['mail|user'])) { //comprueba que el correo introducido sea valido
            $errors['mail|user'] = 'El mail deber serguir el siguiente ***@***.*** ';
        }
    } else {
        $errors['mail|user'] = 'No se ha introducido ningun dato en el mail ni usuario';
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
<div class="Sign-in" >
    <h2>REVELS</h2>
    <h4>Regístrate para ver revels de tus amigos.</h4>
    <form action="#" method="post" enctype="multipart/form-data">
        <?php
            if (isset($_POST['mail|user'])) {
                if (count($errors) < 1) {
                    header('Location: /index.php');
                    exit;
                }
            }
            echo '<br> Mail o Usuario: <input type="text" name="mail|user"><br>'; // Los siguiente if se encargan de crear los input para cada apartado
            if (isset($errors['mail|user'])) {
                echo '<br>' . $errors['mail|user'] . '<br>';
            }
            echo '<br> Contraseña : <input type="text" name="password"><br>';
            if (isset($errors['password'])) {
                echo '<br>' . $errors['password'] . '<br>';
            }
            echo '<br>';
            echo '<br>';
            echo '<input type="submit" value="Enviar">';
        ?>
</div>
<div class="Sign-up" >
    <p>¿No tienes cuenta en revels? <a href="login - copia.php">Regístrate</a></p>
</div>
<footer class="footer">FOOTER</footer>

</body>
</html>