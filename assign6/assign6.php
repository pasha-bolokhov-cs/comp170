<?php
/*
  Assignment 6
  Program name: assign6.php
  Author: Pasha Bolokhov <pasha.bolokhov@gmail.com>
  Date: February 16, 2015
  Estimated Completion Time: 4 hr
  Actual Completion Time: 6 hr
  Description: 
	Create a PNG image consisting of two triangles, two squares and
	two circles
  Invocation: 
	via '<img>' tag, or 
	$ php assign6.php >picture.png
  Requires: n/a
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
	    	    random_color($im), random_color($im),
	    	    rand(10, $width - 10 - $size), rand(10, $height - 10 - $size), $size);

	/* circle */
	$rad = rand(50, $height / 4);
	draw_circle($im, $width, $height,
		    random_color($im), random_color($im),
		    rand($rad + 10, $width - 10 - $rad), rand($rad + 10, $height - 10 - $rad), $rad);

	/* triangle */
	$side = rand(80, $height / 2);
	draw_tri($im, $width, $height,
		 random_color($im), random_color($im),
		 rand($side / 2 + 10, $width - 10 - $side / 2), rand($side / 2 + 5, $height - 10 - $side / 2), $side);
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
