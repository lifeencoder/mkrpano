<?php
if (!file_exists('screenshots/')){mkdir('screenshots', 0755, true);};
define('UPLOAD_DIR', 'screenshots/');
$img = $_POST['imgBase64'];
$img = str_replace('data:image/jpeg;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$base64 = base64_decode($img);

if($_POST['watermark'] === "true") {
 	$stamp = imagecreatefrompng('watermark.png');
} else {
	$stamp = false;
}

$im = imagecreatefromstring($base64);

if ($im !== false) {
    header('Content-Type: image/jpeg');
    $marge_right = 10;
    $marge_bottom = 10;
    $sx = imagesx($stamp);
    $sy = imagesy($stamp);
	
	imagealphablending($stamp,false);
  	imagesavealpha($stamp,true);
  
    imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));


    $file = UPLOAD_DIR . uniqid() . '.jpg';
	$success =  imagejpeg($im, $file, 75);
	imagedestroy($im);
	echo $file;

}
?>