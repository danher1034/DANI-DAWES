<?php
/**
 * @author Dani Agullo Heredia
 * @version 1.0
 */
    require_once(__DIR__.'/includes/utils.inc.php');
    require_once(__DIR__.'/includes/Person.inc.php');
    require_once(__DIR__.'/includes/Mechanic.inc.php');
    require_once(__DIR__.'/includes/Rider.inc.php');
    require_once(__DIR__.'/includes/GrandPrix.inc.php');
    require_once(__DIR__.'/includes/Circuit.inc.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>.team{display: inline-block;margin-right: 20px;}</style>
</head>
<body>
    <?php

        foreach($teams as $team){
            for ($i = 0; $i < 2; $i++) {
                $Mechanic = new Mechanic(randomName(),randomBirthday(),randomSpeciality());
                $team->addMechanic($Mechanic);
                $Rider = new Rider(randomName(),randomBirthday(),randomDorsal($dorsals));
                $team->addRider($Rider);
                $Riders[]= $Rider;
            }
        }

        foreach($teams as $value){
            echo '<div class="team">';
                echo $value;
            echo '</div>';
        }

        
        $prix[]=new GrandPrix(mktime(0,0,0,rand(1,12),rand(1,31),rand(2023,2024)),$circuits[0]);
        $prix[]=new GrandPrix(mktime(0,0,0,rand(1,12),rand(1,31),rand(2023,2024)),$circuits[1]);
        $prix[]=new GrandPrix(mktime(0,0,0,rand(1,12),rand(1,31),rand(2023,2024)),$circuits[2]);

        foreach($prix as $circuit){
            foreach($Riders as $rider){
                $position=rand(1,count($Riders));
                $circuit->addRider($rider,$position);
            }
        }


        foreach($prix as $values){
            echo '<div>';
                echo $values;
            echo '</div>';
        }



    ?>
</body>
</html>