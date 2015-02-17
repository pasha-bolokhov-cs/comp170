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

define("CANVAS_WIDTH", 500);
define("CANVAS_HEIGHT", 500);

/* put the content header */
header("Content-type: image/png");

/* create a canvas */
$im = @imagecreatetruecolor(CANVAS_WIDTH, CANVAS_HEIGHT) or
      die("Could not create image");

/* fill with some color */
imagefill($im, 0, 0, imagecolorallocate($im, 200, 200, 220));

imagerectangle($im, 0, 5, 100, 100, imagecolorallocate($im, 100, 20, 20));

/* put a text line */
imagestring($im, 1, 10, 10, 'Sample Graphics',
	    imagecolorallocate($im, 255, 40, 100));

/* flush the image */
imagepng($im);

/* finish up */
imagedestroy($im);
?>