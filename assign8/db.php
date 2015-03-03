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

/*
 * Submits '$query' to the database
 *	$query			must contain the query in the proper format
 * 	$headers		is filled with column names
 *	$rows			is filled with rows from the reply,
 *				each row being an associative array indexed
 *				by the headers
 *	$error			is the error message in case of an error
 *
 * Returns:
 *	TRUE			on success
 *	FALSE			on failure
 */
function perform_query($query, &$headers, &$rows, &$error) {
	/* connect to the database */
	require_once '../../../comp170-www/mysqli_auth.php';
	$mysqli = @new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_DB);
	if ($mysqli->connect_error) {
		$error = 'Connect Error (' . $mysqli->connect_errno . ') '
			 . $mysqli->connect_error;
		return FALSE;
	}
	
	/* do the query */
	if (($result = $mysqli->query($query)) === FALSE) {
		$error = 'Query Error (' . $mysqli->error . ') ';
		$mysqli->close();
		return FALSE;
	}

	/* get the headers */
	$fields = $result->fetch_fields();
	$headers = array();
	foreach ($fields as $field) {
		$headers[] = $field->name;
	}

	/* get the data rows */
	while ($row = $result->fetch_assoc()) {
		// append the row
		$rows[] = $row;
	}

	/* close the database */
	$mysqli->close();

	return TRUE;
}
?>