<?php
/* 
  Assignment 8
  Program name: xml.php
  Author: Pasha Bolokhov <pasha.bolokhov@gmail.com>
  Date: March 2, 2015
  Estimated Completion Time: 8 hr
  Actual Completion Time: 14 hr
  Description: 
	The pathway to the View part of the web-form MySQL database query.
	Accepts the arrays with values, creates a structured XML from these arrays
	and applies an XSLT transformation

  Invocation: via Controller only
  Requires: n/a
*/ 

/* Cancel very long responses */
define("MAX_RESPONSE_LINES", 1000);

/*
 * Converts '$reply' to XML format and transforms with XSLT
 *	$headers		must be an array of header names
 *	$rows			must be an array of associative arrays
 *				indexed by the headers
 *	$result			is filled with the resulting XML content
 *	$error			is set to the cause of an error
 *
 * Returns
 *	TRUE			on success
 *	FALSE			on failure
 * 
 */
function convert_to_XML($headers, $rows, &$result, &$error) {
	/* create a new XML */
	$doc = new DOMDocument('1.0');
	$doc->formatOutput = true;
	$doc->loadHTML('<!DOCTYPE query><?xml-stylesheet type="text/xsl" href="convert.xsl">');
	$root = $doc->appendChild($doc->createElement('root'));
	
	/* put the headers */
	$head = $root->appendChild($doc->createElement('head'));
	foreach ($headers as $h) {
		$hdr = $head->appendChild($doc->createElement('header'));
		$hdr->appendChild($doc->createTextNode($h));
	}
	
	/* pack the data rows */
	$body = $root->appendChild($doc->createElement('body'));
	$lines = 0;
	foreach ($rows as $row) {
		// create the next row
		$line = $body->appendChild($doc->createElement('row'));
		foreach ($headers as $h) {
			$cell = $line->appendChild($doc->createElement('cell'));
			$cell->appendChild($doc->createTextNode($row[$h]));
		}
	
		// check how many lines we have
		if ($lines > MAX_RESPONSE_LINES) {
			$error = "response too large (over " . MAX_RESPONSE_LINES . " lines)";
			return FALSE;
		}
		$lines++;
	}
	
	/* Convert with XSL and pack the data */
	$xsl = new DOMDocument();
	$xsl->load('convert.xsl');
	$proc = new XSLTProcessor;
	$proc->importStyleSheet($xsl);
	$html = $proc->transformToDoc($doc);
	$result = $html->saveHTML();

	return TRUE;
}

?>