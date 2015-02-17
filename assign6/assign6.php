<!--
  Assignment 5
  Program name: query.html
  Author: Pasha Bolokhov <pasha.bolokhov@gmail.com>
  Date: February 10, 2015
  Estimated Completion Time: 6 hr
  Actual Completion Time: 16 hr
  Description:
	Displays a web form for a simple SELECT query for MySQL,
	and sends it to 'query.php' script, then displays the reply
  Invocation: via URL
  Requires: n/a
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
      SQL Query
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
  <body ng-app="queryApp" ng-controller="queryController">
    <div class="container-fluid">



      <!----------------->
      <!-- Page Header -->
      <!----------------->
      <div class="row page-header">
	<div class="col-xs-12">
	  <h1>SQL Query</h1>
	</div>
      </div>



      <!-------------->
      <!-- The form -->
      <!-------------->
      <div class="row" ng-cloak>
	<div class="col-xs-12">
	  <form ng-submit="send()" name="sqlform" novalidate>

	    <!-- Select -->
	    <div class="row">
	      <div class="col-xs-12 col-md-2 well well-sm text-center">select</div>
	      <div class="col-xs-12 col-md-4">
		<input type="text" placeholder="<what>" ng-model="request.what" class="form-control">
	      </div>
	    </div> <!-- Select -->

	    <!-- From -->
	    <div class="row">
	      <div class="col-xs-12 col-md-2 well well-sm text-center">from</div>
	      <div class="col-xs-12 col-md-4">
		<input type="text" placeholder="<tables>" ng-model="request.from" class="form-control">
	      </div>
	    </div> <!-- From -->

	    <!-- Where -->
	    <div class="row">
	      <div class="col-xs-12 col-md-2 well well-sm text-center">where</div>
	      <div class="col-xs-12 col-md-4">
		<input type="text" placeholder="<optional conditions>" ng-model="request.where" class="form-control">
	      </div>
	    </div> <!-- Where -->

	    
	    <div class="row">
	      <!-- Go -->
	      <div class="col-xs-12 col-md-offset-2 col-md-2">
		<button type="submit" class="btn btn-primary btn-lg">
		  <span class="glyphicon glyphicon-fire" aria-hidden="true"></span>
		  &nbsp;Go&nbsp;&nbsp;&nbsp;&nbsp;
		</button>
	      </div> <!-- Go -->

	      <!-- Clear -->
	      <div class="col-xs-12 col-md-3">
		<button type="reset" ng-click="reset()" class="btn btn-warning btn-lg">
		  <span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span>
		  &nbsp;Clear
		</button>
	      </div> <!-- Clear -->
	    </div>
	  </form>
	</div> <!-- /col-xs-12 wrapping the form -->
      </div> <!-- /row -->



      <!------------->
      <!-- Results -->
      <!------------->

      <!-- error message -->
      <hr ng-show="showResult || waiting">
      <div class="row" ng-show="showResult && error" ng-cloak>
	<div class="col-xs-12 col-md-8">
	  <alert class="text-center" type="danger" close="reset()">{{ error }}</alert>
	</div>
      </div> <!-- /div with any errors -->

      <!-- ... loading ... -->
      <div class="row" ng-show="waiting">
	<div class="col-xs-12 col-md-8">
	  <alert class="text-center" type="warning"><em>...&nbsp;loading&nbsp;...</em></alert>
	</div>
      </div> <!-- /div with ...loading... -->

      <!-- actual results -->
      <div class="row" ng-show="showResult && !error" ng-cloak>
	<div class="col-xs-12 col-md-10">
          <table class="table">
	    <thead>
	      <tr>
		<th ng-repeat="h in headers">
		  {{ h }}
		</th>
	      </tr>
	    </thead>
	    <tbody>
	      <tr ng-repeat="row in results">
		<td ng-repeat="h in headers">
		  {{ getColumn(h, row) }}
		</td>
	      </tr>
	    </tbody>
          </table>
	</div>
      </div> <!-- /div with the results -->
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
      angular.module('queryApp', ['ui.bootstrap']);
      angular.module('queryApp').controller("queryController",
	function($scope, $http) {

		// Resettable data initialization
		$scope.reset = function() {
			// Initialization
			$scope.showResult = false;
			$scope.error = false;
			$scope.waiting = false;
	
			// Data Initialization
			$scope.request = {};
			$scope.results = undefined;
		}
		$scope.reset();

		// Function to be used for a nested 'ng-repeat'
		$scope.getColumn = function(header, row) {
			return row[header];
		}

		// Function attached to the buttons
		$scope.send = function() {
			/* Re-initialize */
			$scope.error = false;
			$scope.waiting = true;
			$scope.showResult = false;

			/* Request object is ready to send */

			// Send the request to the PHP script
			$http.post("query.php", $scope.request)
			.success(function(data) {
				// process the response
				if (data["error"]) {
					$scope.error = "Error: " + data["error"];
 				} else {
					$scope.results = data["data"];
					$scope.headers = data["headers"];
				}
			})
			.error(function(data, status) {
				console.log(data);
				$scope.error = "Error accessing the server: " + status + ".";
			})
			.finally(function() { 
				// Indicate that we have an answer
				$scope.waiting = false;
				$scope.showResult = true;
			});
		}	/* send() */

      });
    </script>
  </body>

</html>
