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
        <a href="index.php">
            <h1>Discografía - Dani Agullo Heredia</h1>
        </a>
        <?php
        $bd = 'discografia';
        $user = 'vetustamorla';
        $pass = '15151';
        $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
        $conection = bdconection($bd, $user, $pass, $options);

        if (isset($_GET['delete'])) {
            $groupCodeToDelete = $_GET['delete'];
            $deleted = $conection->exec('DELETE c, a, g FROM canciones c LEFT JOIN albumes a on c.album = a.codigo LEFT JOIN grupos g on g.codigo = a.grupo where g.codigo = ' . $groupCodeToDelete);
        }

        $result = $conection->query('SELECT * FROM grupos;');

        $group = $conection->prepare('INSERT INTO grupos (nombre,genero,pais,inicio) VALUES (:names,:gender,:country,:dates);');
        $group->bindParam(':names',$_POST['name']);
        $group->bindParam(':gender',$_POST['gender']);
        $group->bindParam(':country',$_POST['country']);
        $group->bindParam(':dates',$_POST['date']);

        foreach ($result->fetchAll() as $names) {
            echo '<a href="group/' . $names['codigo'] . '">' . $names['nombre'] . '</a>';
            echo ' <a href="index.php?delete=' . $names['codigo'] . '">🗑️</a>';
            echo '<br>';
        }
        
        echo '<br>';

        if (isset($_POST['name'])) {
            if (count($errors) < 1) {
                $group->execute();
                header('Location: index.php');
                exit;
            }
        }
        
        echo '<form action="#" method="post" enctype="multipart/form-data">';           
            if (isset($_POST['name'])) {
                if (count($errors) < 1) {
                    header('Location: index.php');
                    exit;
                }
            }
            echo '<br> Nombre: <input type="text" name="name"><br>'; // Los siguiente if se encargan de crear los input para cada apartado
            if (isset($errors['name'])) {
                echo '<p class="error_login">'. $errors['name'] . '</p><br>';
            }
                        
            echo '<br> Genero: <input type="text" name="gender"><br>';  
            if (isset($errors['gender'])) {
                echo '<p class="error_login">'. $errors['gender'] . '</p><br>';
            }

            echo '<br> Pais: <input type="text" name="country"><br>';
            if (isset($errors['country'])) {
                echo '<p class="error_login">'. $errors['country'] . '</p><br>';
            }

            echo '<br> Fecha: <input type="text" name="date"><br>';
            if (isset($errors['date'])) {
                echo '<p class="error_login">'. $errors['date'] . '</p><br>';
            }
                echo '<br>';
                echo '<br>';
                echo '<input type="submit" value="Enviar">';     
        echo '</form>';
              
        ?>
    </body>
</html>