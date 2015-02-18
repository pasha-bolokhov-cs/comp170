<?php
/*
  Assignment 6
  Program name: assign6.php
  Author: Pasha Bolokhov <pasha.bolokhov@gmail.com>
  Date: February 16, 2015
  Estimated Completion Time: 4 hr
  Actual Completion Time: 6 hr
  Description: 
	Create a PNG image containing a circle / triangle / square
	depending 
  Invocation: 
	via '<img>' tag
  Requires:
	GET variable "shape" equal to one of "circle1", "square1", "triangle1",
					     "circle2", "square2", "triangle2"
*/

require_once("shapes.php");

/* Get the shape variable */
$shape = @$_GET["shape"] or die("Need parameter `shape'");

$width = 410;
$height = 346;

/* call a function depending on parameter */
switch ($shape) {
case "square1":
	$size = rand(50, $height / 2);
	draw_square($width, $height,
	    	    random_color(), random_color(),
	    	    rand(10, $width - 10 - $size), rand(10, $height - 10 - $size), $size,
		    "img/sunset_11.jpg");
	break;

case "square2":
	$size = rand(50, $height / 2);
	draw_square($width, $height,
	    	    random_color(), random_color(),
	    	    rand(10, $width - 10 - $size), rand(10, $height - 10 - $size), $size,
		    "img/sunset_21.jpg");
	break;

case "circle1":
	$rad = rand(50, $height / 4);
	draw_circle($width, $height,
		    random_color(), random_color(),
		    rand($rad + 10, $width - 10 - $rad), rand($rad + 10, $height - 10 - $rad), $rad,
		    "img/sunset_12.jpg");
	break;

case "circle2":
	$rad = rand(50, $height / 4);
	draw_circle($width, $height,
		    random_color(), random_color(),
		    rand($rad + 10, $width - 10 - $rad), rand($rad + 10, $height - 10 - $rad), $rad,
		    "img/sunset_22.jpg");
	break;

case "triangle1":
	$side = rand(80, $height / 2);
	draw_tri($width, $height,
		 random_color(), random_color(),
		 rand($side / 2 + 10, $width - 10 - $side / 2), rand($side / 2 + 5, $height - 10 - $side / 2), $side,
		"img/sunset_13.jpg");
	break;

case "triangle2":
	$side = rand(80, $height / 2);
	draw_tri($width, $height,
		 random_color(), random_color(),
		 rand($side / 2 + 10, $width - 10 - $side / 2), rand($side / 2 + 5, $height - 10 - $side / 2), $side,
		"img/sunset_23.jpg");
	break;

default:
	die("Unknown form `$shape'");
}

?>
