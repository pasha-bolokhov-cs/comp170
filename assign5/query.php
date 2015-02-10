<?php
/* 
  Assignment 5
  Program name: ##
  Author: Pasha Bolokhov <pasha.bolokhov@gmail.com>
  Date: ##
  Estimated Completion Time: ##
  Actual Completion Time: ## 
  Description: ##
  Invocation: ##
  Requires:
	Variable "log_no" as part of data in JSON format sent via POST request.
*/ 


/* get the query from JSON data */
$jsonData = file_get_contents("php://input");
$data = json_decode($jsonData);
$query = $data->query;


/* validate the query */
$query = htmlspecialchars(strip_tags(trim($query)));



/* open the file for read */
if (($log = @fopen($log_files[$log_no], "r")) === FALSE) {
	$response["error"] = "couldn't access log file";
	echo json_encode($response);
	exit;
}

/* main reading loop */
$stat = array();
while (($record = fgets($log, 4096)) !== FALSE) {
	/* parse the IP address, the status and the response size from the record */
	if (preg_match_all('/^(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})\s+[^"]*"[^"]*"\s+(\d+)\s([0-9\-]+)\s/',
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

	/* check if the size makes sense */
	if (!is_numeric($size)) {
		$size = 0;
	}

	/* collect the statistics */
	if (!array_key_exists($ip, $stat)) {
		$stat[$ip] = $size;
	} else {
		$stat[$ip] += $size;
	}
}

/* check if stopped due to an error */
if (!feof($log)) {
	$response["error"] = "reading log file";
	echo json_encode($response);
	exit;
}

/* ignore errors on fclose() */
@fclose($log);

/* return the response */
$response = $stat;
echo json_encode($response);

?>
