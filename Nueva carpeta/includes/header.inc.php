<?php
if (isset($_GET['header2'])) {
    echo '<nav class="navbar2">
    <a class="navbar-brand" href="/index.php">
        <img src="/img/logo-revels.png" alt="Logo" width="55" height="50">
    </a>

    <h1>Revels</h1>
    </nav>';
} else {

?>

    <nav class="navbar">
        <a class="navbar-brand" href="/index.php">
            <img src="/img/logo-revels.png" alt="Logo" width="55" height="50">
        </a>
        <h1>Revels</h1>
        <?php
        if (isset($_POST['users'])) {
            header('Location: /results/search/' . $_POST['users']);
            exit();
        }

        echo '<form action="#" class="nav_form" method="post" class="coment_form" enctype="multipart/form-data">
                            <input class="input-nav" name="users" type="text" placeholder="Buscar...">
                            <button class="button-nav" type="submit" id="comment"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </form>';
        ?>
    </nav>
    <aside class="sidebar-accounts">
    <?php
    $user_account = $conection->prepare('SELECT usuario from users where id=:usuar;');
    $user_account->bindParam(':usuar', $_SESSION['user']);

    if (isset($_SESSION['user'])) {
        $user_account->execute();
        $account_user = $user_account->fetch();
    }

    echo '<br><div class="account_div">
                            <span id="user_account_text"><i class="fa-solid fa-user"></i>' . $account_user['usuario'] . '</span>
                                <div class="account-content">
                                    <a href="/account/header2/1"><i class="fa-solid fa-user"></i>  Cuenta</a>
                                    <a href="/index"><i class="fa-solid fa-plus"></i>  Nuevo revel</a>
                                    <a href="/account/cancel/1"><i class="fa-solid fa-right-from-bracket"></i>  Cerrar sesión</a>
                                </div>
                        </div>
   
    </aside>';
    }
        ?>