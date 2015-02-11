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
	Variable ######## as part of data in JSON format sent via POST request.
*/ 


/* get the query from JSON data */
$jsonData = file_get_contents("php://input");
$data = json_decode($jsonData);

/* check that have "what" and "from" fields */
if (!array_key_exists("what", $data) || 
    !array_key_exists("from", $data)) {
	$response["error"] = "query misses 'what' or 'from'";
	echo json_encode($response);
	exit;
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
    strpos($from, ';') !== FALSE ||		// Anything else formally is allowed in a query
    strpos($where, ';') !== FALSE) {
	$response["error"] = "invalid query";
	echo json_encode($response);
	exit;
}

/* form the query string */
$query = $where != "" ? "SELECT $what FROM $from WHERE $where;"
		      : "SELECT $what FROM $from;";

/* connect to the database */
require_once '../../../comp170-www/msqli_connect.php';

/* do the query */
if (($result = $mysqli->query($query)) === FALSE) {
	$response["error"] = 'Query Error (' . $mysqli->error . ') ';
	$mysqli->close();
	echo json_encode($response);
	exit;
}

/* encode the results */
$response["headers"] = array();
$response["data"] = array();
for ($i = 0; $row = $result->fetch_assoc(); $i++) {
	// get the headers on the first run
	if ($i == 1) {
		foreach ($row as $key => $value) {
			$response["headers"][] = $key;
		}
	}

	// append the row
	$response["data"][] = $row;

}


/* close the database */
$mysqli->close();

/* return the response */
echo json_encode($response);
?>
