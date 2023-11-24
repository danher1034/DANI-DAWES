<?php
/**
 * @author Dani Agullo Heredia
 * @version 1.0
 */
require_once(__DIR__ . '/includes/dbconnection.inc.php');
        session_start();
        $connection = getDBConnection();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/style.css">
        <link href="https://fonts.cdnfonts.com/css/healing-lighters" rel="stylesheet">
        <title>Login</title>
    </head>
    <body class='loginup'>
    <div class="container">
            <div class="box form-box">
                <div class="tittle-login">
                    <h1>Inicia sesion</h1>
                </div>
                <div class="Sign-in" >
                    <br>    
                        <?php

                            $login_select = $connection->prepare('SELECT user,rol, password from users where user=:usuar or email=:usuar;');
                            $login_select->bindParam(':usuar', $_POST['user']);              
 

                            if(isset($_POST['user'])){
                                $login_select->execute();
                                $login_user = $login_select->fetch();
                            }              
                
                            if(isset($_POST['user'])){
                                if($login_user !== false && password_verify($_POST['password'], $login_user['password']) ){
                                    if(isset($_POST['auto_login'])){
                                        setcookie('accept', $_POST['auto_login'], httponly: true);
                                        header('location:/index.php');
                                        exit;
                                    } 
                                    $token=bin2hex(random_bytes(90));

                                    $add_user = $connection->prepare('INSERT INTO users (user, password, email, rol) VALUES (:user, :passwords, :email, :rol );');
                                    $add_user->bindParam(':user', $_POST['user']);
                                    $add_user->bindParam(':email', $_POST['mail']);
                                    $add_user->bindParam(':token', $token);
                                    
                                    $_SESSION['user']=$login_user['user'];
                                    $_SESSION['logged'] = TRUE;  
                                    $_SESSION['rol'] = $login_user['rol'];
                                    header('Location:/index');
                                }else{
                                    $errors['user'] ='Usuario o contraseña incorrecta, intetanlo otra vez';
                                }
                            }             

                            echo '<form action="#" method="post" enctype="multipart/form-data">';

                                if (isset($errors['user'])) {
                                    echo '<p class="error_login">'. $errors['user'] . '</p><br>';
                                }
                                echo '<br>';
                                echo '<div class="field input">';
                                echo '<br><label for="user">Usuario:</label> <input type="text" name="user" required" ><br>'; // Los siguiente if se encargan de crear los input para cada apartado                      
                                echo '</div>';
                                echo '<div class="field input">';
                                echo '<br> <label for="password">Contraseña :</label><input type="password" name="password" required" ><br>';  
                                echo '</div>';   
                                echo '<div class="field input">';
                                    echo '<input type="checkbox" id="mantener" name="auto_login" value="auto_login">';
                                    echo '<label for="mantener"> Quieres mantener sesión</label><br>';
                                echo '</div>';
                                echo '<div class="field">';                         
                                echo '<input type="submit" class="btn" value="Iniciar sesión">';
                                echo '</div>'; 

                            echo '</form>';
                        ?>     
                </div>
                <br>
                <div class="sign-inup" >
                    <p>¿No tienes cuenta en revels? </p> <a class="btn-session" href="index.php">Regístrate</a>
                </div>  
        </div>
    </div>
    </body>
</html>