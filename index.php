<?php

/**
 * @author Dani Agullo Heredia
 * @version 1.0
 */

 require_once(__DIR__.'/include/bdconect.inc.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $bd='discografia';
        $user='vetustamorla';
        $pass='15151';
        $options=array(PDO::MYSQL_ATTR_INIT_COMMAND =>'SET NAMES utf8');
        $conection = bdconection($bd, $user, $pass, $options);

        $result = $conection->query('SELECT * FROM grupos;');

        foreach ($result->fetchAll() as $names) {
            echo '<form action="group.php" method="post">';
                echo '<input type="hidden" name="name" value="' . $names['nombre'] . '">';
                echo '<input type="hidden" name="code" value="' . $names['codigo'] . '">';
                echo '<input type="submit" value="'.$names['nombre'].'">';
            echo '</form>';
            echo '<br>';
        }
        

    ?>
   
</body>
</html>