<?php
/**
 *	Script que implementa un carrito de la compra con variables de sesión
 * @author Dani Agullo Heredia
 * @version 1.0
 */

session_start();
?>
<!doctype html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>MerchaShop - carrito</title>
		<link rel="stylesheet" href="/css/style.css">
	</head>

	<body>	
		<?php

			if (isset($_SESSION['logged'])) {
				echo '<aside class="sidebar-accounts">
					<br><div class="account_div">
						<span id="user_account_text"><i class="fa-solid fa-user"></i>' .  $_SESSION['user'] . '</span>
							<div class="account-content">';
				if ($_SESSION['rol'] == 'admin') {
					echo '<a href="/user">Usuarios</a>';
				}
				echo ' <a href="/logout">Cerrar sesión</a>
							</div>
						</div>
					</aside>';

					require_once('includes/header.inc.php');
		?>

		<h2>Carrito</h2>

		<section>
			<?php
			if(!isset($_SESSION['basket']) || count($_SESSION['basket'])==0)
				echo '<div>El carrito está vacío.</div>';
			else 
			{
				require_once('includes/dbconnection.inc.php');
				$connection = getDBConnection();

				$basketTotal = 0;

				echo '<table>';
				echo '<tr><td>Producto</td><td>Unidades</td><td>Precio</td><td>Subtotal</td></tr>';
				foreach($_SESSION['basket'] as $productId => $quantity) {
					$product = $connection->query('SELECT name, price FROM products WHERE id='. $productId .';', PDO::FETCH_OBJ);
					$product = $product->fetch();
					echo '<tr>';
					echo '<td>'. $product->name .'</td>';
					echo '<td>'. $quantity .'</td>';
					echo '<td>'. $product->price .' €/unidad</td>';
					echo '<td>'. $quantity*$product->price .' €</td>';

					$basketTotal += $product->price * $quantity;
					
					echo '</tr>';
				}
				
				echo '<tr><td></td><td></td><td>Total</td><td>'. $basketTotal .' €</td></tr>';
				echo '</table>';
				
				unset($product);
				unset($connection);
			}
		}
			?>
			<br><br>
			<a href="/index" class="boton">Volver</a>				
		</section>
	</body>
</html>