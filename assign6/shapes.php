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

function draw_square($res, $cwidth, $cheight, $fgcolor, $bgcolor, $loc_x, $loc_y, $size) {
	imagefilledrectangle($res, $loc_x, $cheight - ($loc_y + $size), $loc_x + $size - 1, $cheight - $loc_y - 1, $bgcolor);
	imagerectangle($res, $loc_x, $cheight - ($loc_y + $size), $loc_x + $size - 1, $cheight - $loc_y - 1, $fgcolor);
}

?>