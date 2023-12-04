<?php
/**
 * @author Dani Agullo Heredia
 * @version 1.0
 */
if (!isset($_SESSION['user']) && isset($_COOKIE['token'])) {
    $connection = getDBConnection();
    $autoLogin = $connection->prepare('select user, rol from users where token=:token;"');
    $autoLogin->bindParam(':token', $COOKIE['token']);
    $autoLogin->execute();
    $result = $autoLogin->fetch();
    unset($autoLogin);
    unset($connection);
    if ($result) {
        $_SESSION['user'] = $result['user'];
        $_SESSION['rol'] = $result['rol'];
    }
}
