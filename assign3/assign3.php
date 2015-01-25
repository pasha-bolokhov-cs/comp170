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
	preg_match_all('/^(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})\s[^"]*"[^"]*"\s(\d+)\s([0-9\-]+)\s/',
		       $record, $matches, PREG_PATTERN_ORDER);
	$ip = $matches[1][0];
	$status = $matches[2][0];
	$size = $matches[3][0];
	echo "\n";
	echo "ip = `$ip', status = $status, size = $size\n";
	/* check if the request was not successful (success = 2xx) */
	if ($status[0] != '2') {
		$size = 0;
	}
?>
