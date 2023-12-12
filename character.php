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
        if(isset($_GET['id'])){ //si recibe $_GET['rick']
            $endpoint='https://rickandmortyapi.com/api/character/'.$_GET['id']; //creo Endpoint con la consulta a la api y sus resultados
            $data=file_get_contents($endpoint); //guardamos en data los resultados de la api
            $data=json_decode($data); //decodificamos el json
        }

        if (isset($data)) {
            echo '<div class="character">';
            
            foreach ($data as $key => $value) {
                if (is_array($value) || is_object($value)) {
                    if($key='image'){
                        echo '<img src="' . $value. '" alt="' . $data->name . '">';
                    }else{
                        echo '<p>' . $key . ': <br>';
                        // Handle nested arrays or objects
                        foreach ($value as $subKey => $subValue) {
                            if (is_array($subValue) || is_object($subValue)) {
                                foreach ($subValue as $subItemKey => $subItemValue) {
                                    echo $subItemKey . ': ' . $subItemValue . ', ';
                                }
                            } else {
                                echo $subKey . ': ' . $subValue . ', ';
                                echo '<br>';
                            }
                        }
                        echo '</p>';
                    }
                } else {
                    // Display other key-value pairs
                    echo '<p>' . $key . ': ' . $value . '</p>';
                }    
                echo '<br>';
            }
            echo '</div>';
        }