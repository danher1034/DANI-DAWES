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
    <nav class="navbar">
            <a class="navbar-brand" href="/index.php">
                <img src="/img/logo-revels.png" alt="Logo" width="55" height="50">
            </a>
            <h1>Revels</h1>
            <?php
                    $conection = bdconection($bd, $user, $pass, $options);

                    if (isset($_GET['delete'])) {
                        $deleted = $conection->exec('DELETE l ,d , c, r FROM revels r LEFT JOIN comments c ON r.id = c.revelid LEFT JOIN dislikes d ON r.id = d.revelid LEFT JOIN likes l ON r.id = l.revelid WHERE r.id =' . $_GET['delete']);
                    }
                    
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
    <aside class="sidebar-account">
        <?php
                  
            $user_info = $conection->prepare('SELECT u.usuario, (SELECT count(*) from follows f where u.id = f.userfollowed) AS followers, (SELECT count(*) from follows f where userid=:id_user) AS followed FROM users u WHERE u.id=:id_user;');
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

            echo '<h2>'.$user_name['usuario'].'</h2>';
            echo '<br>';
            echo '<div class="followers">';
                echo '<p class="revels">'.$revels_number.' revels</p>';
                echo '<p class="follower">'.$user_name['followers'].' seguidores</p>';
                echo '<p class="follows">'.$user_name['followed'].' seguidos</p>';
            echo '</div>';
        ?>
    </aside>
    <aside class="sidebar-account2">
        <?php
            echo '<h2>Friends</h2>';
            foreach ($amigos as $info) {
                echo '<div class="sidebar-friend">                  
                        <a href="/user/'.$info['id'].'" id="enlace_userRevel">
                            <h4>'.$info['usuario'].'</h4>
                        </a>
                     </div>';
            }
        ?>
    </aside>
    <article class="main">
        <?php           
            foreach ($revels as $info) {
                echo '<div class="container-main-account"> 
                        <div class="title-main-account">
                            <h3>'.$user_name['usuario'].'</h3>
                            <a href="/account/delete/' . $info['id'] . '"><i class="fa-solid fa-trash"></i></a>
                        </div>
                        <div class="body-main-user">
                            <a href="/revel/'.$info['id'].'" id="enlace_userRevel">
                                 <p>'.$info['texto'].'</p>
                            </a>
                        </div>
                    </div>
                    <hr>';
            }
        ?>   
    </article>
    <footer class="footer">FOOTER</footer>
</body>
</html>