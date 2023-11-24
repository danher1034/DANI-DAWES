<nav class="navbar2">
    <a class="navbar-brand" href="/index.php">
        <img src="/img/logo-revels.png" alt="Logo" width="55" height="50">
    </a>
    <h1>Revels</h1>
    <div class="bottons-navbar">
        <a class="navbar-list" id="btn2" href="/list">Lista</a>
        <a class="navbar-sesion" id="btn3" href="/cancel">Eliminar cuenta</a>
    </div>
</nav>

<aside class="sidebar-userfollow2">
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

            echo '<h2>'.$user_name['usuario'].'</h2>';
            echo '<br>';
            echo '<div class="followers">';
                echo '<p class="revels">'.$revels_number.' revels</p>';
                echo '<p class="follower">'.$user_name['followers'].' seguidores</p>';
                echo '<p class="follows">'.$user_name['followed'].' seguidos</p>';
            echo '</div>';
        ?>
    </aside>

    <aside class="sidebar-userfriend2">
        <?php
            echo '<h2>Seguiendo</h2><br>';
            foreach ($amigos as $info) {                
                echo '<div class="sidebar-friend">                  
                        <a href="/user/'.$info['id'].'" id="enlace_userRevel">
                            <h4>'.$info['usuario'].'</h4>
                        </a>
                     </div>';
            }
        ?>
    </aside>

<aside class="sidebar-accounts2">
<?php
    $user_account = $conection->prepare('SELECT usuario from users where id=:usuar;');
    $user_account->bindParam(':usuar', $_SESSION['user']);

    if (isset($_SESSION['user'])) {
    $user_account->execute();
    $account_user = $user_account->fetch();
    }

    echo '<br>
    <div class="account_div">
        <span id="user_account_text"><i class="fa-solid fa-user"></i>' . $account_user['usuario'] . '</span>
        <div class="account-content">
            <a href="/account"><i class="fa-solid fa-user"></i> Cuenta</a>
            <a href="/index"><i class="fa-solid fa-plus"></i> Nuevo revel</a>
            <a href="/close"><i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión</a>
        </div>
    </div>';
    ?>
</aside>
<footer class="footer2">FOOTER</footer>
