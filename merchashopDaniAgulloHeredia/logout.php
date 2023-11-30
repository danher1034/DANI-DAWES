<?php

/**
 * @author Dani Agullo Heredia
 * @version 1.0
 */
require_once(__DIR__ . '/includes/dbconnection.inc.php');
    session_start();

    if (isset($_COOKIE['token'])) {
        $connection = getDBConnection();
        $token_edit = $connection->prepare('UPDATE users SET token = "" WHERE token = :token ;');
        $token_edit->bindParam(':token', $_COOKIE['token']);
        $token_edit->execute();
        
        unset($token_edit);
        unset($connection);

        setcookie('token','', time() -3600,httponly: true);
    }

    session_destroy();
    header('Location:/index');