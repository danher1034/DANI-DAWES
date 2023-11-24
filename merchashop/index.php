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
		echo '<a href="/user">Usuarios</a>';
	}
	echo ' <a href="/logout">Cerrar sesión</a>
                </div>
            </div>
		</aside>';



	if (isset($_GET['add']) || isset($_GET['subtract']) || isset($_GET['remove'])) {
		if (isset($_GET['add']) && $_GET['add'] != '') {
			if (!isset($_SESSION['basket'][$_GET['add']]))
				$_SESSION['basket'][$_GET['add']] = 1;
			else
				$_SESSION['basket'][$_GET['add']] += 1;
		}
		if (isset($_GET['subtract']) && $_GET['subtract'] != '' && isset($_SESSION['basket'][$_GET['subtract']])) {
			$_SESSION['basket'][$_GET['subtract']] -= 1;
			if ($_SESSION['basket'][$_GET['subtract']] <= 0)
				unset($_SESSION['basket'][$_GET['subtract']]);
		}
		if (isset($_GET['remove']) && $_GET['remove'] != '' && isset($_SESSION['basket'][$_GET['remove']])) {
			unset($_SESSION['basket'][$_GET['remove']]);
		}

		//header('location: /');
	}
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
	if (!isset($_SESSION['logged'])) {
		echo '<div class="container">
		<div class="box form-box">';
		echo '<div class="tittle-login">
				<h1>Regístrate en Merchshop</h1>
			</div>';
		echo '<form action="/signup.php" method="post" enctype="multipart/form-data">';
		if (isset($_POST['user'])) {
			if (count($errors) < 1) {
				header('Location:/index');
				exit;
			}
		}
			echo '<div class="field input">';
			echo '<br><label for="mail">Mail:</label> <input type="text" name="mail"><br>'; // Los siguiente if se encargan de crear los input para cada apartado
			if (isset($errors['mail'])) {
				echo '<p class="error_login">' . $errors['mail'] . '</p><br>';
			}
			echo '</div>';
	
			echo '<div class="field input">';
			echo '<br><label for="user">Nombre:</label> <input type="text" name="user"><br>';
			if (isset($errors['user'])) {
				echo '<p class="error_login">' . $errors['user'] . '</p><br>';
			}
			echo '</div>';
	
			echo '<div class="field input">';
			echo '<br><label for="password">Contraseña:</label> <input type="text" name="password"><br>';
			if (isset($errors['password'])) {
				echo '<p class="error_login">' . $errors['password'] . '</p><br>';
			}
			echo '</div>';
	
			echo '<div class="field">';
			echo '<input type="submit" class="btn" value="Registrarse">';
			echo '</div>';
		echo '</form>

                <br>
                <div class="sign-inup" >
                    <p>¿Tienes cuenta en revels?</p>
                    <a href="/login" class="btn-session">Inicia sesión</a>
                </div>
				</div>';
	} else {
	?>

	<div id="carrito">
		<?php
		if (!isset($_SESSION['basket']))
			$products = 0;
		else
			$products = count($_SESSION['basket']);
		echo $products;
		echo ' producto';
		if ($products > 1)
			echo 's';
		?>
		en el carrito.

		<a href="/basket" class="boton">Ver carrito</a>
	</div>

	<section class="productos">
		<?php
		require_once('includes/dbconnection.inc.php');
		$connection = getDBConnection();
		$products = $connection->query('SELECT * FROM products;', PDO::FETCH_OBJ);

		foreach ($products as $product) {
			echo '<article class="producto">';
			echo '<h2>' . $product->name . '</h2>';
			echo '<span>(' . $product->category . ')</span>';
			echo '<img src="/img/products/' . $product->image . '" alt="' . $product->name . '" class="imgProducto"><br>';
			echo '<span>' . $product->price . ' €</span><br>';
			echo '<span class="botonesCarrito">';
			echo '<a href="/add/' . $product->id . '" class="productos"><img src="/img/mas.png" alt="añadir 1"></a>';
			echo '<a href="/subtract/' . $product->id . '" class="productos"><img src="/img/menos.png" alt="quitar 1"></a>';
			echo '<a href="/remove/' . $product->id . '" class="productos"><img src="/img/papelera.png" alt="quitar todos"></a>';
			echo '</span>';
			echo '<span>Stock: ' . $product->stock . '</span>';
			echo '</article>';
		}

		unset($products);
		unset($connection);
		
	echo '</section>';
	}
	?>
</body>

</html>