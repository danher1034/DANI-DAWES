<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://fonts.cdnfonts.com/css/healing-lighters" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="body-user">
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
    <aside class="sidebar">
            <img src="Idyd_Roberto-Dupuis-600.png" alt="" height="30%" >
            <br>
            <br>
            <h3>Manolo</h3>
            <br>
            <div class="followers">
                <p class="revels">6 revels</p>
                <p class="follower">166 seguidores</p>
                <p class="follows">168 seguidos</p>
            </div>
            <p>Manolo El Manuelas <br>
               Diseñador de los manolitos <br>
               Manolo El crack</p>
    </aside>
    <article class="main">
        <?php
        for($i=0;$i<8;$i++){
            echo '<div class="container-main-user">
                    <div class="title-main-user">
                        <h4>Dani Agullo Heredia</h4>
                    </div>
                    <div class="body-main-user">
                        <p>Roldan es un gitano de los valles y Marcos lo predijo</p>
                    </div>
                    <div class="buttons-main-user">
                        <button type="button"><i class="fa-regular fa-heart" style="color: #1e3050;"></i></button><p>300</p>
                        <button type="button"><i class="fa-solid fa-heart-crack"></i></button><p>30</p>
                        <button type="button"><i class="fa-regular fa-comment-dots"></i></button><p>200</p>
                    </div>
                </div>
                <hr>';
        }
        ?>   
    </article>
    <footer class="footer">FOOTER</footer>
</body>
</html>