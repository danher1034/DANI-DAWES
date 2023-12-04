<?php
/**
 *	Script que implementa un carrito de la compra con variables de sesión
 * @author Dani Agullo Heredia
 * @version 1.0
 */
require_once(__DIR__ . '/includes/dbconnection.inc.php');
require_once(__DIR__ . '/autologin.php');
session_start();
$connection = getDBConnection();
require_once(__DIR__ . '/includes/setcookie.inc.php');
require_once(__DIR__ . '/includes/header.inc.php');	

if(isset($_COOKIE['language'])){ // comprueba si existe la cookie de idioma
	if(array_key_exists($_COOKIE['language'], $langua)){ //si la cookie tiene un valor que exista una key en el array $langua igual
		require_once(__DIR__ . '/includes/lang/sales/sales.'.$_COOKIE['language'].'.inc.php');
	}
}else{
	require_once(__DIR__ . '/includes/lang/sales/sales.es.inc.php'); // se pondra el español por defecto en caso de no haber cookie creada
}

?>
<!doctype html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>MerchaShop</title>
	<link rel="stylesheet" href="/css/style.css">
</head>

<body>
	<section class="productos">
		<?php
		require_once('includes/dbconnection.inc.php');
		$connection = getDBConnection();
		$products = $connection->query('SELECT * FROM products where sale>0;', PDO::FETCH_OBJ);

		foreach ($products as $product) {
			echo '<article class="producto">';
			echo '<h2>' . $product->name . '</h2>';
			echo '<span>(' . $product->category . ')</span>';
			echo '<img src="/img/products/' . $product->image . '" alt="' . $product->name . '" class="imgProducto"><br>';
			echo '<span>' . number_format(($product->price)*$sales_merchashop['coin_value'],2) . ' '.$sales_merchashop['coin'].'</span><br>';
			echo '<span>Stock: ' . $product->stock . '</span>';
			echo '</article>';
		}

		unset($products);
		unset($connection);
		
	echo '</section>';
	?>
</body>

</html>