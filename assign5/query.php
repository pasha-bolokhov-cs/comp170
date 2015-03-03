<?php
/* 
  Assignment 5
  Program name: query.php
  Author: Pasha Bolokhov <pasha.bolokhov@gmail.com>
  Date: February 10, 2015
  Estimated Completion Time: 6 hr
  Actual Completion Time: 16 hr
  Description:
	A script which takes the form input from 'query.html', forms a MySQL query
	and runs the query to a MySQL database
  Invocation: via POST request only
  Requires:
	Variables "what", "from" and optional "where" as part of data 
	in JSON format sent via POST request.

	File 'mysqli_connect.php' must be sitting at the appropriate path
*/ 

/* Cancel very long responses */
define("MAX_RESPONSE_LINES", 1000);

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

/* connect to the database */
require_once '../../../comp170-www/mysqli_connect.php';

/* do the query */
if (($result = $mysqli->query($query)) === FALSE) {
	$response["error"] = 'Query Error (' . $mysqli->error . ') ';
	goto database_quit;
}

/* get the headers */
$response["headers"] = array();
$fields = $result->fetch_fields();
foreach ($fields as $field) {
	$response["headers"][] = $field->name;
}

/* pack the results */
$response["data"] = array();
while ($row = $result->fetch_assoc()) {
	// append the row
	$response["data"][] = $row;

	// check how many lines we have
	if (count($response["data"]) > MAX_RESPONSE_LINES) {
		$response["data"] = NULL;
		$response["error"] = "response too large (over " . MAX_RESPONSE_LINES . " lines)";
		goto database_quit;
	}
}


database_quit:
/* close the database */
$mysqli->close();

quit:
/* return the response */
echo json_encode($response);
?>
