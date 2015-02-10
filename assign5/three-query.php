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

$query[1] = <<<"EOF_QUERY1"
SELECT e.last_name AS "Last Name",
       d.department_name AS "Department"
       FROM employees e LEFT OUTER JOIN departments d
       USING (department_id)
       WHERE UPPER(e.last_name) LIKE 'G%';
EOF_QUERY1;

$query[2] = <<<"EOF_QUERY2"
SELECT e.last_name AS "Employee",
       e.employee_id AS "Emp#",
       m.last_name AS "Manager",
       m.employee_id AS "Mgr#"
       FROM employees e INNER JOIN employees m
       ON (e.manager_id = m.employee_id)
       WHERE UPPER(e.last_name) LIKE 'T%';
EOF_QUERY2;

/* do the query */
if (($result = $mysqli->query($query)) === FALSE) {
	$error = 'Query Error (' . $mysqli->error . ') ';
	$mysqli->close();
	goto got_error;
}
?>
	<div class="row">
	  <div class="col-xs-12 col-md-8">
	    <div class="panel panel-info">
  	      <div class="panel-heading">
  		Query ###
	      </div>
              <table class="table">
  	        <thead>
  		  <tr>
  			<th>Last Name</th>
  			<th>Job</th>
  			<th>Department No</th>
  			<th>Department</th>
  		  </tr>
  	        </thead>
  	        <tbody>
<?php
/* print the results */
while ($row = $result->fetch_assoc()) {
	echo <<<"TAB_END1"
<tr>
	<td> {$row["Last Name"]} </td>
	<td> {$row["Job"]} </td>
	<td> {$row["Dept No"]} </td>
	<td> {$row["Department"]} </td>
</tr>
TAB_END1;
}
?>
	        </tbody>
              </table>
	    </div> <!-- /panel -->
          </div> <!-- /column -->
	</div>

<?php
/* close connection and leave */
$mysqli->close();
goto quit;

got_error: // report an error
	echo "Got error: " . $error;
quit:
?>


    </div> <!-- /container-fluid -->


    <hr>
    <h1>End</h1>

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
