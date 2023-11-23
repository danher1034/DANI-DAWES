<?php
/**
 * @author Dani Agullo Heredia
 * @version 1.0
 */
require_once(__DIR__ . '/includes/bdconect.inc.php');
        session_start();
        $bd = 'revels';
        $user = 'revel';
        $pass = 'lever';
        $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/styles.css">
        <link href="https://fonts.cdnfonts.com/css/healing-lighters" rel="stylesheet">
        <title>Login</title>
    </head>
    <body class='loginup'>
    <div class="container">
            <div class="box form-box">
                <div class="tittle-login">
                    <img src="img/logo-revels.png" alt="Logo" width="80" height="80">
                    <h1>Revels</h1>
                </div>
                <div class="Sign-in" >
                    <br>
                    <h4>Inicia sesión para ver revels de tus amigos.</h4>         
                        <?php
                            
                            $conection = bdconection($bd, $user, $pass, $options);

                            $login_select = $conection->prepare('SELECT usuario, contrasenya, id from users where usuario=:usuar;');
                            $login_select->bindParam(':usuar', $_POST['user']);              

                            if(isset($_POST['user'])){
                                $login_select->execute();
                                $login_user = $login_select->fetch();
                            }              
                
                            if(isset($_POST['user'])){
                                if($login_user !== false && password_verify($_POST['password'], $login_user['contrasenya']) ){
                                    $_SESSION['user']=$login_user['id'];
                                    $_SESSION['logged'] = TRUE;  
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
                                echo '<br> Usuario: <input type="text" name="user" required" ><br>'; // Los siguiente if se encargan de crear los input para cada apartado                      
                                echo '</div>';
                                echo '<div class="field input">';
                                echo '<br> Contraseña : <input type="password" name="password" required" ><br>';  
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