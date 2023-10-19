<?php
/**
 * @author Dani Agullo Heredia
 * @version 1.0
 */
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
        $dir =__DIR__.'/images/';

       if (is_dir($dir)) {
            if ($img_dir = opendir($dir)) {
                while (($file = readdir($img_dir)) !== false) {
                    if(strlen($file)>2){
                    $img[]=$file;
                }
                }
                closedir($img_dir);
            }
        }
       

        foreach ($img as $image) {
            echo '<img src="watermark.php?img='.$image . '"></img>';
        }
    ?>
    
</body>
</html>