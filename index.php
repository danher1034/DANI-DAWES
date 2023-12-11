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
</head>
<body>
    <?php
        if(isset($_GET['rick'])){
            $endpoint='https://rickandmortyapi.com/api/character/?name=rick';
            $data=file_get_contents($endpoint);
            $data=json_decode($data);
        }elseif(isset($_GET['morty'])){
            $endpoint='https://rickandmortyapi.com/api/character/?name=morty';
            $data=file_get_contents($endpoint);
            $data=json_decode($data);
             
        }

        if(isset($data)){
            foreach($data->$results as $name_value){
                $characters[
                    'name'=$name_value->$name
                    'image'=$name_value->$name
                ]           
            }
        }
    ?>
</body>
</html>