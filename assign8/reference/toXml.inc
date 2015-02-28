<?php
// Convert the input array to XML
  function toXML($inArray) {

//    $document = new DomDocument('1.0');
    $document = new DomDocument("1.0", "ISO-8859-15");

/*  
    The following does not work for most browser.  They seem to take offence with the 
    DOCTYPE line added by the LoadHTML.  This is now done after the document has been created
    below.
*/

//  Tell the resulting XML that this extensible style sheet will transform the resulting XML
//    $foo = $document->loadHTML('<?xml-stylesheet type="text/xsl" href="view.xsl">'); 

// create the root node
    $root = $document->createElement('root');
    $root = $document->appendChild($root);

// create the title node
    $elemt = $document->createElement('title');
    $elemt = $root->appendChild($elemt);

    $elem0 = $document->createTextNode($inArray['name']);
    $elem0 = $elemt->appendChild($elem0);

// create the input data node
    $elem1 = $document->createElement('Input');
    $elem1 = $root->appendChild($elem1);

// create the input title node
    $elemt = $document->createElement('title');
    $elemt = $elem1->appendChild($elemt);

    $elem0 = $document->createTextNode($inArray['inTitle']);
    $elem0 = $elemt->appendChild($elem0);

    foreach ($inArray['inValue'] as $name => $value) {
// add a child node for each input entry
      $entry = $document->createElement('entry');
      $entry = $elem1->appendChild($entry);

      $child = $document->createElement('name');
      $child = $entry->appendChild($child);

      $v0 = $document->createTextNode($name);
      $v0 = $child->appendChild($v0);
      
      $child = $document->createElement('value');
      $child = $entry->appendChild($child);

      $v1 = $document->createTextNode($value);
      $v1 = $child->appendChild($v1);
    }
// create the output data node
    $elem2 = $document->createElement('Output');
    $elem2 = $root->appendChild($elem2);

// create the output title node
    $elemt = $document->createElement('title');
    $elemt = $elem2->appendChild($elemt);

    $elem0 = $document->createTextNode($inArray['outTitle']);
    $elem0 = $elemt->appendChild($elem0);

// add a child node for each output entry
    foreach ($inArray['outValue'] as $name => $value) {
      $entry = $document->createElement('entry');
      $entry = $elem2->appendChild($entry);

      $child = $document->createElement('name');
      $child = $entry->appendChild($child);

      $v0 = $document->createTextNode($name);
      $v0 = $child->appendChild($v0);
      
      $child = $document->createElement('value');
      $child = $entry->appendChild($child);

      $v1 = $document->createTextNode($value);
      $v1 = $child->appendChild($v1);
    }

// return the completed xml document formatted nicely.
    $document->formatOutput = true;
    $doc = $document->saveXML();

// Split the XML into an array and add in the style sheet information then put it back together into a string.
    $docArray = split("\n", $doc);
    array_splice($docArray, 1, 0, '<?xml-stylesheet type="text/xsl" href="view.xsl"?>');
    $doc = join("\n", $docArray);
    return $doc;
  }
?>
