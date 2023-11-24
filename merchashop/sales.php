<?php

/**
 *	Script que implementa un carrito de la compra con variables de sesión
 * @author Dani Agullo Heredia
 * @version 1.0
 */
require_once(__DIR__ . '/includes/dbconnection.inc.php');
session_start();
$connection = getDBConnection();

if (isset($_SESSION['logged'])) {
	echo '<aside class="sidebar-accounts">
		<br><div class="account_div">
            <span id="user_account_text"><i class="fa-solid fa-user"></i>' .  $_SESSION['user'] . '</span>
                <div class="account-content">';
	if ($_SESSION['rol'] == 'admin') {
		echo '<a href="/index">Usuarios</a>';
	}
	echo ' <a href="/logout">Cerrar sesión</a>
                </div>
            </div>
		</aside>';

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
	<?php
	require_once('includes/header.inc.php');

	?>

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
			echo '<span>' . $product->price . ' €</span><br>';
			echo '<span>Stock: ' . $product->stock . '</span>';
			echo '</article>';
		}

		unset($products);
		unset($connection);
		
	echo '</section>';
	?>
</body>

</html>