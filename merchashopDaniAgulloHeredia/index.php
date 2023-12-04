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
// Verifica si el usuario ha iniciado sesión
if (isset($_SESSION['logged'])) { 
	// Verifica si se ha solicitado alguna acción con la cesta de compras (añadir, restar, eliminar)
	if (isset($_GET['add']) || isset($_GET['subtract']) || isset($_GET['remove'])) {
		if (isset($_GET['add']) && $_GET['add'] != '') {
			// Verifica si el artículo aún no está en la cesta, luego lo añade; de lo contrario, aumenta la cantidad
			if (!isset($_SESSION['basket'][$_GET['add']]))
				$_SESSION['basket'][$_GET['add']] = 1;
			else
				$_SESSION['basket'][$_GET['add']] += 1;
		}
		// Si se solicita la acción 'subtract'
		if (isset($_GET['subtract']) && $_GET['subtract'] != '' && isset($_SESSION['basket'][$_GET['subtract']])) {
			$_SESSION['basket'][$_GET['subtract']] -= 1;
			// Disminuye la cantidad y elimina si se vuelve cero o menos
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
	// Incluye el archivo de encabezado
	require_once('includes/header.inc.php');
	// Verifica si el usuario no ha iniciado sesión
	if (!isset($_SESSION['logged'])) {
		// Muestra el formulario de registro
		echo '<div class="container">
		<div class="box form-box">';
		echo '<div class="tittle-login">
				<h1>'.$index_merchashop['singup'].'</h1>
			</div>';
		echo '<form action="/signup.php" method="post" enctype="multipart/form-data">';
		// Campo de entrada para el correo electrónico
			echo '<div class="field input">';
			echo '<br><label for="mail">Mail:</label> <input type="text" name="mail"><br>'; // Los siguiente if se encargan de crear los input para cada apartado
			echo '</div>';
	// Campo de entrada para el nombre de usuario
			echo '<div class="field input">';
			echo '<br><label for="user">'.$index_merchashop['name'].'</label> <input type="text" name="user"><br>';
			echo '</div>';
	// Campo de entrada para la contraseña
			echo '<div class="field input">';
			echo '<br><label for="password">'.$index_merchashop['password'].'</label> <input type="text" name="password"><br>';
			echo '</div>';
	// Botón de envío del formulario de registro
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
		// Muestra la cantidad de productos en el carrito
		echo $products;
		echo ' ';
		echo $index_merchashop['product'];
		if ($products > 1)
			echo 's';

		$index_merchashop['in_basket'];
		?>
		<!-- Enlace para ver el contenido del carrito -->
		<a href="/basket" class="boton"><?=$index_merchashop['see_basket']?></a>
	</div>

	<section class="productos">
		<?php
		require_once('includes/dbconnection.inc.php');
		$connection = getDBConnection();
		$products = $connection->query('SELECT * FROM products;', PDO::FETCH_OBJ);

		foreach ($products as $product) {
			// Muestra información de cada producto en la base de datos
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