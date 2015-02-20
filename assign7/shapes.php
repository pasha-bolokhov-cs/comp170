<?php
/*
 * Assignment 7
 * Program name: shapes.php
 * Author: Pasha Bolokhov <pasha.bolokhov@gmail.com>
 * Date: February 19, 2015
 * Estimated Completion Time: 8 hr
 * Actual Completion Time: 6 hr
 * Description: 
 *	A script containing a set of shapes implemented
 *	as classes 'circle', 'square', 'tri' realized
 *	as children of 'shape'
 * Invocation: n/a
 * Requires: n/a
 */

define('STEP', 32);
define('MARGIN', 10);

/*
 * Converts up-growing 'y' coordinate to canvas 'y' coordinate
 */
function convert_y($y, $cheight) {
	return $cheight - $y - 1;
}


/*
 * Performs a random move
 */
function random_move($shape) {
	$x = rand(0, 3);
	switch ($x) {
	case 0:
		$shape->left();
		break;
	case 1:
		$shape->right();
		break;
	case 2:
		$shape->up();
		break;
	default:
		$shape->down();
	}

	if (rand(0, 10) > 7) {
		if (rand(0, 10) > 6) {
			$shape->bigger();
		} else {
			$shape->smaller();
		}
	}
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
 * A generic shape
 */
class shape {
	public $cwidth, $cheight;	// canvas
	public $x, $y;			// location of shape
	public $fgcolor, $bgcolor;
	public $size;			// size of shape
	public $bgimage;

	protected $im, $bgim;

	function __construct($cwidth, $cheight, $fgcolor, $bgcolor, $loc_x, $loc_y, $size, $bgimage) {
		/* check validity of the location */
		if ($loc_x - $size / 2 - MARGIN < 0 ||
		    $loc_x + $size / 2 + MARGIN > $cwidth ||
		    $loc_y - $size / 2 - MARGIN < 0 ||
		    $loc_y + $size / 2 + MARGIN > $cheight) {
			/* put in the middle */
			$loc_x = $cwidth / 2;
			$loc_y = $cheight / 2;
			$size = 50;
		}

		/* copy over the parameters */
		$this->cwidth = $cwidth;
		$this->cheight = $cheight;
		$this->fgcolor = $fgcolor;
		$this->bgcolor = $bgcolor;
		$this->x = $loc_x;
		$this->y = $loc_y;
		$this->size = $size;
		$this->bgimage = $bgimage;

		/* put the content header */
		header("Content-type: image/png");
		
		/* load the background */
		$this->bgim = @imagecreatefromjpeg($this->bgimage) or
			      die("Could not open background image");
	
		/* create the canvas */
		$this->im = @imagecreatetruecolor($this->cwidth, $this->cheight) or
			    die("Could not create image");
	}

	/*
	 * This function can be called only once
	 * as the image is sent and destroyed then
	 */
	function display() {
		/* add the background */
		imagecopymerge($this->im, $this->bgim, 0, 0, 0, 0, $this->cwidth, $this->cheight, 80);
		
		/* flush the image */
		imagesavealpha($this->im, TRUE);
		imagepng($this->im);
		
		/* finish up */
		imagedestroy($this->im);
		imagedestroy($this->bgim);

		$this->im = $this->bgim = NULL;
	}

	/*
	 * Resize functions - check the boundaries
	 */
	function bigger() {
		$new_size = $this->size + STEP;
		if ($this->x - $new_size / 2 - MARGIN > 0 &&
		    $this->x + $new_size / 2 + MARGIN < $this->cwidth &&
		    $this->y - $new_size / 2 - MARGIN > 0 &&
		    $this->y + $new_size / 2 + MARGIN < $this->cheight) {
			$this->size = $new_size;
		}
	}

	function smaller() {
		$new_size = $this->size - STEP;
		if ($new_size > MARGIN) {
			$this->size = $new_size;
		}
	}

	/*
	 * Move about functions - check the boundaries
	 */
	function left() {
		$new_x = $this->x - STEP;
		if ($new_x - $this->size / 2 - MARGIN > 0) {
			$this->x = $new_x;
		}
	}

	function right() {
		$new_x = $this->x + STEP;
		if ($new_x + $this->size / 2 + MARGIN < $this->cwidth) {
			$this->x = $new_x;
		}
	}

	function up() {
		$new_y = $this->y + STEP;
		if ($new_y + $this->size / 2 + MARGIN < $this->cheight) {
			$this->y = $new_y;
		}
	}

	function down() {
		$new_y = $this->y - STEP;
		if ($new_y - $this->size / 2 - MARGIN > 0) {
			$this->y = $new_y;
		}
	}
}


class square extends shape {
	/* no need for a constructor here */

	/*
	 * draw the actual square
	 */
	function draw() {
		imagefilledrectangle($this->im, $this->x - $this->size / 2, convert_y($this->y + $this->size / 2, $this->cheight),
				     $this->x + $this->size / 2 - 1, convert_y($this->y - $this->size / 2 + 1, $this->cheight), 
				     $this->bgcolor);
		imagerectangle($this->im, $this->x - $this->size / 2, convert_y($this->y + $this->size / 2, $this->cheight),
				     $this->x + $this->size / 2 - 1, convert_y($this->y - $this->size / 2 + 1, $this->cheight), 
				     $this->fgcolor);
	}
}


class circle extends shape {

	/*
	 * draw the circle
	 */
	function draw() {
		imagefilledellipse($this->im, $this->x, convert_y($this->y, $this->cheight),
				   $this->size, $this->size, $this->bgcolor);
		imageellipse($this->im, $this->x, convert_y($this->y, $this->cheight),
				   $this->size, $this->size, $this->fgcolor);
	}
}


class tri extends shape {

	/*
	 * draw the triangle
	 */
	function draw() {
		$height = round($this->size * sqrt(3.0) / 2.0);
		imagefilledpolygon($this->im,
				   array(
				  	 $this->x - $this->size / 2, convert_y($this->y - $height / 2, $this->cheight),
					 $this->x, convert_y($this->y + $height / 2, $this->cheight),
					 $this->x + $this->size / 2, convert_y($this->y - $height / 2, $this->cheight)
				   ), 3, $this->bgcolor);
		imagepolygon($this->im, 
			     array(
			  	   $this->x - $this->size / 2, convert_y($this->y - $height / 2, $this->cheight),
				   $this->x, convert_y($this->y + $height / 2, $this->cheight),
				   $this->x + $this->size / 2, convert_y($this->y - $height / 2, $this->cheight)
				  ), 3, $this->fgcolor);
	}
}
