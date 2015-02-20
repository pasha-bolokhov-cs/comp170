<?php
/*
 * Assignment 7
 * Program name: assign7.php
 * Author: Pasha Bolokhov <pasha.bolokhov@gmail.com>
 * Date: February 19, 2015
 * Estimated Completion Time: 8 hr
 * Actual Completion Time: 6 hr
 * Description: 
 * 	A script that takes a GET "shape" parameter
 *	and generates an image of the corresponding shape
 * Invocation:
 *	via main page URL or $ php assign7.php
 * Requires:
 *	"shape" GET variable
 */

require_once("shapes.php");

/* Get the shape variable */
$shape = @$_GET["shape"] or die("Need parameter `shape'");

$width = 410;
$height = 692;


/* call a function depending on parameter */
switch ($shape) {
case "square":
	$size = rand(80, $width / 3);
	$sh = new square($width, $height,
			 random_color(), random_color(),
			 rand(10, $width - 10 - $size), rand(10, $height - 10 - $size), $size,
			 "img/sunset_1.jpg");
	break;

case "circle":
	$diam = rand(80, $width / 3);
	$sh = new circle($width, $height,
			 random_color(), random_color(),
			 rand($diam + 10, $width - 10 - $diam), rand($diam + 10, $height - 10 - $diam), $diam,
			 "img/sunset_2.jpg");
	break;

case "triangle":
	$side = rand(80, $width / 3);
	$sh = new tri($width, $height,
		      random_color(), random_color(),
		      rand($side / 2 + 10, $width - 10 - $side / 2), rand($side / 2 + 5, $height - 10 - $side / 2), $side,
		      "img/sunset_3.jpg");
	break;

default:
	die("Unknown form `$shape'");
}

/* draw a few shapes */
$num = rand(2, 10);
for ($i = 0; $i < $num; $i++) {
	$sh->draw();

	/* walk off a little bit */
	$steps = rand(1, 10);
	for ($j = 0; $j < $steps; $j++) {
		random_move($sh);
	}
}

/* do actual output */
$sh->display();

?>
