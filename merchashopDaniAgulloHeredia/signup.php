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
    <title>Document</title>
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://fonts.cdnfonts.com/css/healing-lighters" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<?php if (!isset($_SESSION['logged'])){ ?>
    <body class='loginup'>
        <div class="container">
            <div class="box form-box">
                <div class="tittle-login">
                        <h1>Regístrate en Merchshop</h1>
                    </div>
                <div class="Sign-up" >
                    <br>
                    <?php              

                            if(isset($_POST['user'])){

                                $password=$_POST['password'];
                                $encriptedPassword=password_hash($password,PASSWORD_DEFAULT);
                               
                                $user='customer';

                                $add_user = $connection->prepare('INSERT INTO users (user, password, email, rol) VALUES (:user, :passwords, :email, :rol );');
                                $add_user->bindParam(':user', $_POST['user']);
                                $add_user->bindParam(':email', $_POST['mail']);
                                $add_user->bindParam(':passwords', $encriptedPassword);
                                $add_user->bindParam(':rol', $user);

                                if (isset($_POST['user'])) {
                                    $add_user->execute();
                                    header('Location:/login');
                                    exit;
                                }
                            }
                    
                    ?>
                </div>
            </div>
        </div>
    </body>
    <?php }else{ }?>