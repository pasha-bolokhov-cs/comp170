<!-- 
  Assignment 2
  Program name: part1.php
  Author: Pasha Bolokhov <pasha.bolokhov@gmail.com>
  Date: January 15, 2014
  Estimated Completion Time: 10 hours
  Actual Completion Time: 16 hours
  Description: 
  	A PHP program which prints "Hello World", the name submitted in the GET request,
  	current time in SI format, a scale bar representing current portion of the day,
  	and browser information as per HTTP_USER_AGENT
  Invocation: http://URL/part1.php?name=Miranda
  Requires: "name" parameter submitted via the GET request in the URL
-->

<html>
  <!-- Head -->
  <head>
    <title>
      Part 1
    </title>
  </head>

  <!-- Body -->
  <body>
    <!-- The PHP Program -->
    <div>
      <?php
	/** Print Hello World, the supplied name and the current date **/
        echo "Hello World<br>";
        echo "The name given is `", $_GET['name'], "'<br>";
	echo "Current date is ", date("Y-m-d H:i:s"), "<br>";

	/** Draw a scale representing the current hour **/
	/* Calculate the width of the line based on current hour and minute */
	$full_width = 600;
	$curr_time = explode(":", date("H:i"));
	$mins = ((float)($curr_time[0])) * 60 + (float)($curr_time[1]);
        $percent = $mins / (60.0 * 24.0);
	$curr_width = round($full_width * $percent);
	$percent = (int)round($percent * 100);
	echo <<<EOF
            <br>
	    <!-- the upper border line -->
            <div style="background-color: magenta; width: ${full_width}px; height: 4px;"></div>

	    <!-- the container div needed to house the percentage text and time scale -->
	    <div style="height: 10px; width: ${full_width}px; 
			font: 8px bold; text-align: center;
			border: 0; padding: 0; position: relative;">
	      <!-- text showing the percentage of the day -->
	      <span style="z-index: 1; position: absolute; top: 0; line-height: 10px;
			   color: yellow;">${percent}% of the day</span>
	      <!-- the actual bar representing the current time -->
              <div style="z-index: 0; position: absolute; top: 0;
			  width: ${curr_width}px; height: 10px; margin: 0; border: 0;
			  background-color: skyblue;"></div>
	    </div>

	    <!-- the lower border line -->
            <div style="background-color: magenta; width: ${full_width}px; height: 4px;"></div>
            <br>
EOF;

	/** Display the browser information **/
        echo "The browser accessing the page is `", $_SERVER['HTTP_USER_AGENT'], "'<br>";
      ?>
    </div>


  </body>
</html>
