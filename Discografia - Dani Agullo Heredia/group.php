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

        $result = $conection->prepare('SELECT * FROM grupos WHERE codigo=:nomb;');
        $result->bindParam(':nomb',$_GET['id']);
        $result->execute();

        $result2 = $conection->prepare('SELECT titulo,anyo,formato,fechacompra,precio,grupo,codigo FROM albumes WHERE grupo=:cod;');
        $result2->bindParam(':cod',$_GET['id']);
        $result2->execute();

            $group=$result->fetch();
            echo $group['nombre'];
            echo '<br><br>';
        
                 

        echo '<table border="">';     
                foreach($result2->fetchAll() as $album){
                    echo '<tr>
                             <td>Titulo</td>
                             <td>Año</td>
                             <td>Formato</td>
                             <td>Fecha de compra</td>
                             <td>Precio</td>
                          </tr>';
                    echo '<tr>';
                        echo '<td>';
                                echo '<a href="album.php?id='. $album['codigo'] .'">'.$album['titulo'].'</a>';
                        echo '</td>';
                        echo '<td>'.$album['anyo'].'</td>';
                        echo '<td>'.$album['formato'].'</td>';
                        echo '<td>'.$album['fechacompra'].'</td>';
                        echo '<td>'.$album['precio'].'</td>';
                    echo '<tr>';
                } 
        echo '</table>';

    ?>
    <br>
    <a href="index.php">Volver Atrás</a>
</body>
</html>