<?php
/**
 * @author Dani Agullo Heredia
 * @version 1.0
 */
    $langua=['es'=>'Español','en'=>'English','ca'=>'Valencià']; // El array sigue la siguiente estructura la key la abreviación del idioma y el value el idoma
    if(isset($_COOKIE['language'])){ // comprueba si existe la cookie de idioma
        if(array_key_exists($_COOKIE['language'], $langua)){ //si la cookie tiene un valor que exista una key en el array $langua igual
            require_once(__DIR__ . '/lang/header/header.'.$_COOKIE['language'].'.inc.php');
        }
    }else{
        require_once(__DIR__ . '/lang/header/header.es.inc.php'); // se pondra el español por defecto en caso de no haber cookie creada
    }

    if (isset($_SESSION['logged'])) { // si existe la valiable de session con el campo de logueado y mostrará el menu del usuario
				echo '<aside class="sidebar-accounts"> 
					<br><div class="account_div">
						<span id="user_account_text"><i class="fa-solid fa-user"></i>' .  $_SESSION['user'] . '</span>
							<div class="account-content">';
				if ($_SESSION['rol'] == 'admin') { // si el rol de admin muestra también la opción del usuario
					echo '<a href="/user">'.$header_merchashop['user'].'</a>';
				}
				echo ' <a href="/logout">'.$header_merchashop['logout'].'</a>
							</div>
						</div>
					</aside>
                    <br>';
    }
?>
<header>
    <h1><a href="/index"><?=$header_merchashop['title']?></a></h1> <!-- Dentro de $header_merchashop estara el texto traducido -->
    <a href="/index"><?=$header_merchashop['index_return']?></a>
    <a href="/sales"><?=$header_merchashop['sales']?></a>
    <br><br>
    <div class="language">
    <?php
    foreach($langua as $key => $value){ //recorro el array para crear enlaces para cada idioma
        echo '<a href="/'.basename($_SERVER['PHP_SELF']).'?language='.$key.'"><img src="/img/flags/'.$key.'.png" alt="'.$value.'"></a>'; // con la key colocaré el valor de language y pondrá la imagen con el nombre relacionado, y tambien con value colocare el alt de la imagen
    } ?>
    </div>
</header>