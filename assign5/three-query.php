<!--
  Assignment 5
  Program name: three-query.php
  Author: Pasha Bolokhov <pasha.bolokhov@gmail.com>
  Date: February 10, 2015
  Estimated Completion Time: 6 hr
  Actual Completion Time: 16 hr
  Description:
	Sends three queries to 'mysqld' and displays the result
  Invocation: via URL
  Requires: 
	File 'mysqli_connect.php' must be sitting at the appropriate path
--> 
<html>
  <!-- **** -->
  <!--      -->
  <!-- Head -->
  <!--      -->
  <!-- **** -->
  <head>
    <!-- Title -->
    <title>
      Three MySQL queries
    </title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">

    <!-- AngularJS needs to be loaded in "head" section -->
    <script src="angular.min.js"></script>
  </head>



  <!-- **** -->
  <!--      -->
  <!-- Body -->
  <!--      -->
  <!-- **** -->
  <body ng-app="mysqlApp" ng-controller="buttonController">
    <div class="container-fluid">



      <!----------------->
      <!-- Page Header -->
      <!----------------->
      <div class="row page-header">
	<div class="col-xs-12">
	  <h1>Three MySQL queries</h1>
	</div>
      </div>


      <!------------->
      <!-- Results -->
      <!------------->
<?php
/* connect to the database */
require_once '../../../comp170-www/msqli_connect.php';

if ($mysqli->connect_error) {
	$error = 'Connect Error (' . $mysqli->connect_errno . ') '
		. $mysqli->connect_error;
	goto got_error;
}

$query = array();
$title = array();
$headers = array();

$query[] = <<<"EOF_SOUTHLAKE"
SELECT e.last_name AS "Last Name", 
       job_title AS "Job",
       department_id AS "Dept No", 
       d.department_name AS "Department"
       FROM employees e INNER JOIN departments d
       USING (department_id)
       INNER JOIN jobs j
       USING (job_id)
       INNER JOIN locations l
       ON (d.location_id = l.location_id)
       WHERE UPPER(l.city) LIKE 'SOUTHLAKE';
EOF_SOUTHLAKE;
$title[] = "Who works in Southlake?";
$headers[] = array("Last Name", "Job", "Dept No", "Department");


$query[] = <<<"EOF_SOUTHLAKE_TRAD"
SELECT e.last_name AS "Last Name",
       j.job_title AS "Job",
       e.department_id AS "Dept No", 
       d.department_name AS "Department"
       FROM employees e, departments d, jobs j, locations l
       WHERE e.department_id = d.department_id
       AND e.job_id = j.job_id
       AND d.location_id = l.location_id
       AND UPPER(l.city) LIKE 'SOUTHLAKE';
EOF_SOUTHLAKE_TRAD;
$title[] = "Who works in Southlake? (Traditional)";
$headers[] = array("Last Name", "Job", "Dept No", "Department");


$query[] = <<<"EOF_G"
SELECT e.last_name AS "Last Name",
       d.department_name AS "Department"
       FROM employees e LEFT OUTER JOIN departments d
       USING (department_id)
       WHERE UPPER(e.last_name) LIKE 'G%';
EOF_G;
$title[] = "Whose name starts with `G'?";
$headers[] = array("Last Name", "Department");

$query[] = <<<"EOF_G_TRAD"
SELECT e.last_name AS "Last Name",
       d.department_name AS "Department"
       FROM employees e, departments d
       WHERE (e.department_id = d.department_id(+))
       AND UPPER(e.last_name) LIKE 'G%';
EOF_G_TRAD;
$title[] = "Whose name starts with `G'? (Traditional)";
$headers[] = array("Last Name", "Department");


$query[] = <<<"EOF_BOSSES"
SELECT e.last_name AS "Employee",
       e.employee_id AS "Emp#",
       m.last_name AS "Manager",
       m.employee_id AS "Mgr#"
       FROM employees e INNER JOIN employees m
       ON (e.manager_id = m.employee_id)
       WHERE UPPER(e.last_name) LIKE 'T%';
EOF_BOSSES;
$title[] = "Bosses of those whose names start with `G'";
$headers[] = array("Employee", "Emp#", "Manager", "Mgr#");


$query[] = <<<"EOF_BOSSES_TRAD"
SELECT e.last_name AS "Employee",
       e.employee_id AS "Emp#",
       m.last_name AS "Manager",
       m.employee_id AS "Mgr#"
       FROM employees e, employees m
       WHERE (e.manager_id = m.employee_id)
       AND UPPER(e.last_name) LIKE 'T%';
EOF_BOSSES_TRAD;
$title[] = "Bosses of those whose names start with `G' (Traditional)";
$headers[] = array("Employee", "Emp#", "Manager", "Mgr#");


/* loop over the queries */
for ($i = 0; $i < count($query); $i++) {
	/* do the query */
	if (($result = $mysqli->query($query[$i])) === FALSE) {
?>
	<div class="row">
	  <div class="col-xs-12 col-md-8">
	    <div class="panel panel-info">
  	      <div class="panel-heading">
<?php echo $title[$i]; ?>
	      </div>
	      <div class="panel-body">
		<pre><?php echo $query[$i]; ?></pre>
		<pre>Query Error (<?php echo $mysqli->error; ?>)</pre>
	      </div>
	    </div> <!-- /panel -->
          </div> <!-- /column -->
	</div> <!-- /row -->
<?php
	} else {  // if (error)
?>
	<div class="row">
	  <div class="col-xs-12 col-md-8">
	    <div class="panel panel-info">
  	      <div class="panel-heading">
<?php echo $title[$i];?>
	      </div>
	      <!-- Table contents depends on $i -->
              <table class="table">
  	        <thead>
  		  <tr>
<?php
		/* print the table header */
		for ($j = 0; $j < count($headers[$i]); $j++) {
			echo "<th> {$headers[$i][$j]} </th>";
		}
?>
  		  </tr>
  	        </thead>
  	        <tbody>
<?php
		/* print the results */
		while ($row = $result->fetch_assoc()) {
			echo "<tr>";
			for ($j = 0; $j < count($headers[$i]); $j++) {
				echo "<td> {$row[$headers[$i][$j]]} </td>";
			}
			echo "</tr>";
		} // while ($row)
?>
	        </tbody>
              </table>
	    </div> <!-- /panel -->
          </div> <!-- /column -->
	</div> <!-- /row -->

<?php
	} /* else of error */
} // for ($i)

/* close connection and leave */
$mysqli->close();
goto quit;

got_error: // report an error
	echo "Got error: " . $error;
quit:
?>

      <div class="row">
	<div class="col-xs-12">
	  <hr>
	  <h1>End of Queries</h1>
	</div>
      </div>


    </div> <!-- /container-fluid -->



    <!----------------------------------------->
    <!-- JQuery, Bootstrap, and Bootstrap UI -->
    <!----------------------------------------->
    <script src="jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="ui-bootstrap-tpls.min.js"></script>

    <!------------------------------------>
    <!-- Angular module and Controllers -->
    <!------------------------------------>
    <script>
      angular.module('mysqlApp', ['ui.bootstrap']);
    </script>
  </body>

</html>
