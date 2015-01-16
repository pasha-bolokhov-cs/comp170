<!-- Put header here -->

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

	/** Draw a line representing the current hour **/
	/* Calculate the width of the line based on current hour and minute */
	$full_width = 600;
	$curr_time = explode(":", date("H:i"));
	$mins = ((float)($curr_time[0])) * 60 + (float)($curr_time[1]);
	$curr_width = round($full_width * $mins / (60.0 * 24.0));
	echo <<<EOF
            <br>
            <div style="background-color: magenta; width: ${full_width}px; height: 4px;"></div>
            <div style="background-color: skyblue; width: ${curr_width}px; height: 8px;"></div>
            <div style="background-color: magenta; width: ${full_width}px; height: 4px;"></div>
            <br>
EOF;

	/** Display the browser information **/
        echo "The browser accessing the page is `", $_SERVER['HTTP_USER_AGENT'], "'<br>";
      ?>
    </div>


  </body>
</html>
