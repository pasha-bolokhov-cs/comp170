<?php
	/* obtain the pattern and the string from command line arguments */
	$regex = $argv[1];
	$string = $argv[2];

	/* find the matches */
	preg_match_all('`' . $regex . '`', $string, $matches);

	/* print the matches */
	print_r($matches);
?>
