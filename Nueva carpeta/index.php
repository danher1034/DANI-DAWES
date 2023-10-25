<?php

/**
 * @author Dani Agullo Heredia
 * @version 1.0
 */

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body class="body-index">
    <div class="Sign-up" >
        <h2>REVELS</h2><br>
        <h4>Regístrate para ver revels de tus amigos</h4>
        <?php
                echo '<form action="#" method="post" enctype="multipart/form-data">';           
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
                        echo '<br>Usuario: <input type="text" name="user"><br>';  
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
                echo '</form>';
        
        ?>
    </div>
    <div class="Sign-in" >
         <p>¿Tienes cuenta en revels? <a href="login.php">Inicia sesión</a></p>
    </div>
    <footer class="footer">FOOTER</footer>
</body>

</html>