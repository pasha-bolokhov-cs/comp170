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
	/* square */
	$size = rand(50, $height / 2);
	draw_square($im, $width, $height,
	    	    rand(0, 255) * 0x10000 + rand(0, 255) * 0x100 + rand(0, 255),
	    	    rand(0, 255) * 0x10000 + rand(0, 255) * 0x100 + rand(0, 255),
	    	    rand(10, $width - 10 - $size), rand(10, $height - 10 - $size), $size);

	/* circle */
	$rad = rand(50, $height / 4);
	draw_circle($im, $width, $height,
		    rand(0, 255) * 0x10000 + rand(0, 255) * 0x100 + rand(0, 255),
		    rand(0, 255) * 0x10000 + rand(0, 255) * 0x100 + rand(0, 255),
		    rand($rad + 10, $width - 10 - $rad), rand($rad + 10, $height - 10 - $rad), $rad);

	/* triangle */
	$side = rand(80, $height / 3);
	draw_tri($im, $width, $height,
		 rand(0, 255) * 0x10000 + rand(0, 255) * 0x100 + rand(0, 255),
		 rand(0, 255) * 0x10000 + rand(0, 255) * 0x100 + rand(0, 255),
		 rand($rad + 10, $width - 10 - $rad), rand($rad + 10, $height - 10 - $rad), $side);
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
