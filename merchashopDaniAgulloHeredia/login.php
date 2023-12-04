<?php
    /**
     * @author Dani Agullo Heredia
     * @version 1.0
     */
    require_once(__DIR__ . '/includes/dbconnection.inc.php');
    session_start();
    $connection = getDBConnection();
    require_once(__DIR__ . '/includes/setcookie.inc.php');
    require_once(__DIR__ . '/includes/header.inc.php');
    if (isset($_COOKIE['language'])) { // comprueba si existe la cookie de idioma
        if (array_key_exists($_COOKIE['language'], $langua)) { //si la cookie tiene un valor que exista una key en el array $langua igual
            require_once(__DIR__ . '/includes/lang/login/login.' . $_COOKIE['language'] . '.inc.php');
        }
    } else {
        require_once(__DIR__ . '/includes/lang/login/login.es.inc.php'); // se pondra el español por defecto en caso de no haber cookie creada
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.cdnfonts.com/css/healing-lighters" rel="stylesheet">
    <title>Login</title>
</head>

<body class='loginup'>
    <div class="container">
        <div class="box form-box">
            <div class="tittle-login">
                <h1>
                    <?= $login_merchashop['login'] ?>
                </h1>
            </div>
            <div class="Sign-in">
                <br>
                <?php
                if (isset($_POST['user'])&&isset($_POST['password'])) {
                    if (empty($_POST['user']) || empty($_POST['password'])) {
                        $errors['user'] = $login_merchashop['error'];
                    } else {
                        $login_select = $connection->prepare('SELECT user,rol, password from users where user=:usuar or email=:usuar;');
                        $login_select->bindParam(':usuar', $_POST['user']);
                        if (isset($_POST['user'])) {
                            $login_select->execute();
                            $login_user = $login_select->fetch();
                        }
                        $token = bin2hex(random_bytes(90));
                        if (isset($_POST['user'])) {
                            if ($login_user != false && password_verify($_POST['password'], $login_user['password'])) {
                                if (isset($_POST['auto_login'])) {
                                    setcookie('token', $token, httponly: true);
                                }
                                $add_user = $connection->prepare('UPDATE users SET token = :token WHERE user = :username;');
                                $add_user->bindParam(':username', $login_user['user']);
                                $add_user->bindParam(':token', $token);

                                $_SESSION['user'] = $login_user['user'];
                                $_SESSION['logged'] = TRUE;
                                $_SESSION['rol'] = $login_user['rol'];
                                header('Location:/index');
                            } else {
                                $errors['user'] = $login_merchashop['error'];
                            }
                        }
                    }
                }
                    echo '<form action="#" method="post" enctype="multipart/form-data">';
                    if (isset($errors['user'])) {
                        echo '<p class="error_login">' . $errors['user'] . '</p><br>';
                    }
                    echo '<br>';
                    echo '<div class="field input">';
                    echo '<br><label for="user">' . $login_merchashop['user'] . '</label> <input type="text" name="user" required" ><br>'; // Los siguiente if se encargan de crear los input para cada apartado                      
                    echo '</div>';
                    echo '<div class="field input">';
                    echo '<br> <label for="password">' . $login_merchashop['password'] . '</label><input type="password" name="password" required" ><br>';
                    echo '</div>';
                    echo '<div class="field input">';
                    echo '<input type="checkbox" id="mantener" name="auto_login" value="auto_login">';
                    echo '<label for="mantener">' . $login_merchashop['keep'] . '</label><br>';
                    echo '</div>';
                    echo '<div class="field">';
                    echo '<input type="submit" class="btn" value="' . $login_merchashop['botton_login'] . '">';
                    echo '</div>';
                    echo '</form>';
                ?>
            </div>
            <br>
            <div class="sign-inup">
                <p>
                    <?= $login_merchashop['sigup'] ?>
                </p> <a class="btn-session" href="index.php">
                    <?= $login_merchashop['botton_singup'] ?>
                </a>
            </div>
        </div>
    </div>
</body>

</html>