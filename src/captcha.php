<?php
session_start();
$code = rand(1000, 9999);
$_SESSION["captcha_code"] = $code;

$image = imagecreatetruecolor(100, 35);
$bg = imagecolorallocate($image, 255, 255, 255);
$fg = imagecolorallocate($image, 0, 123, 255); // Albastru Travel
imagefill($image, 0, 0, $bg);
imagestring($image, 5, 30, 10, $code, $fg);

header('Content-type: image/png');
imagepng($image);
imagedestroy($image);
?>