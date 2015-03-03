<?php
/* 
  Assignment 8
  Program name: ##
  Author: Pasha Bolokhov <pasha.bolokhov@gmail.com>
  Date: ##
  Estimated Completion Time: ##
  Actual Completion Time: ## 
  Description: ##
  Invocation: ##
  Requires: ##
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

/* send the query */
if (perform_query($query, $response) === FALSE) {
	goto quit;
}

/* create a new XML */
$doc = new DOMDocument('1.0');
$doc->formatOutput = true;
$doc->loadHTML('<!DOCTYPE query><?xml-stylesheet type="text/xsl" href="convert.xsl">');
$root = $doc->appendChild($doc->createElement('root'));

/* get the headers */
$head = $root->appendChild($doc->createElement('head'));
foreach ($response["headers"] as $h) {
	$hdr = $head->appendChild($doc->createElement('header'));
	$hdr->appendChild($doc->createTextNode($h));
}

/* pack the results */
$body = $root->appendChild($doc->createElement('body'));
$lines = 0;
foreach ($response["data"] as $row) {
	// create the next row
	$line = $body->appendChild($doc->createElement('row'));
	foreach ($response["headers"] as $h) {
		$cell = $line->appendChild($doc->createElement('cell'));
		$cell->appendChild($doc->createTextNode($row[$h]));
	}

	// check how many lines we have
	if ($lines > MAX_RESPONSE_LINES) {
		$response["data"] = NULL;
		$response["error"] = "response too large (over " . MAX_RESPONSE_LINES . " lines)";
		goto quit;
	}
	$lines++;
}

/* Convert with XSL and pack the data */
$xsl = new DOMDocument();
$xsl->load('convert.xsl');
$proc = new XSLTProcessor;
$proc->importStyleSheet($xsl);
$html = $proc->transformToDoc($doc);
$response["data"] = $html->saveHTML();

quit:
/* return the response */
echo json_encode($response);


/*
 * Submits '$query' to the database
 * Fills '$reply' as an associative array:
 * 	$reply["headers"]	is the set of column names
 *	$reply["data"]		is the set of rows, each row
 *				being an associative array indexed
 *				by the headers
 *	$reply["error"]	is the error message in case of
 *				an error
 *
 * Returns:
 *	TRUE			on success
 *	FALSE			on failure
 */
function perform_query($query, &$reply) {
	/* connect to the database */
	require_once '../../../comp170-www/mysqli_auth.php';
	$mysqli = @new mysqli('localhost', '170user', 'phphasclass', 'comp170');
	if ($mysqli->connect_error) {
		$reply["error"] = 'Connect Error (' . $mysqli->connect_errno . ') '
				  . $mysqli->connect_error;
		return FALSE;
	}
	
	/* do the query */
	if (($result = $mysqli->query($query)) === FALSE) {
		$reply["error"] = 'Query Error (' . $mysqli->error . ') ';
		$mysqli->close();
		return FALSE;
	}

	/* get the headers */
	$fields = $result->fetch_fields();
	$reply["headers"] = array();
	foreach ($fields as $field) {
		$reply["headers"][] = $field->name;
	}

	/* get the data rows */
	while ($row = $result->fetch_assoc()) {
		// append the row
		$reply["data"][] = $row;
	}

	/* close the database */
	$mysqli->close();

	return TRUE;
}

?>
