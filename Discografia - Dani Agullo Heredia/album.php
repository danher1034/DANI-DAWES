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
    <a href="index.php"><h1>Discografía - Dani Agullo Heredia</h1></a>
    <?php
        $bd='discografia';
        $user='vetustamorla';
        $pass='15151';
        $options=array(PDO::MYSQL_ATTR_INIT_COMMAND =>'SET NAMES utf8');
        $conection = bdconection($bd, $user, $pass, $options);

        $result = $conection->prepare('SELECT a.titulo, g.nombre, g.codigo FROM albumes a, grupos g WHERE a.codigo=:cod and a.grupo=g.codigo ;');
        $result->bindParam(':cod',$_GET['id']);
        $result->execute();

        $result2 = $conection->prepare('SELECT titulo,duracion,posicion FROM canciones WHERE album=:cod;');
        $result2->bindParam(':cod',$_GET['id']);
        $result2->execute();

            $group=$result->fetch();
            echo 'Nombre grupo: '.$group['nombre'];
            echo '<br>';   
            echo 'Nombre album: '.$group['titulo'];
            echo '<br><br>'; 

            echo '<table border="">';  
                echo '<tr>
                        <td>Titulo</td>
                        <td>Duracion</td>
                        <td>Posición</td>
                      </tr>';
                foreach($result2->fetchAll() as $canciones){
                    echo '<tr>';
                        echo '<td>Cancion: '.$canciones['titulo'].'</td>';
                        echo '<td>'.$canciones['duracion'].' s</td>';
                        echo '<td>'.$canciones['posicion'].'º</td>';
                    echo '</tr>'; 
                }            
            echo '</table>';
                echo '<br>';
            echo '<a href="group.php?id='. $group['codigo'] .'">Volver</a>';
            

    ?>

</body>
</html>