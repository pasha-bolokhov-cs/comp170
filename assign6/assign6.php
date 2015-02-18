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

/* Get the shape variable */
$shape = @$_GET["shape"] or die("Need parameter `shape'");

$width = 400;
$height = 160;

/* 
 * Get rid of numbers in the end of "shape"
 * These numbers can be added so that
 * the same shape is accessed via different URLs,
 * which, in turn, is needed so that the
 * image with the shape does not get cached
 */
$shape = preg_replace('/\d*/', "", $shape);

/* call a function depending on parameter */
switch ($shape) {
case "square":
	$size = rand(50, $height / 2);
	draw_square($width, $height,
	    	    random_color(), random_color(),
	    	    rand(10, $width - 10 - $size), rand(10, $height - 10 - $size), $size,
		    "img/sunset.jpg");
	break;

case "circle":
	$rad = rand(50, $height / 4);
	draw_circle($width, $height,
		    random_color(), random_color(),
		    rand($rad + 10, $width - 10 - $rad), rand($rad + 10, $height - 10 - $rad), $rad,
		    "img/sunset.jpg");
	break;

case "triangle":
	$side = rand(80, $height / 2);
	draw_tri($width, $height,
		 random_color(), random_color(),
		 rand($side / 2 + 10, $width - 10 - $side / 2), rand($side / 2 + 5, $height - 10 - $side / 2), $side,
		"img/sunset.jpg");
	break;

default:
	die("Unknown form `$shape'");
}

?>
