<?php

/**
 *	Script que implementa un carrito de la compra con variables de sesión
 * @author Dani Agullo Heredia
 * @version 1.0
 */
require_once(__DIR__ . '/includes/dbconnection.inc.php');
session_start();
$connection = getDBConnection();

if (isset($_SESSION['logged'])&&$_SESSION['rol'] == 'admin') {

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
		$users = $connection->query('SELECT * FROM users ;', PDO::FETCH_OBJ);

		foreach ($users as $user) {
			echo '<article class="producto">';
			echo '<h2>' . $user->user . '</h2>';
            echo '<h2>' . $user->email . '</h2>';
            echo '<h2>' . $user->rol . '</h2>';
			echo '</article>';
		}

		unset($users);
		unset($connection);
		
	echo '</section>';
}
?>
</body>

</html>