<?php

/**
 * @author Dani Agullo Heredia
 * @version 1.0
 */
    require_once('../includes/bdconect.inc.php');
    session_start();
    $bd = 'revels';
    $user = 'revel';
    $pass = 'lever';
    $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
    $conection = bdconection($bd, $user, $pass, $options);
    
    require_once('../includes/regularExpression.php');
    require_once(__DIR__.'/includes/header.inc.php');  
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/css/styles.css">
    <link href="https://fonts.cdnfonts.com/css/healing-lighters" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="body-account">
    <article class="main2">
        <?php
            $login_select = $conection->prepare('SELECT contrasenya from users where id=:usuar;');
            $login_select->bindParam(':usuar', $_SESSION['user']);                    

            $login_select->execute();
            $login_user = $login_select->fetch();

            $login_user['contrasenya'];

            if(isset($_POST['user'])){
                $_SESSION['user_edit'] = $_POST['user'];
                $_SESSION['mail_edit'] = $_POST['mail'];
            }

            if (isset($_POST['password'])) {
                if (password_verify($_POST['password'], $login_user['contrasenya'])) {
                    $update_user = $conection->prepare('UPDATE users SET usuario = :usuario, email= :email WHERE id = :usuar;');
                    $update_user->bindParam(':usuario', $_SESSION['user_edit']);
                    $update_user->bindParam(':email', $_SESSION['mail_edit']);
                    $update_user->bindParam(':usuar', $_SESSION['user']);
                    $update_user->execute();
                    unset($_SESSION['mail_edit']);
                    unset($_SESSION['user_edit']);
                    header('Location:/account');   
                } else {
                    $errors['password'] = 'Contraseña incorrecta, intetanlo otra vez';
                }
            }

            if (isset($_POST['password_confirm'])) {
                if (password_verify($_POST['password_confirm'], $login_user['contrasenya'])) {
                    if ($_POST['password2']==$_POST['password3']) {
                        $password=$_POST['password2'];
                        $encriptedPassword=password_hash($password,PASSWORD_DEFAULT);

                        $update_user = $conection->prepare('UPDATE users SET contrasenya = :passwords WHERE id = :usuar;');
                        $update_user->bindParam(':passwords', $encriptedPassword);
                        $update_user->bindParam(':usuar', $_SESSION['user']);
                        $update_user->execute();
                        header('Location:/account');  
                    }else{
                        $errors['password2'] = 'Las nuevas contraseñas no coinciden';
                    } 
                } else {
                    $errors['password2'] = 'Contraseña incorrecta, intetanlo otra vez';
                }
            }

            echo '<div class="container2">';
                echo '<div class="box form-box">';
                if(isset($_GET['newpassword'])){
                    echo '<h2 id="tittle_edit">Cambiar contraseña</h2>';
                    echo '<form action="#" method="post" enctype="multipart/form-data">';
                            echo '<br>';
                            echo '<div class="field input">';
                            echo '<br> <label for="password2">Nueva contraseña :</label> <input type="password" name="password2" id="password2" required" ><br>';
                            echo '</div>';
                            echo '<div class="field input">';
                            echo '<br> <label for="password3">Confirmar contraseña :</label> <input type="password" name="password3" id="password3" required" ><br>';
                            echo '</div>';
                            echo '<div class="field input">';
                            echo '<br> <label for="password">Contraseña actual :</label> <input type="password" name="password_confirm" id="password" required" ><br>';
                            echo '</div>';
                            if (isset($errors['password2'])) {
                                echo '<p class="error_login">' . $errors['password2'] . '</p><br>';
                            }
                            echo '<br>';
                            echo '<div class="field">';  
                            echo '<input type="submit" class="btn2" value="Enviar">';
                            echo '</div>';
                    echo '</form>';
                }else{
                if(isset($_POST['user'])){
                    echo '<h2 id="tittle_edit">Escribe tu contraseña para completar al modificación</h2>';
                    echo '<form action="#" method="post" enctype="multipart/form-data">';
                            echo '<br>';
                            echo '<div class="field input">';
                            echo '<br> <label for="password">Contraseña :</label> <input type="password" name="password" id="password" required" ><br>';
                            echo '</div>';
                            echo '<br>';
                            echo '<div class="field">';  
                            echo '<input type="submit" class="btn2" value="Enviar">';
                            echo '</div>';
                    echo '</form>';

                }else{
                    echo '<h2 id="tittle_edit">Editar usiario</h2>';
                        echo '<form action="#" method="post" enctype="multipart/form-data">';
                            echo '<br>';
                            echo '<div class="field input">';
                            if (isset($errors['password'])) {
                                echo '<p class="error_login">' . $errors['password'] . '</p><br>';
                            }
                            echo '<br> <label for="user">Usuario: </label> <input type="text" name="user" id="user" value="' . $user_name['usuario'] . '" " ><br>';
                            echo '</div>';
                            echo '<div class="field input">';
                            echo '<br> <label for="mail">Mail: </label> <input type="text" name="mail" id="mail" value="' . $user_name['email'] . '" " ><br>'; // Los siguiente if se encargan de crear los input para cada apartado                    
                            echo '</div>';
                            echo '<br>';
                            echo '<div class="field">';  
                            echo '<input type="submit" class="btn2" value="Enviar">';
                            echo '</div>';
                        echo '</form>';
                        echo '<div class="field">';
                            echo '<a id="btn-newpassword" href="/account/newpassword">Nueva Contraseña</a>';
                        echo '</div>';
                }
            }
                echo '</div>';
            echo '</div>';
        ?>
    </article>
</body>

</html>