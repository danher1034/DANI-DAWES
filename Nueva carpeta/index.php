<?php

/**
 * @author Dani Agullo Heredia
 * @version 1.0
 */

require_once(__DIR__ . '/includes/bdconect.inc.php');
require_once(__DIR__.'/includes/regularExpression.php');
        session_start();
        $bd = 'revels';
        $user = 'revel'; 
        $pass = 'lever';
        $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
        $date=date("Y-m-d H:i:s");
        $conection = bdconection($bd, $user, $pass, $options); 
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

<?php if (!isset($_SESSION['logged'])){ ?>
    <body class='loginup'>
        <div class="container">
            <div class="box form-box">
                <div class="tittle-login">
                        <img src="img/logo-revels.png" alt="Logo" width="80" height="80">
                        <h1>Revels</h1>
                    </div>
                <div class="Sign-up" >
                    <br>
                    <h4>Regístrate para ver revels de tus amigos</h4>
                    <?php              

                            if(isset($_POST['user'])){

                                $password=$_POST['password'];
                                $encriptedPassword=password_hash($password,PASSWORD_DEFAULT);

                                $add_user = $conection->prepare('INSERT INTO users (usuario, contrasenya, email) VALUES (:user, :passwords, :email);');
                                $add_user->bindParam(':user', $_POST['user']);
                                $add_user->bindParam(':email', $_POST['mail']);
                                $add_user->bindParam(':passwords', $encriptedPassword);

                                if (isset($_POST['user'])) {
                                    $add_user->execute();
                                    header('Location:/login');
                                    exit;
                                }
                            }

                            echo '<form action="#" method="post" enctype="multipart/form-data">';           
                                    if (isset($_POST['user'])) {
                                        if (count($errors) < 1) {
                                            header('Location:/index');
                                            exit;
                                        }
                                    }

                                    echo '<div class="field input">';
                                    echo '<br> Mail: <input type="text" name="mail"><br>'; // Los siguiente if se encargan de crear los input para cada apartado
                                    if (isset($errors['mail'])) {
                                        echo '<p class="error_login">'. $errors['mail'] . '</p><br>';
                                    }
                                    echo '</div>';

                                    echo '<div class="field input">';
                                    echo '<br>Usuario: <input type="text" name="user"><br>';  
                                    if (isset($errors['user'])) {
                                        echo '<p class="error_login">'. $errors['user'] . '</p><br>';
                                    }
                                    echo '</div>';

                                    echo '<div class="field input">';
                                    echo '<br> Contraseña : <input type="text" name="password"><br>';
                                    if (isset($errors['password'])) {
                                        echo '<p class="error_login">'. $errors['password'] . '</p><br>';
                                    }
                                    echo '</div>';

                                    echo '<div class="field">';
                                    echo '<input type="submit" class="btn" value="Registrarse">';   
                                    echo '</div>';  
                            echo '</form>';
                    
                    ?>
                </div>
                <br>
                <div class="sign-inup" >
                    <p>¿Tienes cuenta en revels?</p>
                    <a href="login.php" class="btn-session">Inicia sesión</a>
                </div>
            </div>
        </div>
    </body>
    <?php }else{ ?>
        <body class="body-index2">  
            
            <?php require_once(__DIR__ .'/includes/header.inc.php') ?>
            
            <aside class="sidebar">
                <h4 id="title_sidebarindex">Sugerencias para ti:</h4>
                <?php
                    $suggestions_info = $conection->prepare('SELECT usuario,id FROM users WHERE id NOT IN (SELECT userfollowed FROM follows WHERE userid = :id_user)and id != :id_user ORDER BY RAND() LIMIT 4;');
                    $suggestions_info->bindParam(':id_user', $_SESSION['user']);
                    $suggestions_info->execute();

                    $suggestions = $suggestions_info->fetchAll();

                    if(isset($_GET['follow'])){
                        $add_follow = $conection->prepare('INSERT INTO follows (userid, userfollowed) VALUES (:iduser, :iduserfollowed);');
                        $add_follow->bindParam(':iduserfollowed', $_GET['follow']);
                        $add_follow->bindParam(':iduser', $_SESSION['user']);

                        if (isset($_GET['follow'])) {
                            $add_follow->execute();
                            header('Location:/index');
                            exit;
                        }
                    }

                    foreach ($suggestions as $info) {
                        echo '<div class="sidebar-suggestions">                  
                                <a href="/user/'.$info['id'].'" id="enlace_userRevel">
                                    <h4>'.$info['usuario'].'</h4>
                                </a>
                                <a href="/index/follow/'.$info['id'].'" id="seguir_user">Seguir</a>
                            </div>';
                    }
                ?>
            </aside>
            <article class="main">
                <?php       
                    require_once(__DIR__ . '/includes/likes_dislikes.inc.php');  
                    $revels_info = $conection->prepare('SELECT r.texto, r.fecha, r.id,r.userid,(SELECT u.usuario from users u where u.id = r.userid) AS users, (SELECT count(*) from likes l where r.id = l.revelid) AS liked, (SELECT count(*) from likes l where r.id = l.revelid and l.userid=:id_user) AS userlikes , (SELECT count(*) from dislikes d where r.id = d.revelid) AS disliked,(SELECT count(*) from dislikes d where r.id = d.revelid and d.userid=:id_user) AS userdislikes, (SELECT count(*) from comments c where r.id = c.revelid) AS comments FROM revels r WHERE r.userid = :id_user or r.userid IN (SELECT userfollowed FROM follows WHERE userid = :id_user) ORDER BY r.fecha DESC;');
                    $revels_info->bindParam(':id_user', $_SESSION['user']);
                    $revels_info->execute();
            
                    $revels = $revels_info->fetchAll();

                    if(count($revels)===0){
                        echo '<br>';
                        echo '<br>';
                        echo '<br>';
                        echo '<br>';
                        echo '<h2 class="text_nologin">Aún no tienes amigos en revels a que esperas,empieza a agregar a gente para poder ver sus revels</h2>';
                    }else{

                    $select_like = $conection->prepare('SELECT userid FROM likes WHERE userid=:iduser and revelid=:idrevel;');
                    $select_like->bindParam(':idrevel', $_GET['like']);
                    $select_like->bindParam(':iduser', $_SESSION['user']);
                    $select_like->execute();

                    $select_dislike = $conection->prepare('SELECT userid FROM dislikes WHERE userid=:iduser and revelid=:idrevel;');
                    $select_dislike->bindParam(':idrevel', $_GET['dislike']);
                    $select_dislike->bindParam(':iduser', $_SESSION['user']);
                    $select_dislike->execute();


                    if(isset($_POST['newrevel'])){
                        $newrevels = $conection->prepare('INSERT INTO revels (userid,texto,fecha) VALUES (:userid,:texts,:dates);');
                            $newrevels->bindParam(':userid',$_SESSION['user']);
                            $newrevels->bindParam(':texts',$_POST['newrevel']);
                            $newrevels->bindParam(':dates',$date);
                    }

                    if (isset($_POST['newrevel'])) {
                        if (count($errors) < 1) {
                            $newrevels->execute();
                            header('Location: /index');
                            exit;
                        }
                    }

                    echo '<div class="newrevel-container">
                                    <div class="title-main-user">
                                        <h3>'.$account_user['usuario'].'</h3>
                                    </div>
                                    <div class="body-main-user">
                                        <form action="#" method="post" class="revel_form" enctype="multipart/form-data">
                                            <input type="text" name="newrevel" id="input-newrevel" placeholder="Añade un nuevo revel...">
                                            <input type="submit" id="newrevels" value="Enviar">';
                                            if (isset($errors['newrevel'])) {
                                                echo '<p class="error_coment">'. $errors['newrevel'] . '</p><br>';
                                            }
                                        echo '</form>
                                    </div>
                            </div>
                            
                            <hr>';

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
                            <div class="buttons-main-user">';
                                if($info['userlikes']==0){
                                    $classLikes="fa-regular fa-thumbs-up";
                                }else{
                                    $classLikes="fa-solid fa-thumbs-up";
                                }
                                if($info['userdislikes']==0){
                                    $classDislikes="fa-regular fa-thumbs-down";
                                }else{
                                    $classDislikes="fa-solid fa-thumbs-down";
                                }
                            echo '<a href="/index/like/'. $info['id'] . '"><i id="like-button" class="'.$classLikes.'"></i></a><p>'.$info['liked'].'</p>
                                <a href="/index/dislike/'. $info['id'] . '"><i id="dislike-button" class="'.$classDislikes.'"></i></a><p>'.$info['disliked'].'</p>
                                <a href="/revel/'.$info['id'].'"><i id="comment-button" class="fa-regular fa-comment-dots"></i></a><p>'.$info['comments'].'</p>
                            </div>
                        </div>
                        <hr>';
                    }

                }
                
                ?>
            </article>
            
        </body>
    <?php } ?>
</html>