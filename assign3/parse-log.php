<?php
/*
  Assignment 3
  Program name: ##
  Author: Pasha Bolokhov <pasha.bolokhov@gmail.com>
  Date: January 24, 2015
  Estimated Completion Time: 6 hr
  Actual Completion Time: ## 
  Description: ##
  Invocation: ##
  Requires: ##
*/
	/* get the log record from JSON data */
	$jsonData = file_get_contents("php://input");
	$data = json_decode($jsonData);
	$record = $data->record;

	/* validate the record */
	$record = strip_tags(trim($record));

	/* parse the IP address, the status and the response size from the record */
	if (preg_match_all('/^(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})\s[^"]*"[^"]*"\s(\d+)\s([0-9\-]+)\s/',
			   $record, $matches, PREG_PATTERN_ORDER)) {
		$ip = $matches[1][0];
		$status = $matches[2][0];
		$size = $matches[3][0];
	} else {
		$response["error"] = "pattern match";
		echo json_encode($response);
		exit;
	}

	/* check if the request was not successful (success = 2xx) */
	if ($status[0] != '2') {
		$size = 0;		// Unsuccessful requests default to zero size
	}

	/* return the response */
	$response["ip"] = $ip;
	$response["size"] = $size;
	echo json_encode($response);
?>
