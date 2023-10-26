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
    <link rel="stylesheet" href="css/styles.css">
    <title>Login</title>
</head>
<body class="body-login">
    <div class="Sign-in" >
        <h2>REVELS</h2><br>
        <h4>Inicia sesión para ver revels de tus amigos.</h4>
        <form action="#" method="post" enctype="multipart/form-data">
            <?php
                echo '<br> Mail o Usuario: <input type="text" 
                                                  name="mail|user"
                                                  required" >
                                                <br>'; // Los siguiente if se encargan de crear los input para cada apartado
                if (isset($errors['mail|user'])) {
                    echo '<p class="error_login">'.$errors['mail|user'].'</p><br>';
                }
                echo '<br> Contraseña : <input type="password" 
                                               name="password"
                                               required" >
                                            <br>';
                if (isset($errors['password'])) {
                    echo '<p class="error_login">'.$errors['password'].'</p><br>';
                }
                echo '<br>';
                echo '<br>';
                echo '<input type="submit" value="Enviar">';
            ?>
    </div>
<div class="Sign-up" >
    <p>¿No tienes cuenta en revels? <a href="index.php">Regístrate</a></p>
</div>
<footer class="footer">FOOTER</footer>

</body>
</html>