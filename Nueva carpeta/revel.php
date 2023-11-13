<?php
/**
 * @author Dani Agullo Heredia
 * @version 1.0
 */
require_once(__DIR__.'/includes/User.inc.php');
require_once(__DIR__.'/includes/regularExpression.php');
require_once(__DIR__ . '/includes/bdconect.inc.php');

        $bd = 'revels';
        $user = 'revel';
        $pass = 'lever';
        $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

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
    <aside class="sidebar">SIDEBAR</aside>
    <article class="main">
    <?php
        

        $user_info = $conection->prepare('SELECT usuario FROM users WHERE id=(SELECT userid from revels WHERE id=:id_revel);');
        $user_info->bindParam(':id_revel', $_GET['id']);
        $user_info->execute();

        $revels_info = $conection->prepare('SELECT r.texto, r.fecha, r.id, (SELECT count(*) from likes l where r.id = l.revelid) AS liked, (SELECT count(*) from dislikes d where r.id = d.revelid) AS disliked, (SELECT count(*) from comments c where r.id = c.revelid) AS comments FROM revels r WHERE r.id=:id_revel ORDER BY r.fecha DESC;');
        $revels_info->bindParam(':id_revel', $_GET['id']);
        $revels_info->execute();

        $comment_info = $conection->prepare('SELECT c.texto,c.fecha, (SELECT usuario from users u where u.id=c.userid) AS usuario FROM comments c WHERE c.revelid=:id_revel;');
        $comment_info->bindParam(':id_revel', $_GET['id']);
        $comment_info->execute();

        $user_name = $user_info->fetch();
        $revels = $revels_info->fetch();
        $comments=$comment_info->fetchAll();
        $user=4;
        $date=date("Y-m-d H:i:s");

        $commen = $conection->prepare('INSERT INTO comments (revelid,userid,texto,fecha) VALUES (:ids,:userid,:texts,:dates);');
            $commen->bindParam(':ids',$_GET['id']);
            $commen->bindParam(':userid',$user);
            $commen->bindParam(':texts',$_POST['comment']);
            $commen->bindParam(':dates',$date);

        echo '<div class="container-main-revel"> 
        <div class="title-main-user">
            <h3>'.$user_name['usuario'].'</h3>
        </div>
        <div class="body-main-revel">
                 <p>'.$revels['texto'].'</p>
        </div>
        <div class="hour-main-revel">      
                 <p>'.$revels['fecha'].'</p>
        </div>
        <hr>
        <div class="buttons-main-revel">
            <a href="/index/insert/' . $revels['id'] . '"><i class="fa-regular fa-heart"></i></a><p>'.$revels['liked'].'</p>
            <a href="/index/insert/' . $revels['id'] . '"><i class="fa-solid fa-heart-crack"></i></a><p>'.$revels['disliked'].'</p>
            <a href="/index/insert/' . $revels['id'] . '"><i class="fa-regular fa-comment-dots"></i></a><p>'.$revels['comments'].'</p>
        </div>
        <hr>    
        <div class="comment-container">
            <form action="#" method="post" class="coment_form" enctype="multipart/form-data">
                <input type="text" name="comment" id="input-coment" placeholder="Comenta algo...">';
                if (isset($errors['comment'])) {
                   echo '<p class="error_coment">'. $errors['comment'] . '</p><br>';
                }
                echo '<input type="submit" id="comment" value="Enviar">
            </form>
        </div>
        <hr>';
        
        if(!empty($comments)) {
            foreach($comments as $comment){
                echo '<div class="title-main-comment">
                        <h3>'.$comment['usuario'].'</h3>
                    </div>
                    <div class="body-main-comment">
                        <p>'.$comment['texto'].'</p>
                    </div>
                    <div class="hour-main-comment">      
                        <p>'.$comment['fecha'].'</p>
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
    ?>
    </article>
    <footer class="footer">FOOTER</footer>

</body>
</html>