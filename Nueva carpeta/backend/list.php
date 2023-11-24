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
    
    require_once('../includes/regularExpression.php');
    require_once(__DIR__.'/includes/header.inc.php'); 
        
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/css/styles.css">
    <link href="https://fonts.cdnfonts.com/css/healing-lighters" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="body-list">

    <article class="main2">
        <?php           
            foreach ($revels as $info) {
                echo '<div class="container-main-account"> 
                        <div class="title-main-account">
                            <h3>'.$user_name['usuario'].'</h3>
                            <a href="/delete/' . $info['id'] . '"><i class="fa-solid fa-trash" id="delete-list"></i></a>
                        </div>
                        <div class="body-main-user">
                            <a href="/revel/'.$info['id'].'" id="enlace_userRevel">
                                 <p>'.$info['texto'].'</p>
                            </a>
                        </div>
                    </div>
                    <hr>';
            }
        ?>   
    </article>
</body>
</html>