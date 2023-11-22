<?php

/**
 * @author Dani Agullo Heredia
 * @version 1.0
 */
require_once(__DIR__ . '/includes/bdconect.inc.php');
require_once(__DIR__ . '/includes/regularExpression.php');
session_start();
$bd = 'revels';
$user = 'revel';
$pass = 'lever';
$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
$conection = bdconection($bd, $user, $pass, $options);
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
    <?php
    if (isset($_GET['delete'])) {
        $deleted = $conection->exec('DELETE l ,d , c, r FROM revels r LEFT JOIN comments c ON r.id = c.revelid LEFT JOIN dislikes d ON r.id = d.revelid LEFT JOIN likes l ON r.id = l.revelid WHERE r.id =' . $_GET['delete']);
    }

    require_once(__DIR__ . '/includes/header.inc.php');
    ?>
    <aside class="sidebar-account">
        <?php

        $user_info = $conection->prepare('SELECT u.usuario,u.email, (SELECT count(*) from follows f where u.id = f.userfollowed) AS followers, (SELECT count(*) from follows f where userid=:id_user) AS followed FROM users u WHERE u.id=:id_user;');
        $user_info->bindParam(':id_user', $_SESSION['user']);
        $user_info->execute();

        $amigos_info = $conection->prepare('SELECT usuario,id FROM users WHERE id IN (SELECT userfollowed FROM follows WHERE userid = :id_user)');
        $amigos_info->bindParam(':id_user', $_SESSION['user']);
        $amigos_info->execute();

        $revels_info = $conection->prepare('SELECT LEFT(r.texto, 50) AS texto, r.fecha, r.id, (SELECT count(*) from likes l where r.id = l.revelid) AS liked, (SELECT count(*) from dislikes d where r.id = d.revelid) AS disliked, (SELECT count(*) from comments c where r.id = c.revelid) AS comments FROM revels r WHERE r.userid=:id_user ORDER BY r.fecha DESC;');
        $revels_info->bindParam(':id_user', $_SESSION['user']);
        $revels_info->execute();

        $user_name = $user_info->fetch();

        $revels = $revels_info->fetchAll();

        $amigos = $amigos_info->fetchAll();

        $revels_number = $revels_info->rowCount();

        echo '<h2>' . $user_name['usuario'] . '</h2>';
        echo '<br>';
        echo '<div class="followers">';
        echo '<p class="revels">' . $revels_number . ' revels</p>';
        echo '<p class="follower">' . $user_name['followers'] . ' seguidores</p>';
        echo '<p class="follows">' . $user_name['followed'] . ' seguidos</p>';
        echo '</div>';
        ?>
    </aside>
    <aside class="sidebar-account2">
        <?php
        echo '<h2>Friends</h2>';
        foreach ($amigos as $info) {
            echo '<div class="sidebar-friend">                  
                        <a href="/user/' . $info['id'] . '" id="enlace_userRevel">
                            <h4>' . $info['usuario'] . '</h4>
                        </a>
                     </div>';
        }
        ?>
    </aside>
    <article class="main">
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
                        echo '<input type="submit" class="btn" value="Enviar">';
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