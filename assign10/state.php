<?php
/* 
  Assignment 10
  Program name: ##
  Author: Pasha Bolokhov <pasha.bolokhov@gmail.com>
  Date: ##
  Estimated Completion Time: ##
  Actual Completion Time: ## 
  Description: ##
  Invocation: ##
  Requires: ##
 */
?>
<html>
  <!-- **** -->
  <!--      -->
  <!-- Head -->
  <!--      -->
  <!-- **** -->
  <head>
    <!-- Title -->
    <title>
      Theme selection
    </title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">

    <!-- AngularJS needs to be loaded in "head" section -->
    <script src="angular.min.js"></script>
    <script src="angular-sanitize.min.js"></script>
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
	  <h1>Stateful Theme Selection</h1>
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
		<input type="text" placeholder="<what>" name="what" ng-model="request.what" 
		       ng-pattern="/^[^;]*$/" class="form-control" required>
	      </div>
	      <div class="col-xs-12 col-md-4">
		<span class="text-center error"
		       ng-show="sqlform.what.$dirty && sqlform.what.$error.pattern">
		  semicolon forbidden
		</span>
	      </div>
	    </div> <!-- Select -->

	    <!-- From -->
	    <div class="row">
	      <div class="col-xs-12 col-md-2 well well-sm text-center">from</div>
	      <div class="col-xs-12 col-md-4">
		<input type="text" placeholder="<tables>" name="from" ng-model="request.from"
		       ng-pattern="/^[^;]*$/" class="form-control" required>
	      </div>
	      <div class="col-xs-12 col-md-4">
		<span class="text-center error"
		       ng-show="sqlform.from.$dirty && sqlform.from.$error.pattern">
		  semicolon forbidden
		</span>
	      </div>
	    </div> <!-- From -->

	    <!-- Where -->
	    <div class="row">
	      <div class="col-xs-12 col-md-2 well well-sm text-center">where</div>
	      <div class="col-xs-12 col-md-4">
		<input type="text" placeholder="<optional conditions>" name="where" ng-model="request.where" 
		       ng-pattern="/^[^;]*$/" class="form-control">
	      </div>
	      <div class="col-xs-12 col-md-4">
		<span class="text-center error"
		       ng-show="sqlform.where.$dirty && sqlform.where.$error.pattern">
		  semicolon forbidden
		</span>
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

	    </div> <!-- Row of Buttons -->
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
	<div class="col-xs-12 col-md-10" ng-bind-html="result">
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
      angular.module('queryApp', ['ui.bootstrap', 'ngSanitize']);
      var queryApp = 
      angular.module('queryApp').controller("queryController",
	function($scope, $http, $sce) {

		// Resettable data initialization
		$scope.setup = function() {
			// Initialization
			$scope.showResult = false;
			$scope.error = false;
			$scope.waiting = false;
	
			// Data Initialization
			$scope.request = {};
			$scope.result = undefined;
		}
		$scope.setup();		

		// Function attached to the buttons
		$scope.reset = function() {
			/* reset the data */
			$scope.setup();

			/* mark form as pristine */
			$scope.sqlform.$setPristine();
		}	/* reset() */

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
					$scope.result = $sce.trustAsHtml(data["data"]);
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
