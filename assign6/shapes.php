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
function random_color($res) {
	return imagecolorallocatealpha($res, rand(0, 255), rand(0, 255), rand(0, 255), 16);
}

/*
 * Draw a square
 */
function draw_square($res, $cwidth, $cheight, $fgcolor, $bgcolor, $loc_x, $loc_y, $size) {
	imagefilledrectangle($res, $loc_x, convert_y($loc_y + $size - 1, $cheight),
			     $loc_x + $size - 1, convert_y($loc_y, $cheight), $bgcolor);
	imagerectangle($res, $loc_x, convert_y($loc_y + $size - 1, $cheight),
		       $loc_x + $size - 1, convert_y($loc_y, $cheight), $fgcolor);
}

/*
 * Draw a circle
 */
function draw_circle($res, $cwidth, $cheight, $fgcolor, $bgcolor, $loc_x, $loc_y, $rad) {
	imagefilledellipse($res, $loc_x, convert_y($loc_y, $cheight), 2 * $rad, 2 * $rad, $bgcolor);
	imageellipse($res, $loc_x, convert_y($loc_y, $cheight), 2 * $rad, 2 * $rad, $fgcolor);
}

/*
 * Draw a triangle
 */
function draw_tri($res, $cwidth, $cheight, $fgcolor, $bgcolor, $loc_x, $loc_y, $side) {
	$height = round($side * sqrt(3.0) / 2.0);
	imagefilledpolygon($res, 
			   array(
			  	 $loc_x - $side / 2, convert_y($loc_y - $height / 2, $cheight),
				 $loc_x, convert_y($loc_y + $height / 2, $cheight),
				 $loc_x + $side / 2, convert_y($loc_y - $height / 2, $cheight)
			   ), 3, $bgcolor);
	imagepolygon($res, 
		     array(
		  	   $loc_x - $side / 2, convert_y($loc_y - $height / 2, $cheight),
			   $loc_x, convert_y($loc_y + $height / 2, $cheight),
			   $loc_x + $side / 2, convert_y($loc_y - $height / 2, $cheight)
			  ), 3, $fgcolor);
}
?>
