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

        $result = $conection->prepare('SELECT * FROM grupos WHERE nombre=:nomb;');
        $result->bindParam(':nomb',$_POST['name']);
        $result->execute();

        $result2 = $conection->prepare('SELECT titulo,anyo,formato,fechacompra,precio FROM albumes WHERE grupo=:cod;');
        $result2->bindParam(':cod',$_POST['code']);
        $result2->execute();

            $group=$result->fetch();
            echo $group['nombre'];
            echo '<br><br>';
        
 
        

        echo '<form action="group.php" method="post">';
        echo '<table>';     
                foreach($result2->fetchAll() as $album){
                    echo '<tr>';
                        echo '<td>
                                <input type="hidden" name="code" value="' . $album['titulo'] . '">
                                <input type="submit" value="'.$album['titulo'].'"
                            <td>';
                        echo '<td>'.$album['anyo'].'<td>';
                        echo '<td>'.$album['formato'].'<td>';
                        echo '<td>'.$album['fechacompra'].'<td>';
                        echo '<td>'.$album['precio'].'<td>';
                    echo '<tr>';
                } 
        echo '</table>';
        echo '</form>';
    ?>
    <table ></table>
</body>
</html>