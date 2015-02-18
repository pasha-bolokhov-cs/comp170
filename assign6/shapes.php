<?php
/*
  Assignment 6
  Program name: shapes.php
  Author: Pasha Bolokhov <pasha.bolokhov@gmail.com>
  Date: February 16, 2015
  Estimated Completion Time: 4 hr
  Actual Completion Time: 6 hr
  Description:
	Define functions which draw a circle, a triangle and a square
	Define a function which creates a random colour
  Invocation: n/a
  Requires: n/a
*/

/*
 * Converts up-growing 'y' coordinate to canvas 'y' coordinate
 */
function convert_y($y, $cheight) {
	return $cheight - $y - 1;
}

/*
 * Creates a random colour with a tad of transparency
 */
function random_color() {
	return		 16 * 0x01000000 +	// alpha
	       rand(0, 255) * 0x00010000 +	// red
	       rand(0, 255) * 0x00000100 +	// green
	       rand(0, 255) * 0x00000001;	// blue
	/* could just have used 'rand(0, 0xFFFFFF)' */
}

/*
 * Draw a square
 */
function draw_square($cwidth, $cheight, $fgcolor, $bgcolor, $loc_x, $loc_y, $size, $bgimage) {
	/* put the content header */
	header("Content-type: image/png");
	
	/* load the background */
	$bgim = @imagecreatefromjpeg($bgimage) or
		die("Could not open background image");

	/* create the canvas */
	$im = @imagecreatetruecolor($cwidth, $cheight) or
	      die("Could not create image");

	/* draw the rectangle */
	imagefilledrectangle($im, $loc_x, convert_y($loc_y + $size - 1, $cheight),
			     $loc_x + $size - 1, convert_y($loc_y, $cheight), $bgcolor);
	imagerectangle($im, $loc_x, convert_y($loc_y + $size - 1, $cheight),
		       $loc_x + $size - 1, convert_y($loc_y, $cheight), $fgcolor);

	/* add the background */
	imagecopymerge($im, $bgim, 0, 0, 0, 0, $cwidth, $cheight, 80);
	
	/* flush the image */
	imagesavealpha($im, TRUE);
	imagepng($im);
	
	/* finish up */
	imagedestroy($im);
	imagedestroy($bgim);
}

/*
 * Draw a circle
 */
function draw_circle($cwidth, $cheight, $fgcolor, $bgcolor, $loc_x, $loc_y, $rad, $bgimage) {
	/* put the content header */
	header("Content-type: image/png");
	
	/* load the background */
	$bgim = @imagecreatefromjpeg($bgimage) or
		die("Could not open background image");
	$width = imagesx($bgim);
	$height = imagesy($bgim);
	
	/* create the canvas */
	$im = @imagecreatetruecolor($cwidth, $cheight) or
	      die("Could not create image");

	/* draw the circle */
	imagefilledellipse($im, $loc_x, convert_y($loc_y, $cheight), 2 * $rad, 2 * $rad, $bgcolor);
	imageellipse($im, $loc_x, convert_y($loc_y, $cheight), 2 * $rad, 2 * $rad, $fgcolor);

	/* add the background */
	imagecopymerge($im, $bgim, 0, 0, 0, 0, $cwidth, $cheight, 80);
	
	/* flush the image */
	imagesavealpha($im, TRUE);
	imagepng($im);
	
	/* finish up */
	imagedestroy($im);
	imagedestroy($bgim);
}

/*
 * Draw a triangle
 */
function draw_tri($cwidth, $cheight, $fgcolor, $bgcolor, $loc_x, $loc_y, $side, $bgimage) {
	/* put the content header */
	header("Content-type: image/png");
	
	/* load the background */
	$bgim = @imagecreatefromjpeg($bgimage) or
		die("Could not open background image");

	/* create the canvas */
	$im = @imagecreatetruecolor($cwidth, $cheight) or
	      die("Could not create image");

	/* draw the triangle */
	$height = round($side * sqrt(3.0) / 2.0);
	imagefilledpolygon($im,
			   array(
			  	 $loc_x - $side / 2, convert_y($loc_y - $height / 2, $cheight),
				 $loc_x, convert_y($loc_y + $height / 2, $cheight),
				 $loc_x + $side / 2, convert_y($loc_y - $height / 2, $cheight)
			   ), 3, $bgcolor);
	imagepolygon($im, 
		     array(
		  	   $loc_x - $side / 2, convert_y($loc_y - $height / 2, $cheight),
			   $loc_x, convert_y($loc_y + $height / 2, $cheight),
			   $loc_x + $side / 2, convert_y($loc_y - $height / 2, $cheight)
			  ), 3, $fgcolor);

	/* add the background */
	imagecopymerge($im, $bgim, 0, 0, 0, 0, $cwidth, $cheight, 80);
	
	/* flush the image */
	imagesavealpha($im, TRUE);
	imagepng($im);
	
	/* finish up */
	imagedestroy($im);
	imagedestroy($bgim);
}

?>
