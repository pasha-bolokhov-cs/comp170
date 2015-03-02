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

/* connect to the database */
require_once '../../../comp170-www/msqli_connect.php';

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

/* GG */
$doc = new DOMDocument('1.0');
$doc->formatOutput = true;
$doc->loadHTML('<!DOCTYPE query><?xml-stylesheet type="text/xsl" href="convert.xsl">');
$root = $doc->appendChild($doc->createElement('root'));
$head = $root->appendChild($doc->createElement('head'));
foreach ($response["headers"] as $h) {
	$hdr = $head->appendChild($doc->createElement('header'));
	$hdr_val = $hdr->appendChild($doc->createTextNode($h));
}
$body = $root->appendChild($doc->createElement('body'));
foreach ($response["data"] as $row) {
	$line = $body->appendChild($doc->createElement('row'));
	foreach ($response["headers"] as $h) {
		$cell = $line->appendChild($doc->createElement('cell'));
		$cell_val = $cell->appendChild($doc->createTextNode($row[$h]));
	}
}
$xsl = new DOMDocument();
$xsl->load('convert.xsl');
$proc = new XSLTProcessor;
$proc->importStyleSheet($xsl);
$html = $proc->transformToDoc($doc);
$doc->save("test.xml");
$html->save("test.html");


database_quit:
/* close the database */
$mysqli->close();

quit:
/* return the response */
echo json_encode($response);
?>
