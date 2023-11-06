<?php
    /**
     * @author Dani Agullo Heredia
     * @version 1.0
     */
    require_once(__DIR__ . '/include/bdconect.inc.php');
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

        $result = $conection->query('SELECT * FROM grupos;');

        foreach ($result->fetchAll() as $names) {
            echo '<a href="group/' . $names['codigo'] . '">' . $names['nombre'] . '</a>';
            echo '<br>';
        }
        echo '<br>';
        
        echo '<form action="#" method="post" enctype="multipart/form-data">';           
                        if (isset($_POST['user'])) {
                            if (count($errors) < 1) {
                                header('Location: /index.php');
                                exit;
                            }
                        }
                        echo '<br> Mail o Teléfono: <input type="text" name="mail|phone"><br>'; // Los siguiente if se encargan de crear los input para cada apartado
                        if (isset($errors['mail|phone'])) {
                            echo '<p class="error_login">'. $errors['mail|phone'] . '</p><br>';
                        }
                        echo '<br> Nombre: <input type="text" name="name"><br>';
                        if (isset($errors['name'])) {
                            echo '<p class="error_login">'. $errors['name'] . '</p><br>';
                        }
                        echo '<br>Usuario: <input type="text" name="user"><br>';  
                        if (isset($errors['user'])) {
                            echo '<p class="error_login">'. $errors['user'] . '</p><br>';
                        }
                        echo '<br> Contraseña : <input type="text" name="password"><br>';
                        if (isset($errors['password'])) {
                            echo '<p class="error_login">'. $errors['password'] . '</p><br>';
                        }
                        echo '<br>';
                        echo '<br>';
                        echo '<input type="submit" value="Enviar">';     
                echo '</form>';
        ?>
    </body>
</html>