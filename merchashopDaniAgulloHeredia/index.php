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
		require_once(__DIR__ . '/includes/lang/index/index.'.$_COOKIE['language'].'.inc.php');
	}
}else{
	require_once(__DIR__ . '/includes/lang/index/index.es.inc.php'); // se pondra el español por defecto en caso de no haber cookie creada
}

if (isset($_SESSION['logged'])) { 

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
				<h1>'.$index_merchashop['singup'].'</h1>
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
			echo '<br><label for="user">'.$index_merchashop['name'].'</label> <input type="text" name="user"><br>';
			if (isset($errors['user'])) {
				echo '<p class="error_login">' . $errors['user'] . '</p><br>';
			}
			echo '</div>';
	
			echo '<div class="field input">';
			echo '<br><label for="password">'.$index_merchashop['password'].'</label> <input type="text" name="password"><br>';
			if (isset($errors['password'])) {
				echo '<p class="error_login">' . $errors['password'] . '</p><br>';
			}
			echo '</div>';
	
			echo '<div class="field">';
			echo '<input type="submit" class="btn" value="'.$index_merchashop['sigup_submit'].'">';
			echo '</div>';
		echo '</form>

                <br>
                <div class="sign-inup" >
                    <p>'.$index_merchashop['revel_account'].'</p>
                    <a href="/login" class="btn-session">'.$index_merchashop['login'].'</a>
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
		echo ' ';
		echo $index_merchashop['product'];
		if ($products > 1)
			echo 's';

		$index_merchashop['in_basket'];
		?>
		
		<a href="/basket" class="boton"><?=$index_merchashop['see_basket']?></a>
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
			echo '<span>' . number_format(($product->price)*$index_merchashop['coin_value'],2) . ' '.$index_merchashop['coin'].'</span><br>';
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