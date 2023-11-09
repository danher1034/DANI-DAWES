<?php
/**
 * @author Dani Agullo Heredia
 * @version 1.0
 */
require_once(__DIR__.'/includes/users.inc.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Index</title>
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
  <?php
    foreach($users as $user){
      echo $user;
    }
  ?>  
  
</body>
</html>
