<?php
    /**
     * @author Dani Agullo Heredia
     * @version 1.0
     */
    require_once(__DIR__ . '/includes/bdconect.inc.php');
    require_once(__DIR__ . '/includes/regularExpression.php');

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
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://fonts.cdnfonts.com/css/healing-lighters" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="body-user">
    <nav class="navbar">
            <a class="navbar-brand" href="index.php">
                <img src="img/logo-revels.png" alt="Logo" width="55" height="50">
            </a>
            <h1>Revels</h1>
            <form class="nav_form">
                <input type="text" placeholder="Buscar...">
                <button><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
    </nav>
    <aside class="sidebar-user">
        <?php
            $conection = bdconection($bd, $user, $pass, $options);
            $user_info = $conection->prepare('SELECT u.usuario, f.userfollowed FROM users u LEFT JOIN follows f ON u.id = f.userfollowed WHERE u.id=:id_user;');
            $user_info->bindParam(':id_user', $_GET['id']);
            $user_info->execute();

            $user_followed = $conection->prepare('SELECT userid FROM follows WHERE userid=:id_user;');
            $user_followed->bindParam(':id_user', $_GET['id']);
            $user_followed->execute();

            
            $revels_info = $conection->prepare('SELECT r.texto,r.fecha,l.userid ,d.revelid FROM revels r LEFT JOIN likes l ON r.id = l.revelid LEFT JOIN dislikes d ON r.id = d.revelid  WHERE r.userid=:id_user ORDER BY r.fecha DESC;');
            $revels_info->bindParam(':id_user', $_GET['id']);
            $revels_info->execute();

            $user_name = $user_info->fetch();

            if(($user_name['userfollowed'] !== null)){
                $followers = $user_info->rowCount();
            }else{
                $followers = 0;
            }

            $followed = $user_followed->rowCount();

            $revels_number = $revels_info->rowCount();

            echo '<h2>'.$user_name['usuario'].'</h2>';
            echo '<br>';
            echo '<div class="followers">';
                echo '<p class="revels">'.$revels_number.' revels</p>';
                echo '<p class="follower">'.$followers.' seguidores</p>';
                echo '<p class="follows">'.$followed.' seguidos</p>';
            echo '</div>';
        ?>
    </aside>
    <aside class="sidebar-user2">
        <?php
            echo '<h2>Manolo</h2>';
            echo '<br>';
            echo '<div class="followers">';
                echo '<p class="revels">6 revels</p>';
                echo '<p class="follower">166 seguidores</p>';
                echo '<p class="follows">168 seguidos</p>';
            echo '</div>';
        ?>
    </aside>
    <article class="main">
        <?php

            $revels = $revels_info->fetchAll()

            if(($revels['userid'] !== null)){
                $likes = $userid->rowCount();
            }else{
                $likes = 0;
            }

            if(($revels['revelid'] !== null)){
                $dislikes = $revelid->rowCount();
            }else{
                $dislikes = 0;
            }

            foreach ($revels as $info) {
                echo '<div class="container-main-user">
                        <div class="title-main-user">
                            <h4>'.$user_name['usuario'].'</h4>
                        </div>
                        <div class="body-main-user">
                            <p>'.$info['texto'].'</p>
                        </div>
                        <div class="buttons-main-user">
                            <a href="/index/insert/' . $info['userid'] . '"><i class="fa-regular fa-heart"></i></a><p>'.$likes.'</p>
                            <a href="/index/insert/' . $info['userid'] . '"><i class="fa-solid fa-heart-crack"></i></a><p>'.$dislikes.'</p>
                            <button type="button"><i class="fa-regular fa-comment-dots"></i></button><p>200</p>
                        </div>
                    </div>
                    <hr>';
            }
        ?>   
    </article>
    <footer class="footer">FOOTER</footer>
</body>
</html>