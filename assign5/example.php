<!-- 
	Title=Example of selecting data from a MySQL database
-->
<html>
  <head>
    <title>Test MySQL</title>
  </head>
  <body>
<?php

// Connect to the MySQL server.
$link = mysqli_connect("localhost", "170user", "phphasclass");
// Die if no connect
if (!$link) {
	die('Could not connect: ' . mysqli_error($link));
}

// Choose the DB and run a query.
mysqli_select_db($link, "comp170");
$result = mysqli_query($link, "select * from jobs");
echo mysqli_error($link);

// Display the results.
echo "Results...<br>";
if ($result) {
	while ($x=mysqli_fetch_row($result)) {
		echo "$x[0], $x[1], $x[2], $x[3]<br>\n";
	}
?>
    <p>
    <table border=1>
      <tr>
<?php
	// Reset the result pointer and display again in a table with titles.  Note the 
	// only reason for reseting the result pointer is that we are using the results
	// of the query twice.  Once plain output and again as a table. There is no need
	// to reset the pointer if you are only using it once, and it is a waste of time
	// resources.
	mysqli_data_seek($result, 0);
	
	// Fetch a row with the column labels
	$x = mysqli_fetch_assoc($result);
	
	// Print the column labels
	foreach (array_keys($x) as $k) {
		echo "<td><b>$k</b></td>";
	}
	echo "</tr><tr>";
	
	// Echo the values for the first row
	foreach ($x as $v) {
		echo "<td>$v</td>";
	}
	echo "</tr><tr>";
	
	// Print the rest of the rows.
	while ($x=mysqli_fetch_row($result)) {
		foreach ($x as $v) {
			echo "<td>$v</td>";
		}
		echo "</tr><tr>";
	}
} // if ($result) 
?>
      </tr>
    </table>
  </body>
</html>
