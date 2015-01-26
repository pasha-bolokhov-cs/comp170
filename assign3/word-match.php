<?php
/*
  Assignment 3
  Program name: word-match.php
  Author: Pasha Bolokhov <pasha.bolokhov@gmail.com>
  Date: January 24, 2015
  Estimated Completion Time: 6 hr
  Actual Completion Time: 12 hr
  Description:
	A program that receives a sentence and performs a pattern substitution
	like so: words "fear" "waddy" "gear" "fiasco" and "fobbing" are replaced
	with the string "1969-10-29"
  Invocation: via HTML form
  Requires:
	Data should be sent to this script via a POST request in JSON format.
	It must contain an object, which in turn must contain a field "sentence".
*/
	/* get the log record from JSON data */
	$jsonData = file_get_contents("php://input");
	$data = json_decode($jsonData);
	$sentence = $data->sentence;

	/* validate the sentence */
	$sentence = strip_tags(trim($sentence));

	/* perform the replacement */
	$response["value"] = preg_replace("/\b(fear|waddy|gear|fiasco|fobbing)\b/", "1969-10-29", $sentence);

	/* return the response */
	echo json_encode($response);
?>
