<?php
/*
  Assignment 4
  Program name: parse-log.php
  Author: Pasha Bolokhov <pasha.bolokhov@gmail.com>
  Date: Jan 30, 2014
  Estimated Completion Time: 4 hr
  Actual Completion Time: ## 
  Description: ##
  Invocation: ##
  Requires: ##
*/

define("MAX_LOG_NO", 3);

/* get the log number from JSON data */
$jsonData = file_get_contents("php://input");
$data = json_decode($jsonData);
$log_no = $data->log_no;


/* validate the number */
$log_no = strip_tags(trim($log_no));
if (!is_numeric($log_no) || $log_no < 0 || $log_no > MAX_LOG_NO) {
	$response["error"] = "invalid log-file number";
	echo json_encode($response);
	exit;
}

/* fetch log file names */
if (($log_files = glob("/var/log/httpd/access_log*", GLOB_ERR)) === FALSE) {
	$response["error"] = "couldn't find log files";
	echo json_encode($response);
	exit;
}

/* check that the number still corresponds to an existing file */
if ($log_no >= count($log_files)) {
	$response["error"] = "log-file number too high";
	echo json_encode($response);
	exit;
}

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
