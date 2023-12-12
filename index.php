<?php
    /**
    * Actividad 3 - API RESTful Rick & Morty
    * @author Dani Agullo Heredia
    * @version 1.0
    */
    require_once(__DIR__.'/includes/header.inc.php')
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rick & Morty</title>
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://fonts.cdnfonts.com/css/healing-lighters" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <?php
        if(isset($_GET['rick'])){ //si recibe $_GET['rick']
            $endpoint='https://rickandmortyapi.com/api/character/?name=rick'; //creo Endpoint con la consulta a la api y sus resultados
            $data=file_get_contents($endpoint); //guardamos en data los resultados de la api
            $data=json_decode($data); //decodificamos el json
        }elseif(isset($_GET['morty'])){//si recibe $_GET['morty']
            $endpoint='https://rickandmortyapi.com/api/character/?name=morty';//creo Endpoint con la consulta a la api y sus resultados
            $data=file_get_contents($endpoint);//guardamos en data los resultados de la api
            $data=json_decode($data); //decodificamos el json 
        }

        if (isset($data->results)) {// Recorrer $data todos los resultados
            foreach ($data->results as $character) {
                if (isset($character->name, $character->image)) { // Verificar si las claves 'name' e 'image' existen en el objeto actual                   
                    $characters[] = array( // Agregar el nombre y la imagen al array 'characters'
                        'name' => $character->name,
                        'image' => $character->image,
                    );
                }
            }
        }

        
        while (isset($data->info->next) && $data->info->next !== null) { // Iniciar un bucle que se repetirá mientras exista una próxima página
            // Obtener la siguiente página
            $endpoint = $data->info->next;
            $data = file_get_contents($endpoint);
            $data = json_decode($data);

            // Recorrer los resultados de la página actual y agregar al array 'characters'
            foreach ($data->results as $character) {
                if (isset($character->name, $character->image)) {
                    $characters[] = array(
                        'name' => $character->name,
                        'image' => $character->image,
                    );
                }
            }
        }

        echo '<div class="characters">';
            foreach ($characters as $character) {
                echo '<div class="characters">
                <div class="character">
                    <h3>'.$character['name'].'</h3>
                    <img src="'.$character['image'].'" alt="'.$character['name'].'">
                </div>';
            }
        echo ' </div>';
    ?>
    
</body>
</html>