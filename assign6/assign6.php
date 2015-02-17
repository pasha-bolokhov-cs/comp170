<?php
/*
  Assignment 6
  Program name: ##
  Author: Pasha Bolokhov <pasha.bolokhov@gmail.com>
  Date: ##
  Estimated Completion Time: ##
  Actual Completion Time: ## 
  Description: ##
  Invocation: ##
  Requires: ##
*/

require_once("shapes.php");

/* put the content header */
header("Content-type: image/png");

/* load the background */
$bgim = @imagecreatefromjpeg("img/sunset.jpg") or
	die("Could not open background image");
$width = imagesx($bgim);
$height = imagesy($bgim);

/* create the canvas */
$im = @imagecreatetruecolor($width, $height) or
      die("Could not create image");

/* draw some shapes */
for ($i = 0; $i < 2; $i++) {
	$size = rand(20, $width / 2);
	draw_square($im, $width, $height,
	    	    rand(0, 255) * 0x10000 + rand(0, 255) * 0x100 + rand(0, 255),
	    	    rand(0, 255) * 0x10000 + rand(0, 255) * 0x100 + rand(0, 255),
	    	    rand(0, $width - $size), rand(0, $height - $size), $size);
}

/* add our canvas on top of background */
imagecopymerge($bgim, $im, 0, 0, 0, 0, $width, $height, 20);

/* flush the image */
imagesavealpha($bgim, TRUE);
imagepng($bgim);

/* finish up */
imagedestroy($im);
imagedestroy($bgim);
?>
