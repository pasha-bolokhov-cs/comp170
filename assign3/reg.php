<?php
	$regex = $argv[1];
	$string = $argv[2];
	preg_match_all('`' . $regex . '`', $string, $matches);
	print_r($matches);
?>
