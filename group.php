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

    if (isset($_GET['action'])) {
        $deleted = $conection->exec('DELETE c, a FROM canciones c LEFT JOIN albumes a on c.album = a.codigo where a.codigo =' . $_GET['action']);
    }

    $result = $conection->prepare('SELECT * FROM grupos WHERE codigo=:nomb;');
    $result->bindParam(':nomb', $_GET['id']);
    $result->execute();

    $result2 = $conection->prepare('SELECT titulo,anyo,formato,fechacompra,precio,grupo,codigo FROM albumes WHERE grupo=:cod;');
    $result2->bindParam(':cod', $_GET['id']);
    $result2->execute();

    $albums = $conection->prepare('INSERT INTO albumes (titulo,grupo,anyo,formato,fechacompra,precio) VALUES (:title,:group,:years,:formats,:datebuy,:price);');
    $albums->bindParam(':title', $_POST['title']);
    $albums->bindParam(':group', $_POST['group']);
    $albums->bindParam(':years', $_POST['years']);
    $albums->bindParam(':formats', $_POST['formats']);
    $albums->bindParam(':datebuy', $_POST['datebuy']);
    $albums->bindParam(':price', $_POST['price']);

    $group = $result->fetch();
    echo $group['nombre'];
    echo '<br><br>';

    echo '<table border="">';
    foreach ($result2->fetchAll() as $album) {
        echo '<tr>
                <td>Titulo</td>
                <td>Año</td>
                <td>Formato</td>
                <td>Fecha de compra</td>
                <td>Precio</td>
             </tr>';
        echo '<tr>';
            echo '<td>';
                echo '<a href="/album/' . $album['codigo'] . '">' . $album['titulo'] . '</a>';
                echo ' <a href="/group/' . $_GET['id'] . '/delete/' . $album['codigo'] . '">🗑️</a>';
            echo '</td>';
            echo '<td>' . $album['anyo'] . '</td>';
            echo '<td>' . $album['formato'] . '</td>';
            echo '<td>' . $album['fechacompra'] . '</td>';
            echo '<td>' . $album['precio'] . '</td>';
        echo '<tr>';
    }
    echo '</table>';

    if (isset($_POST['title'])) {
        if (count($errors) < 1) {
            $albums->execute();
            header('Location: /group/' . $_GET['id']);
            exit;
        }
    }

    echo '<form action="#" method="post" enctype="multipart/form-data">';
    if (isset($_POST['title'])) {
        if (count($errors) < 1) {
            header('Location: /group/' . $_GET['id']);
            exit;
        }
    }

    echo '<br> Título: <input type="text" name="title"><br>'; // Los siguiente if se encargan de crear los input para cada apartado
    if (isset($errors['title'])) {
        echo '<p class="error_login">' . $errors['title'] . '</p><br>';
    }

    echo '<input type="hidden" name="group" value="' . $_GET['id'] . '">';


    echo '<br> Año: <input type="text" name="years"><br>';
    if (isset($errors['years'])) {
        echo '<p class="error_login">' . $errors['years'] . '</p><br>';
    }


    echo '<br> Formato: <select name="formats">
                            <option value="vinilo">vinilo</option>
                            <option value="cd">cd</option>
                            <option value="dvd">dvd</option>
                            <option value="mp3">mp3</option>                            
                        </select><br>';

    echo '<br> Fecha de compra: <input type="text" name="datebuy"><br>';
    if (isset($errors['datebuy'])) {
        echo '<p class="error_login">' . $errors['datebuy'] . '</p><br>';
    }

    echo '<br> Precio: <input type="text" name="price"><br>';
    if (isset($errors['price'])) {
        echo '<p class="error_login">' . $errors['price'] . '</p><br>';
    }
    echo '<br>';
    echo '<br>';
    echo '<input type="submit" value="Enviar">';
    echo '</form>';

    ?>
    <br>
    <a href="/index.php">Volver Atrás</a>
</body>

</html>