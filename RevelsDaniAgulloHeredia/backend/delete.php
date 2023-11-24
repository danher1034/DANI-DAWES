<?php

/**
 * @author Dani Agullo Heredia
 * @version 1.0
 */
require_once('../includes/bdconect.inc.php');
session_start();
$bd = 'revels';
$user = 'revel';
$pass = 'lever';
$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
$conection = bdconection($bd, $user, $pass, $options);

    if (isset($_GET['delete'])) {$deleted = $conection->exec('DELETE l ,d , c, r FROM revels r LEFT JOIN comments c ON r.id = c.revelid LEFT JOIN dislikes d ON r.id = d.revelid LEFT JOIN likes l ON r.id = l.revelid WHERE r.id =' . $_GET['delete']);}
    header('Location:/list');