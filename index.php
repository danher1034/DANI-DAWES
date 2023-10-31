<?php
/**
 * @author Dani Agullo Heredia
 * @version 1.0
 */
    require_once(__DIR__.'/includes/utils.inc.php');
    require_once(__DIR__.'/includes/Person.inc.php');
    require_once(__DIR__.'/includes/Mechanic.inc.php');
    require_once(__DIR__.'/includes/Rider.inc.php');
    

    foreach($teams as $team){
        for ($i = 1; $i < 2; $i++) {
            $Mechanic = new Mechanic(randomName(),randomBirthday(),randomSpeciality());
            $team = $Mechanic;
            $Rider = new Rider(randomName(),randomBirthday(),randomDorsal($dorsals));
            $team=$Rider;
        }
    }


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        print_r($team);
    ?>
</body>
</html>