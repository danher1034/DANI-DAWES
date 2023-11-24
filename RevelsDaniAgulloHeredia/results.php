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
<body class="body-result">
    <?php require_once(__DIR__ .'/includes/header.inc.php'); ?>          
    <aside class="sidebar-result">
    <?php
        $amigos_info = $conection->prepare('SELECT usuario,id FROM users WHERE id IN (SELECT userfollowed FROM follows WHERE userid = :id_user)');
        $amigos_info->bindParam(':id_user', $_SESSION['user']);
        $amigos_info->execute();

        $amigos = $amigos_info->fetchAll();


            echo '<h2>Siguiendo:</h2>';
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
            $user_search = $conection->prepare('SELECT u.usuario, u.id, (SELECT COUNT(*) FROM follows f WHERE f.userid = :id_useraccount AND f.userfollowed = u.id) AS userfollowed from users u where usuario like :usuar;');
            $searchValue= '%' . $_GET['search'] . '%';
            $user_search->bindParam(':usuar',  $searchValue);
            $user_search->bindParam(':id_useraccount', $_SESSION['user']);

            if(isset($_GET['search'])){
                $user_search->execute();
            }

            if(isset($_GET['follow'])){
                $add_follow = $conection->prepare('INSERT INTO follows (userid, userfollowed) VALUES (:iduser, :iduserfollowed);');
                $add_follow->bindParam(':iduserfollowed', $_GET['follow']);
                $add_follow->bindParam(':iduser', $_SESSION['user']);

                if (isset($_GET['follow'])) {
                    $add_follow->execute();
                    header('Location:/results/search/' . $_GET['search']);
                    exit;
                }
            }

            if(isset($_GET['unfollow'])){
                $_unfollow = $conection->prepare('DELETE FROM follows WHERE userfollowed=:iduserfollowed and userid=:iduser ;');
                $_unfollow->bindParam(':iduserfollowed', $_GET['unfollow']);
                $_unfollow->bindParam(':iduser', $_SESSION['user']);

                if (isset($_GET['unfollow'])) {
                    $_unfollow->execute();
                    header('Location:/results/search/' . $_GET['search']);
                    exit;
                }
            }

            foreach($user_search->fetchAll() as $search_user){
                echo'            
                    <div class="title_user_follow">
                        <h2>'.$search_user['usuario'].'</h2>';
                        if($search_user['userfollowed']==1){
                        echo ' <a href="/results/search/' . $_GET['search'] . '/unfollow/'.$search_user['id'].'" id="seguir_user">Siguiendo</a>';
                        }else{
                        echo ' <a href="/results/search/' . $_GET['search'] . '/follow/'.$search_user['id'].'" id="seguir_user">Seguir</a>';
                        }                   
                echo '</div><hr>';
            }
                    
        ?>   
    </article>
</body>
</html>