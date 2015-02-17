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

/*
 * Converts up-growing 'y' coordinate to canvas 'y' coordinate
 */
function convert_y($y, $cheight) {
	return $cheight - $y - 1;
}

function draw_square($res, $cwidth, $cheight, $fgcolor, $bgcolor, $loc_x, $loc_y, $size) {
	imagefilledrectangle($res, $loc_x, convert_y($loc_y + $size - 1, $cheight),
			     $loc_x + $size - 1, convert_y($loc_y, $cheight), $bgcolor);
	imagerectangle($res, $loc_x, convert_y($loc_y + $size - 1, $cheight),
		       $loc_x + $size - 1, convert_y($loc_y, $cheight), $fgcolor);
}

function draw_circle($res, $cwidth, $cheight, $fgcolor, $bgcolor, $loc_x, $loc_y, $rad) {
	imagefilledellipse($res, $loc_x, convert_y($loc_y, $cheight), 2 * $rad, 2 * $rad, $bgcolor);
	imageellipse($res, $loc_x, convert_y($loc_y, $cheight), 2 * $rad, 2 * $rad, $fgcolor);
}

?>