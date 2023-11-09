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
    <nav class="navbar" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <img src="img/logo-revels.png" alt="Logo" width="55" height="50">
            </a>
            <h1>Revels</h1>
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </nav>
    <aside class="sidebar">SIDEBAR</aside>
    <article class="main">
    <?php
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
    ?>
    </article>
    <footer class="footer">FOOTER</footer>
</body>
</html>