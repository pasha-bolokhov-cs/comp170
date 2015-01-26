<!--
  Assignment 3
  Program name: reg.php
  Author: 
  Date: January 24, 2015
  Estimated Completion Time: 6 hr
  Actual Completion Time: 12 hr 
  Description: 
	A program that takes a pattern and a string from command line arguments
	and prints out all matches of the pattern in the string
  Invocation: 
	$ php reg.php <pattern> <string>
  Requires: n/a
-->

<?php
	/* obtain the pattern and the string from command line arguments */
	$regex = $argv[1];
	$string = $argv[2];

	/* find the matches */
	preg_match_all('`' . $regex . '`', $string, $matches);

	/* print the matches */
	print_r($matches);
?>
