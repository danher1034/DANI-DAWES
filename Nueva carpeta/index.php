<?php

/**
 * @author Dani Agullo Heredia
 * @version 1.0
 */

require_once(__DIR__ . '/includes/bdconect.inc.php');
require_once(__DIR__.'/includes/User.inc.php');
require_once(__DIR__.'/includes/regularExpression.php');

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
    <title>Document</title>
    <link rel="stylesheet" href="/css/styles.css">
    <link href="https://fonts.cdnfonts.com/css/healing-lighters" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<?php if (isset($_POST['usuario'])){ ?>
    <body class="body-index">
    <div class="Sign-up" >
        <div class="tittle">
            <img src="img/logo-revels.png" alt="Logo" width="80" height="80">
            <h1>Revels</h1>
        </div>
        <br>
        <h4>Regístrate para ver revels de tus amigos</h4>
        <?php
                if (isset($_POST['position'])) {
                    
                }else{
                echo '<form action="#" method="post" enctype="multipart/form-data">';           
                        if (isset($_POST['user'])) {
                            if (count($errors) < 1) {
                                header('Location: /index.php');
                                exit;
                            }
                        }
                        echo '<br> Mail: <input type="text" name="mail"><br>'; // Los siguiente if se encargan de crear los input para cada apartado
                        if (isset($errors['mail'])) {
                            echo '<p class="error_login">'. $errors['mail'] . '</p><br>';
                        }
                        echo '<br>Usuario: <input type="text" name="user"><br>';  
                        if (isset($errors['user'])) {
                            echo '<p class="error_login">'. $errors['user'] . '</p><br>';
                        }
                        echo '<br> Contraseña : <input type="text" name="password"><br>';
                        if (isset($errors['password'])) {
                            echo '<p class="error_login">'. $errors['password'] . '</p><br>';
                        }
                        echo '<br>';
                        echo '<br>';
                        echo '<input type="submit" value="Enviar">';     
                echo '</form>';

                
            }
        
        ?>
    </div>
    <div class="Sign-in" >
         <p>¿Tienes cuenta en revels? <a href="login.php">Inicia sesión</a></p>
    </div>
    <footer class="footer">FOOTER</footer>
    </body>
    <?php }else{ ?>
        <body class="body-index2">
            <nav class="navbar">
                <a class="navbar-brand" href="/index.php">
                    <img src="/img/logo-revels.png" alt="Logo" width="55" height="50">
                </a>
                <h1>Revels</h1>
                <?php
                    $conection = bdconection($bd, $user, $pass, $options);
                    
                    $user_search = $conection->prepare('SELECT id from users where usuario=:usuar ;');
                    $user_search->bindParam(':usuar', $_POST['users']);

                    if(isset($_POST['users'])){
                        $user_search->execute();
                        $userSearch = $user_search->fetch();
                        header('Location: /user/'.$userSearch['id'].'');
                    }
                    


                    echo '<form action="#" class="nav_form" method="post" class="coment_form" enctype="multipart/form-data">
                            <input class="input-nav" name="users" type="text" placeholder="Buscar...">
                            <button class="button-nav" type="submit" id="comment"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </form>';
                ?>
            </nav>
            <aside class="sidebar">
                
            </aside>
            <article class="main">
                <?php         
                    $revels_info = $conection->prepare('SELECT r.texto, r.fecha, r.id,r.userid,(SELECT u.usuario from users u where u.id = r.userid) AS users, (SELECT count(*) from likes l where r.id = l.revelid) AS liked, (SELECT count(*) from dislikes d where r.id = d.revelid) AS disliked, (SELECT count(*) from comments c where r.id = c.revelid) AS comments FROM revels r WHERE r.userid=:id_user OR r.userid IN (SELECT userfollowed FROM follows WHERE userid = :id_user) ORDER BY r.fecha DESC;');
                    $revels_info->bindParam(':id_user', $_GET['id']);
                    $revels_info->execute();
                    
                    $revels = $revels_info->fetchAll();

                    foreach ($revels as $info) {
                        echo '<div class="container-main-user"> 
                        <div class="title-main-user">
                            <a href="/user/'.$info['userid'].'" id="enlace_userRevel">
                                <h3>'.$info['users'].'</h3>
                            </a>    
                        </div>
                        <div class="body-main-user">
                            <a href="/revel/'.$info['id'].'" id="enlace_userRevel">
                                 <p>'.$info['texto'].'</p>
                            </a>
                        </div>
                        <div class="buttons-main-user">
                            <a href="/index/insert/' . $info['id'] . '"><i class="fa-regular fa-heart"></i></a><p>'.$info['liked'].'</p>
                            <a href="/index/insert/' . $info['id'] . '"><i class="fa-solid fa-heart-crack"></i></a><p>'.$info['disliked'].'</p>
                            <a href="/index/insert/' . $info['id'] . '"><i class="fa-regular fa-comment-dots"></i></a><p>'.$info['comments'].'</p>
                        </div>
                        </div>
                        <hr>';

                    }
                
                ?>
            </article>
            <footer class="footer">FOOTER</footer>
        </body>
    <?php } ?>
</html>