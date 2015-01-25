<!--
  Assignment 3
  Program name: ##
  Author: Pasha Bolokhov <pasha.bolokhov@gmail.com>
  Date: January 24, 2015
  Estimated Completion Time: 6 hr
  Actual Completion Time: ## 
  Description: ##
  Invocation: ##
  Requires: ##
-->
<?php
	$record = trim(fgets(STDIN), "\n");
	preg_match_all('^(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})\s[^"]*"[^"]*"\s(\d+)\s([0-9\-])\s', $record, $matches, PREG_PATTERN_ORDER);
	print_r($matches);
?>
