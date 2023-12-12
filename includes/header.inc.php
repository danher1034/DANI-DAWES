<?php
/**
 * Actividad 3 - API RESTful Rick & Morty
 * @author Dani Agullo Heredia
 * @version 1.0
 */
?>
<header>
    <a href="/index.php?rick"><h2>Rick</h2></a>
    <a href="/index.php?morty"><h2>Morty</h2></a>  
    <form action="index.php" class="nav_form" method="post" class="coment_form" enctype="multipart/form-data">
        <label for="search"></label> 
        <input class="input-nav" name="search" name="search" type="text" placeholder="Buscar...">
        <button class="button-nav" type="submit" id="comment"><i class="fa-solid fa-magnifying-glass"></i></button>
    </form>
    <?php
        if (isset($_POST['search'])&&strlen($_POST['search'])<1) {
            echo 'Tienes que introducir algo';
        }
    ?>
</header>