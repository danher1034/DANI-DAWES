<?php
/**
 * @author Dani Agullo Heredia
 * @version 1.0
 */
require_once(__DIR__.'/includes/User.inc.php');
require_once(__DIR__.'/includes/regularExpression.php');
require_once(__DIR__ . '/includes/bdconect.inc.php');
        session_start();
        $bd = 'revels';
        $user = 'revel';
        $pass = 'lever';
        $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
        $date=date("Y-m-d H:i:s");
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
    <aside class="sidebar-accounts">      
        <?php
            $user_account = $conection->prepare('SELECT usuario from users where id=:usuar;');
            $user_account->bindParam(':usuar', $_SESSION['user']);

            if(isset($_SESSION['user'])){
                $user_account->execute();
                $account_user = $user_account->fetch();
            }

            echo '<br><div class="account_div">
                    <span id="user_account_text"><i class="fa-solid fa-user"></i>'.$account_user['usuario'].'</span>
                        <div class="account-content">
                            <a href="/account"><i class="fa-solid fa-user"></i>  Cuenta</a>
                            <a href="/index"><i class="fa-solid fa-plus"></i>  Nuevo revel</a>
                            <a href="/account/cancel/1"><i class="fa-solid fa-right-from-bracket"></i>  Cerrar cuenta</a>
                        </div>
                   </div>';
        ?>
    </aside>
    <article class="main">
    <?php
        
        $user_info = $conection->prepare('SELECT usuario FROM users WHERE id=(SELECT userid from revels WHERE id=:id_revel);');
        $user_info->bindParam(':id_revel', $_GET['id']);
        $user_info->execute();

        $revels_info = $conection->prepare('SELECT r.texto, r.fecha, r.id, (SELECT count(*) from likes l where r.id = l.revelid) AS liked,(SELECT count(*) from likes l where r.id = l.revelid and l.userid=:id_user) AS userlikes, (SELECT count(*) from dislikes d where r.id = d.revelid) AS disliked,(SELECT count(*) from dislikes d where r.id = d.revelid and d.userid=:id_user) AS userdislikes, (SELECT count(*) from comments c where r.id = c.revelid) AS comments FROM revels r WHERE r.id=:id_revel ORDER BY r.fecha DESC;');
        $revels_info->bindParam(':id_user', $_SESSION['user']);
        $revels_info->bindParam(':id_revel', $_GET['id']);
        $revels_info->execute();

        $comment_info = $conection->prepare('SELECT c.texto,c.fecha, (SELECT usuario from users u where u.id=c.userid) AS usuario FROM comments c WHERE c.revelid=:id_revel;');
        $comment_info->bindParam(':id_revel', $_GET['id']);
        $comment_info->execute();

        $user_name = $user_info->fetch();
        $revels = $revels_info->fetch();
        $comments=$comment_info->fetchAll();

        $commen = $conection->prepare('INSERT INTO comments (revelid,userid,texto,fecha) VALUES (:ids,:userid,:texts,:dates);');
            $commen->bindParam(':ids',$_GET['id']);
            $commen->bindParam(':userid',$_SESSION['user']);
            $commen->bindParam(':texts',$_POST['comment']);
            $commen->bindParam(':dates',$date);

        $select_like = $conection->prepare('SELECT userid FROM likes WHERE userid=:iduser and revelid=:idrevel;');
            $select_like->bindParam(':idrevel', $_GET['like']);
            $select_like->bindParam(':iduser', $_SESSION['user']);
            $select_like->execute();

        $select_dislike = $conection->prepare('SELECT userid FROM dislikes WHERE userid=:iduser and revelid=:idrevel;');
            $select_dislike->bindParam(':idrevel', $_GET['dislike']);
            $select_dislike->bindParam(':iduser', $_SESSION['user']);
            $select_dislike->execute();


            if(isset($_GET['like'])){
                if(count($select_like->fetchAll())===0){  

                    $deletedisLike = $conection->prepare('DELETE FROM dislikes where userid =:iduser and revelid=:idrevel ;');
                    $deletedisLike->bindParam(':idrevel', $_GET['like']);
                    $deletedisLike->bindParam(':iduser', $_SESSION['user']);
                    $deletedisLike->execute();

                    $add_like = $conection->prepare('INSERT INTO likes (revelid, userid) VALUES (:idrevel,:iduser);');
                    $add_like->bindParam(':idrevel', $_GET['like']);
                    $add_like->bindParam(':iduser', $_SESSION['user']);

                    if (isset($_GET['like'])) {
                        $add_like->execute();
                        header('Location:/revel/'.$_GET['id']);
                        exit;
                    }                                           
                }else{
                    $deleteLike = $conection->prepare('DELETE FROM likes where userid =:iduser and revelid=:idrevel ;');
                    $deleteLike->bindParam(':idrevel', $_GET['like']);
                    $deleteLike->bindParam(':iduser', $_SESSION['user']);
                    $deleteLike->execute();  
                    header('Location:/revel/'.$_GET['id']);                         
                }
            }


            if(isset($_GET['dislike'])){
                if(count($select_dislike->fetchAll())===0){   
                    $deleteLike = $conection->prepare('DELETE FROM likes where userid =:iduser and revelid=:idrevel ;');
                    $deleteLike->bindParam(':idrevel', $_GET['dislike']);
                    $deleteLike->bindParam(':iduser', $_SESSION['user']);
                    $deleteLike->execute();

                    $add_dislike = $conection->prepare('INSERT INTO dislikes (revelid, userid) VALUES (:idrevel,:iduser);');
                    $add_dislike->bindParam(':idrevel', $_GET['dislike']);
                    $add_dislike->bindParam(':iduser', $_SESSION['user']);

                    if (isset($_GET['dislike'])) {
                        $add_dislike->execute();
                        header('Location:/revel/'.$_GET['id']);
                        exit;
                    }                                           
                }else{
                    $deletedisLike = $conection->prepare('DELETE FROM dislikes where userid =:iduser and revelid=:idrevel ;');
                    $deletedisLike->bindParam(':idrevel', $_GET['dislike']);
                    $deletedisLike->bindParam(':iduser', $_SESSION['user']);
                    $deletedisLike->execute();  
                    header('Location:/revel/'.$_GET['id']);                 
                }
            }

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
        <hr>';
        if($revels['userlikes']==0){
            $classLikes="fa-regular fa-thumbs-up";
        }else{
            $classLikes="fa-solid fa-thumbs-up";
        }
        if($revels['userdislikes']==0){
            $classDislikes="fa-regular fa-thumbs-down";
        }else{
            $classDislikes="fa-solid fa-thumbs-down";
        }
        echo '
        <div class="buttons-main-revel">
            <a href="/revel/' . $revels['id'] . '/like/' . $revels['id'] . '"><i class="'.$classLikes.'"></i></a><p>'.$revels['liked'].'</p>
            <a href="/revel/' . $revels['id'] . '/dislike/' . $revels['id'] . '"><i class="'.$classDislikes.'"></i></a><p>'.$revels['disliked'].'</p>
            <a href="/index/insert/' . $revels['id'] . '"><i class="fa-regular fa-comment-dots"></i></a><p>'.$revels['comments'].'</p>
        </div>
        <hr>    
        <div class="comment-container">
            <form action="#" method="post" class="coment_form" enctype="multipart/form-data">
                <input type="text" name="comment" id="input-coment" placeholder="Comenta algo...">
                <input type="submit" id="comment" value="Enviar">';
                if (isset($errors['comment'])) {
                    echo '<p class="error_coment">'. $errors['comment'] . '</p><br>';
                 }
            echo '</form>
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