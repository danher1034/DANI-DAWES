<?php

/**
 * @author Dani Agullo Heredia
 * @version 1.0
 */
require_once(__DIR__ . '/includes/regularExpression.php');
require_once(__DIR__ . '/includes/bdconect.inc.php');
session_start();
$bd = 'revels';
$user = 'revel';
$pass = 'lever';
$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
$date = date("Y-m-d H:i:s");
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

<body class="body-revels">
    <?php require_once(__DIR__ . '/includes/header.inc.php'); ?>
   

    <article class="main">
        
        <?php

        $user_info = $conection->prepare('SELECT u.usuario,(SELECT COUNT(*) FROM follows f WHERE f.userid = :id_useraccount AND f.userfollowed = u.id) AS userfollowed, (SELECT COUNT(*) FROM revels r WHERE r.id=:id_revel AND r.userid=:id_useraccount) AS userme FROM users u WHERE u.id=(SELECT userid from revels WHERE id=:id_revel);');
        $user_info->bindParam(':id_revel', $_GET['id']);
        $user_info->bindParam(':id_useraccount', $_SESSION['user']);
        $user_info->execute();

        $user_name = $user_info->fetch();

        if($user_name['userfollowed']==1 || $user_name['userme']==1){

        $revels_info = $conection->prepare('SELECT r.texto, r.fecha, r.id, (SELECT count(*) from likes l where r.id = l.revelid) AS liked,(SELECT count(*) from likes l where r.id = l.revelid and l.userid=:id_user) AS userlikes, (SELECT count(*) from dislikes d where r.id = d.revelid) AS disliked,(SELECT count(*) from dislikes d where r.id = d.revelid and d.userid=:id_user) AS userdislikes, (SELECT count(*) from comments c where r.id = c.revelid) AS comments FROM revels r WHERE r.id=:id_revel ORDER BY r.fecha DESC;');
        $revels_info->bindParam(':id_user', $_SESSION['user']);
        $revels_info->bindParam(':id_revel', $_GET['id']);
        $revels_info->execute();

        $comment_info = $conection->prepare('SELECT c.texto,c.fecha, (SELECT usuario from users u where u.id=c.userid) AS usuario FROM comments c WHERE c.revelid=:id_revel;');
        $comment_info->bindParam(':id_revel', $_GET['id']);
        $comment_info->execute();

        $revels = $revels_info->fetch();
        $comments = $comment_info->fetchAll();

        $commen = $conection->prepare('INSERT INTO comments (revelid,userid,texto,fecha) VALUES (:ids,:userid,:texts,:dates);');
        $commen->bindParam(':ids', $_GET['id']);
        $commen->bindParam(':userid', $_SESSION['user']);
        $commen->bindParam(':texts', $_POST['comment']);
        $commen->bindParam(':dates', $date);

        $select_like = $conection->prepare('SELECT userid FROM likes WHERE userid=:iduser and revelid=:idrevel;');
        $select_like->bindParam(':idrevel', $_GET['like']);
        $select_like->bindParam(':iduser', $_SESSION['user']);
        $select_like->execute();

        $select_dislike = $conection->prepare('SELECT userid FROM dislikes WHERE userid=:iduser and revelid=:idrevel;');
        $select_dislike->bindParam(':idrevel', $_GET['dislike']);
        $select_dislike->bindParam(':iduser', $_SESSION['user']);
        $select_dislike->execute();


        echo '<div class="container-main-revel"> 
        <div class="title-main-user">
            <h3>' . $user_name['usuario'] . '</h3>
        </div>
        <div class="body-main-revel">
                 <p>' . $revels['texto'] . '</p>
        </div>
        <div class="hour-main-revel">      
                 <p>' . $revels['fecha'] . '</p>
        </div>
        <hr>';
        if ($revels['userlikes'] == 0) {
            $classLikes = "fa-regular fa-thumbs-up";
        } else {
            $classLikes = "fa-solid fa-thumbs-up";
        }
        if ($revels['userdislikes'] == 0) {
            $classDislikes = "fa-regular fa-thumbs-down";
        } else {
            $classDislikes = "fa-solid fa-thumbs-down";
        }
        echo '
        <div class="buttons-main-revel">
            <a href="/revel/' . $revels['id'] . '/like/' . $revels['id'] . '"><i id="like-button" class="' . $classLikes . '"></i></a><p>' . $revels['liked'] . '</p>
            <a href="/revel/' . $revels['id'] . '/dislike/' . $revels['id'] . '"><i id="dislike-button" class="' . $classDislikes . '"></i></a><p>' . $revels['disliked'] . '</p>
            <a href="/revel/'.$revels['id'].'"><i id="comment-button" class="fa-regular fa-comment-dots"></i></a><p>' . $revels['comments'] . '</p>
        </div>
        <hr>    
        <div class="comment-container">
            <form action="#" method="post" class="coment_form" enctype="multipart/form-data">
                <input type="text" name="comment" id="input-coment" placeholder="Comenta algo...">
                <input type="submit" id="comment" value="Enviar">';
        if (isset($errors['comment'])) {
            echo '<p class="error_coment">' . $errors['comment'] . '</p><br>';
        }
        echo '</form>
        </div>
        <hr>';

        if (!empty($comments)) {
            foreach ($comments as $comment) {
                echo '<div class="title-main-comment">
                        <h3>' . $comment['usuario'] . '</h3>
                    </div>
                    <div class="body-main-comment">
                        <p>' . $comment['texto'] . '</p>
                    </div>
                    <div class="hour-main-comment">      
                        <p>' . $comment['fecha'] . '</p>
                    </div>
                <hr>';
            }
        }

        if (isset($_POST['comment'])) {
            if (count($errors) < 1) {
                $commen->execute();
                header('Location: /revel/' . $_GET['id']);
                exit;
            }
        }
        echo '</div>';

    }else{
        header('Location:/index');
    }
        ?>
    </article>

</body>

</html>