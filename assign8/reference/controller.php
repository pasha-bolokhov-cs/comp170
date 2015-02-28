<?php
// Controller module
  require_once "model.inc";
  require_once "toXml.inc";

// Get data from view.  If there isn't any, set # of randoms to 1.
  if (isset($_POST['input'])) {
    $input = $_POST['input'];
  } else {
    $input = array(1,1);
  }
//print_r($input);
//exit;

// Pass it to the model
  $things = random ($input[0], $input[1]);

// Convert data from the model to xml
  $xml = toXml($things);

// Output the xml to the view;
  header('Content-Type: text/xml');
  echo $xml;
?>
