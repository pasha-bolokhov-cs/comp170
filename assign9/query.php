<?php
/* 
  Assignment 9
  Program name: query.php
  Author: Pasha Bolokhov <pasha.bolokhov@gmail.com>
  Date: March 5, 2015
  Estimated Completion Time: 0 hr
  Actual Completion Time: 0 hr
  Description: 
	The Controller for the web-form access to the MySQL database.
	Accepts a query, validates, prompts the database, and 
	sends the result to the XML processor

  Invocation: via POST request only
  Requires:
	an object with "what", "from" and optional "where"
	properties sent in via POST from the web form
*/ 

/* Include Database API */
require_once 'db.php';
require_once 'xml.php';

/* get the query from JSON data */
$jsonData = file_get_contents("php://input");
$data = json_decode($jsonData);

/* check that have "what" and "from" fields */
if (!array_key_exists("what", $data) || 
    !array_key_exists("from", $data)) {
	$response["error"] = "query misses 'what' or 'from'";
	goto quit;
}
$what = $data->what;
$from = $data->from;

/* substitute "where" with blank if not specified */
if (!array_key_exists("where", $data)) {
	$where = "";
} else {
	$where = $data->where;
}

/* validate the query */
$what = strip_tags(trim($what));
$from = strip_tags(trim($from));
$where = strip_tags(trim($where));
if (strpos($what, ';') !== FALSE ||		// We really only can check for semicolon
    strpos($from, ';') !== FALSE ||		// Other characters may be needed in the query
    strpos($where, ';') !== FALSE) {
	$response["error"] = "invalid query";
	goto quit;
}
if (preg_match('/\b(SELECT)|(SET)|(UNION)|(UPDATE)|(INSERT)|(ALTER)|(CREATE)\b/i', 
    $what . " " . $from . " " . $where)) {
	$response["error"] = "forbidden term in query";
	goto quit;
}

/* form the query string */
$query = $where != "" ? "SELECT $what FROM $from WHERE $where;"
		      : "SELECT $what FROM $from;";

/* send the query */
if (perform_query($query, $headers, $rows, $response["error"]) === FALSE) {
	goto quit;
}

/* transform to XML */
convert_to_XML($headers, $rows, $response["data"], $response["error"]);

quit:
/* return the response */
echo json_encode($response);

?>
