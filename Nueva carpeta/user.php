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
        require_once(__DIR__ . '/includes/likes_dislikes.inc.php');
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
<body class="body-user">
    <?php require_once(__DIR__ .'/includes/header.inc.php'); ?>
    <aside class="sidebar-user">
        <?php
                     
            $user_info = $conection->prepare('SELECT u.usuario,(SELECT COUNT(*) FROM follows f WHERE f.userid = u.id) AS followed,(SELECT COUNT(*) FROM follows f WHERE f.userfollowed = u.id) AS followers,(SELECT COUNT(*) FROM follows f WHERE f.userid = :id_useraccount AND f.userfollowed = :id_user) AS userfollowed FROM users u WHERE u.id = :id_user;');
            $user_info->bindParam(':id_user', $_GET['id']);
            $user_info->bindParam(':id_useraccount', $_SESSION['user']);
            $user_info->execute();

            $revels_info = $conection->prepare('SELECT LEFT(r.texto, 50) AS texto, r.fecha, r.id, (SELECT count(*) from likes l where r.id = l.revelid) AS liked,(SELECT count(*) from likes l where r.id = l.revelid and l.userid=:id_useraccount) AS userlikes, (SELECT count(*) from dislikes d where r.id = d.revelid) AS disliked,(SELECT count(*) from dislikes d where r.id = d.revelid and d.userid=:id_useraccount) AS userdislikes, (SELECT count(*) from comments c where r.id = c.revelid) AS comments FROM revels r WHERE r.userid=:id_user ORDER BY r.fecha DESC;');
            $revels_info->bindParam(':id_user', $_GET['id']);
            $revels_info->bindParam(':id_useraccount', $_SESSION['user']);
            $revels_info->execute();

            $suggestions_info = $conection->prepare('SELECT usuario,id FROM users WHERE id NOT IN (SELECT userfollowed FROM follows WHERE userid = :id_user)and id != :id_user ORDER BY RAND() LIMIT 5;');
                    $suggestions_info->bindParam(':id_user', $_SESSION['user']);
                    $suggestions_info->execute();

                    $suggestions = $suggestions_info->fetchAll();

                    if(isset($_GET['follow'])){
                        $add_follow = $conection->prepare('INSERT INTO follows (userid, userfollowed) VALUES (:iduser, :iduserfollowed);');
                        $add_follow->bindParam(':iduserfollowed', $_GET['follow']);
                        $add_follow->bindParam(':iduser', $_SESSION['user']);

                        if (isset($_GET['follow'])) {
                            $add_follow->execute();
                            header('Location:/user/' . $_GET['id']);
                            exit;
                        }
                    }

                    if(isset($_GET['unfollow'])){
                        $_unfollow = $conection->prepare('DELETE FROM follows WHERE userfollowed=:iduserfollowed and userid=:iduser ;');
                        $_unfollow->bindParam(':iduserfollowed', $_GET['unfollow']);
                        $_unfollow->bindParam(':iduser', $_SESSION['user']);

                        if (isset($_GET['unfollow'])) {
                            $_unfollow->execute();
                            header('Location:/user/' . $_GET['id']);
                            exit;
                        }
                    }

            $user_name = $user_info->fetch();

            $revels = $revels_info->fetchAll();

            $revels_number = $revels_info->rowCount();

            echo '<div class="title_user_follow">
                    <h2>'.$user_name['usuario'].'</h2>';
                    if($user_name['userfollowed']==1){
                      echo ' <a href="/user/' . $_GET['id'] . '/unfollow/'.$_GET['id'].'" id="seguir_user">Siguiendo</a>';
                    }else{
                      echo ' <a href="/user/' . $_GET['id'] . '/follow/'.$_GET['id'].'" id="seguir_user">Seguir</a>';
                    }                   
                echo '</div>';

            echo '<br>';
            echo '<div class="followers">';
                echo '<p class="revels">'.$revels_number.' revels</p>';
                echo '<p class="follower">'.$user_name['followers'].' seguidores</p>';
                echo '<p class="follows">'.$user_name['followed'].' seguidos</p>';
            echo '</div>';
        ?>
    </aside>

    <article class="main">
        <?php  
        if($user_name['userfollowed']==1){

            foreach ($revels as $info) {
                echo '<div class="container-main-user"> 
                        <div class="title-main-user">
                            <h3>'.$user_name['usuario'].'</h3>
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
                    echo '<a href="/user/' . $_GET['id'] . '/like/' . $info['id'] . '"><i id="like-button" class="'.$classLikes.'"></i></a><p>'.$info['liked'].'</p>
                            <a href="/user/' . $_GET['id'] . '/dislike/' . $info['id'] . '"><i id="dislike-button" class="'.$classDislikes.'"></i></a><p>'.$info['disliked'].'</p>
                            <a href="/revel/'.$info['id'].'"><i id="comment-button" class="fa-regular fa-comment-dots"></i></a><p>'.$info['comments'].'</p>
                        </div>
                    </div>
                    <hr>';
            }
        } else{
            echo '<div class="text_nologin">
                    <br>
                    <i class="fa-solid fa-lock"></i>
                    <br><h2>Esta cuenta es privada</h2> 
                    <p>Sigue esta cuenta para ver sus revels</p>
                </div>';
        }
        ?>   
    </article>
</body>
</html>