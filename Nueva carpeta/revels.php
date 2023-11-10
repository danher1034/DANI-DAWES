<?php
/**
 * @author Dani Agullo Heredia
 * @version 1.0
 */
require_once(__DIR__.'/includes/User.inc.php');
require_once(__DIR__.'/includes/regularExpression.php');
require_once(__DIR__ . '/includes/bdconect.inc.php');

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://fonts.cdnfonts.com/css/healing-lighters" rel="stylesheet">
</head>
<body class="body-revels">
    <nav class="navbar">
            <a class="navbar-brand" href="index.php">
                <img src="img/logo-revels.png" alt="Logo" width="55" height="50">
            </a>
            <h1>Revels</h1>
            <form class="nav_form">
                <input type="text" placeholder="Buscar...">
                <button><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
    </nav>
    <aside class="sidebar">SIDEBAR</aside>
    <article class="main">
    <?php
        
    ?>
    </article>
    <footer class="footer">FOOTER</footer>
</body>
</html>