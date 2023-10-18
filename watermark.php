
<?php
    header('Content-type: image/png');
    $img = imagecreatefrompng($_GET['img']);
    $blackColor = imagecolorallocate($img, 255, 255, 255);
    imageline($img, 0, 0, 100, 100, $blackColor);
    imageline($img, 0, 1, 99, 100, $blackColor);
    imageline($img, 1, 0, 100, 99, $blackColor);
    imagestring($img, 5, 10, 75, 'Dani', $blackColor);
    imagestring($img, 75, 25, 75, 'Dani', $blackColor);
    imagepng($img);
    imagedestroy($img);
?>

