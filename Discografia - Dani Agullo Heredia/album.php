<?php

/**
 * @author Dani Agullo Heredia
 * @version 1.0
 */

require_once(__DIR__ . '/include/bdconect.inc.php');
require_once(__DIR__ . '/include/regularExpression.php');
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <a href="/index.php">
        <h1>Discografía - Dani Agullo Heredia</h1>
    </a>
    <?php
        $bd = 'discografia';
        $user = 'vetustamorla';
        $pass = '15151';
        $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
        $conection = bdconection($bd, $user, $pass, $options);

        if(!isset($conection)){
            exit;
        }

        if (isset($_GET['action'])) {
            $deleted = $conection->exec('DELETE FROM canciones  where codigo =' . $_GET['action']);
        }

        $result = $conection->prepare('SELECT a.titulo, g.nombre, g.codigo FROM albumes a, grupos g WHERE a.codigo=:cod and a.grupo=g.codigo;');
        $result->bindParam(':cod', $_GET['id']);
        $result->execute();
 
        $result2 = $conection->prepare('SELECT titulo,duracion,posicion,codigo FROM canciones WHERE album=:cod;');
        $result2->bindParam(':cod', $_GET['id']);
        $result2->execute();

        if (isset($_POST['position'])) {
            $result3=$conection->prepare('SELECT posicion FROM canciones WHERE posicion=:pos and album=:cod;');
            $result3->bindParam(':pos', $_POST['position']);
            $result3->bindParam(':cod', $_POST['album']);
            $result3->execute();

            if(count($result3->fetchAll())!=0){
                $errors['position'] = 'Existe ya esta posición';
            }else{
                $cancion = $conection->prepare('INSERT INTO canciones (titulo,album,duracion,posicion) VALUES (:title,:album,:duration,:position);');
                $cancion->bindParam(':title', $_POST['title']);
                $cancion->bindParam(':album', $_POST['album']);
                $cancion->bindParam(':duration', $_POST['duration']);
                $cancion->bindParam(':position', $_POST['position']);
            }
        }

        
        

        $group = $result->fetch();
        echo 'Nombre grupo: ' . $group['nombre'];
        echo '<br>';
        echo 'Nombre album: ' . $group['titulo'];
        echo '<br><br>';

        echo '<table border="">';
        echo '<tr>
                <td>Titulo</td>
                <td>Duracion</td>
                <td>Posición</td>
            </tr>';
        foreach ($result2->fetchAll() as $canciones) {
            echo '<tr>';
            echo '<td>';
            echo '<p>Cancion: ' . $canciones['titulo']. '</p>' ;
            echo ' <a href="/album/' . $_GET['id'] . '/delete/' . $canciones['codigo'] . '">🗑️</a>';
            echo '</td>';
            $minutos = floor(($canciones['duracion']) / 60);
            $segundos = $canciones['duracion'] - ($minutos * 60);
            echo '<td>' . $minutos . ' m ' . $segundos . ' s</td>';
            echo '<td>' . $canciones['posicion'] . 'º</td>';
            echo '</tr>';
        }
        echo '</table>';
        echo '<br>';

        if (isset($_POST['title'])) {
            if (count($errors) < 1) {
                $cancion->execute();
                header('Location: /album/' . $_GET['id']);
                exit;
            }
        }

        unset($result);
        unset($conection);

        echo '<form action="#" method="post" enctype="multipart/form-data">';           
            if (isset($_POST['title'])) {
                if (count($errors) < 1) {
                    header('Location: /album/' . $_GET['id']);
                    exit;
                }
            } 
            echo '<br> Título: <input type="text" name="title"><br>'; // Los siguiente if se encargan de crear los input para cada apartado
            if (isset($errors['title'])) {
                echo '<p class="error_login">'. $errors['title'] . '</p><br>';
            }

            echo '<input type="hidden" name="album" value="' . $_GET['id'] . '">';
                        
            echo '<br> Duración: <input type="text" name="duration"><br>';  
            if (isset($errors['duration'])) {
                echo '<p class="error_login">'. $errors['duration'] . '</p><br>';
            }

            echo '<br> Posición: <input type="text" name="position"><br>';
            if (isset($errors['position'])) {
                echo '<p class="error_login">'. $errors['position'] . '</p><br>';
            }

                echo '<br>';
                echo '<br>';
                echo '<input type="submit" value="Enviar">';     
        echo '</form>';

        echo '<a href="/group/' . $group['codigo'] . '">Volver</a>';
    ?>

</body>

</html>