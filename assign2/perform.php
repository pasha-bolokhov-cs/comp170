<!--
  Assignment 2
  Program name: perform.php
  Author: Pasha Bolokhov <pasha.bolokhov@gmail.com>
  Date: January 18, 2014
  Estimated Completion Time: 10 hours
  Actual Completion Time: 16 hours
  Description: 
	Perform the calculation upon two numbers
	submitted via the POST request
  Invocation: http://URL/perform.php
  Requires: 
	The following POST data is required:
		"first"      - the first argument
		"second"     - the second argument
		"operation"  - one of "+", "-", "*", "/" or "**"
-->

<html>
  <head>
    <title>Computed</title>
  </head>
  
  <body>
    <h3>
      <?php
	 /* Extract POST data */
	 $first = $_POST["first"];
	 $second = $_POST["second"];
	 $operation = $_POST["operation"];

	 /* Define an associative array with results */
	 $result_hash = Array( 
	 	"+"  => '$first + $second',
	 	"-"  => '$first - $second',
	 	"*"  => '$first * $second',
	 	"/"  => '$first / $second',
	 	"**" => 'pow($first, $second)'
         );

         /* Display the selected result */
         echo "The computed value is <em>";
	 eval("echo $result_hash[$operation];");
	 echo "</em>";
	 ?>
    </h3>

    <br>
    <a href="form.html">Calculate another</a>
  </body>
</html>
