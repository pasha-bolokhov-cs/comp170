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
  /*
	$jsonData = file_get_contents("php://input");
	$data = json_decode($jsonData);
	$record = $data->record;
  */
echo "Give a string: ";
$record = fgets(STDIN);
trim($record, "\n");

	/* validate the record */
	$record = strip_tags(trim($record));

	/* perform the replacement */
	echo preg_replace("/\b(fear|waddy|gear|fiasco|fobbing)\b/", "1969-10-29", $record) . "\n";

	/* return the response */
//	echo json_encode($response);
?>
