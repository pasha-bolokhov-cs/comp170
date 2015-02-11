<!--
  Assignment 5
  Program name: ##
  Author: Pasha Bolokhov <pasha.bolokhov@gmail.com>
  Date: ##
  Estimated Completion Time: ##
  Actual Completion Time: ## 
  Description: ##
  Invocation: ##
  Requires: ##
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
	  <h1>Three MySQL queries
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

$query[0] = <<<"EOF_QUERY0"
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
EOF_QUERY0;
$title[0] = "Who works in Southlake?";
$headers[0] = array("Last Name", "Job", "Dept No", "Department");


$query[1] = <<<"EOF_QUERY1"
SELECT e.last_name AS "Last Name",
       d.department_name AS "Department"
       FROM employees e LEFT OUTER JOIN departments d
       USING (department_id)
       WHERE UPPER(e.last_name) LIKE 'G%';
EOF_QUERY1;
$title[1] = "Whose name starts with `G'?";
$headers[1] = array("Last Name", "Department");


$query[2] = <<<"EOF_QUERY2"
SELECT e.last_name AS "Employee",
       e.employee_id AS "Emp#",
       m.last_name AS "Manager",
       m.employee_id AS "Mgr#"
       FROM employees e INNER JOIN employees m
       ON (e.manager_id = m.employee_id)
       WHERE UPPER(e.last_name) LIKE 'T%';
EOF_QUERY2;
$title[2] = "Bosses of those whose names start with `G'";
$headers[2] = array("Employee", "Emp#", "Manager", "Mgr#");

/* loop over the queries */
for ($i = 0; $i < count($query); $i++) {
	/* do the query */
	if (($result = $mysqli->query($query[$i])) === FALSE) {
		$error = 'Query Error (' . $mysqli->error . ') ';
		$mysqli->close();
		goto got_error;
	}
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
	  <h1>End of Queries
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
