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
                    <div class="tittle-delete">
                        <h2>¿ Seguro que quieres eliminar tu cuenta ?</h2>
                    </div>
                    <br>
                    <?php

                    $conection = bdconection($bd, $user, $pass, $options);

                    $login_select = $conection->prepare('SELECT usuario, contrasenya, id from users where usuario=:usuar;');
                    $login_select->bindParam(':usuar', $_POST['user']);

                    if (isset($_POST['user'])) {
                        $login_select->execute();
                        $login_user = $login_select->fetch();
                    }

                    if (isset($_POST['user'])) {
                        if ($login_user !== false && password_verify($_POST['password'], $login_user['contrasenya'])) {
                            $_SESSION['user'] = $login_user['id'];
                            $_SESSION['logged'] = TRUE;
                            header('Location:/index');
                        } else {
                            $errors['user'] = 'Usuario o contraseña incorrecta, intetanlo otra vez';
                        }
                    }

                    echo '<div class="delete-buttons">
                                    <a href="/index/follow" id="delete-button-yes">Confirmar</a>
                                    <a href="/account" id="delete-button-no">Cancelar</a>
                                  </div>';

                    ?>
                </div>
            </div>
        </div>
    </article>
</body>

</html>

<!-- if (isset($_GET['delete'])) {
        $deleted = $conection->exec('DELETE l ,d , c, r FROM revels r LEFT JOIN comments c ON r.id = c.revelid LEFT JOIN dislikes d ON r.id = d.revelid LEFT JOIN likes l ON r.id = l.revelid WHERE r.id =' . $_GET['delete']);
    } -->