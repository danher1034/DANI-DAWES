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
            
            if (isset($_POST['password'])) {
                if (password_verify($_POST['password'], $login_user['contrasenya'])) {
                    $update_user = $conection->prepare('UPDATE users SET usuario = :usuario, email= :email WHERE id = :usuar;');
                    $update_user->bindParam(':usuario', $_POST['user']);
                    $update_user->bindParam(':email', $_POST['mail']);
                    $update_user->bindParam(':usuar', $_SESSION['user']);
                    $update_user->execute();
                    header('Location:/account/header2/1');  
                } else {
                    $errors['password'] = 'Usuario o contraseña incorrecta, intetanlo otra vez';
                }
            }
            echo '<div class="container2">';
                echo '<div class="box form-box">';
                    echo '<form action="#" method="post" enctype="multipart/form-data">';
                        echo '<br>';
                        echo '<div class="field input">';
                        echo '<br> Usuario: <input type="text" name="user" value="' . $user_name['usuario'] . '" " ><br>';
                        echo '</div>';
                        echo '<div class="field input">';
                        echo '<br> Mail: <input type="text" name="mail" value="' . $user_name['email'] . '" " ><br>'; // Los siguiente if se encargan de crear los input para cada apartado                    
                        echo '</div>';
                        echo '<div class="field input">';
                        echo '<br> Contraseña : <input type="password" name="password" required" ><br>';
                        echo '</div>';
                        if (isset($errors['password'])) {
                            echo '<p class="error_login">' . $errors['password'] . '</p><br>';
                        }
                        echo '<br>';
                        echo '<div class="field">';  
                        echo '<input type="submit" class="btn2" value="Enviar">';
                        echo '</div>';
                        echo '<br>';
                        echo '<details>';
                        echo '<summary>Cambiar Contraseña</summary>';
                        echo '<br> Nueva Contraseña : <input type="password" name="newpassword" required" ><br>';
                    echo '</form>';
                echo '</div>';
            echo '</div>';
        ?>
    </article>
</body>

</html>