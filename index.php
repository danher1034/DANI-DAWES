<?php

/**
 * @author Dani Agullo Heredia
 * @version 1.0
 */

require_once(__DIR__ . '/includes/bdconect.inc.php');
require_once(__DIR__.'/includes/User.inc.php');
require_once(__DIR__.'/includes/regularExpression.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://fonts.cdnfonts.com/css/healing-lighters" rel="stylesheet">
</head>

<body class="body-index">
    <div class="Sign-up" >
        <div class="tittle">
            <img src="img/logo-revels.png" alt="Logo" width="80" height="80">
            <h1>Revels</h1>
        </div>
        <br>
        <h4>Regístrate para ver revels de tus amigos</h4>
        <?php
                echo '<form action="#" method="post" enctype="multipart/form-data">';           
                        if (isset($_POST['user'])) {
                            if (count($errors) < 1) {
                                header('Location: /index.php');
                                exit;
                            }
                        }
                        echo '<br> Mail: <input type="text" name="mail"><br>'; // Los siguiente if se encargan de crear los input para cada apartado
                        if (isset($errors['mail'])) {
                            echo '<p class="error_login">'. $errors['mail'] . '</p><br>';
                        }
                        echo '<br>Usuario: <input type="text" name="user"><br>';  
                        if (isset($errors['user'])) {
                            echo '<p class="error_login">'. $errors['user'] . '</p><br>';
                        }
                        echo '<br> Contraseña : <input type="text" name="password"><br>';
                        if (isset($errors['password'])) {
                            echo '<p class="error_login">'. $errors['password'] . '</p><br>';
                        }
                        echo '<br>';
                        echo '<br>';
                        echo '<input type="submit" value="Enviar">';     
                echo '</form>';
        
        ?>
    </div>
    <div class="Sign-in" >
         <p>¿Tienes cuenta en revels? <a href="login.php">Inicia sesión</a></p>
    </div>
    <footer class="footer">FOOTER</footer>
</body>

</html>