<?php
/**
 * @author Dani Agullo Heredia
 * @version 1.0
 */

if(isset($_GET['language'])){ // comprueba si ha llegado language por get
	setcookie('language', $_GET['language'], httponly: true); //crea la cookie con el prefijo del idioma
	header('Location:'.$_SERVER['PHP_SELF']);
	exit;
} 