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
require_once(__DIR__ . '/includes/header.inc.php');

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

<body class='body-delete'>
    <article class="main2">
        <div class="container">
            <div class="container">
                <div class="box form-box">
                    <?php
                    $conection = bdconection($bd, $user, $pass, $options);

                    $login_select = $conection->prepare('SELECT usuario, contrasenya, id from users where usuario=:usuar;');
                    $login_select->bindParam(':usuar', $_POST['user']);

                    if (isset($_GET['delet'])) {
                        $deleted = $conection->exec('DELETE c FROM comments c JOIN revels r ON c.revelid = r.id WHERE r.userid ='.$_SESSION['user']);
                        $deleted = $conection->exec('DELETE FROM comments WHERE userid ='.$_SESSION['user']);
                        $deleted = $conection->exec('DELETE FROM dislikes WHERE userid ='.$_SESSION['user']);
                        $deleted = $conection->exec('DELETE FROM likes WHERE userid ='.$_SESSION['user']);
                        $deleted = $conection->exec('DELETE FROM follows WHERE userid ='.$_SESSION['user'].' OR userfollowed ='.$_SESSION['user']);
                        $deleted = $conection->exec('DELETE FROM revels WHERE userid ='.$_SESSION['user']);
                        $deleted = $conection->exec('DELETE FROM users WHERE id ='.$_SESSION['user']);
                        session_destroy();
                        header('Location:/index');
                    }

                    echo '<h2 class="tittle-delete">¿ Seguro que quieres eliminar tu cuenta ?</h2>';
                    echo '<div class="delete-buttons">
                                    <a href="/cancel/delet" id="delete-button-yes">Confirmar</a>
                                    <a href="/account" id="delete-button-no">Cancelar</a>
                            </div>';
                    ?>
                </div>
            </div>
        </div>
    </article>
</body>

</html>
