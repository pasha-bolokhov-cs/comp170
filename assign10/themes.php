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
session_start();

/* check if we have input */
$jsonData = file_get_contents("php://input");
$data = json_decode($jsonData);

if (count($data) != 0) {
	/* we were just asked to save the theme */
	echo "<h2> some data was sent </h2>";
} else {
	echo "<h2> no data was sent</h2>";
}
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
      Persistent Colours
    </title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">

    <!-- AngularJS needs to be loaded in "head" section -->
    <script src="angular.min.js"></script>
    <script src="angular-sanitize.min.js"></script>
  </head>



  <!-- *************** -->
  <!--                 -->
  <!-- Determine Theme -->
  <!--                 -->
  <!-- *************** -->
<?php
if (!isset($_SESSION['theme'])) {
	echo '<h2>Session not set</h2>';
	$_SESSION['theme'] = "default";
	exit;
} else {
	echo "<h2>Session set to `${_SESSION['theme']}'</h2>\n";
	echo <<<"EOF_THEME_SCRIPT"
<script>
	theme = ${_SESSION['theme']};
</script>
EOF_THEME_SCRIPT;
}

/*
 * Complete remove all session data
 */
function clear_session()
{
	setcookie(session_name(), "", time() - 3600);
	session_unset();
	session_destroy();
}
?>



  <!-- **** -->
  <!--      -->
  <!-- Body -->
  <!--      -->
  <!-- **** -->
  <body ng-app="themeApp" ng-controller="appController">
    <div class="container-fluid">



      <!----------------->
      <!-- Page Header -->
      <!----------------->
      <div class="row page-header">
	<div class="col-xs-12">
	  <h1>Persistent Colours</h1>
	</div>
      </div>



      <!------------->
      <!-- Buttons -->
      <!------------->
      <div class="row" ng-cloak>
        <div class="col-xs-12">
          <div class="btn-group">
            <label class="btn btn-default" ng-model="log_radio" ng-click="send(0)" btn-radio="'0'">
	      &nbsp;
	      <span class="glyphicon glyphicon-eye-open"></span>&nbsp;
              Clear
	      &nbsp;
            </label>
            <label class="btn btn-primary" ng-model="log_radio" ng-click="send(1)" btn-radio="'1'">
              &nbsp;
	      <span class="glyphicon glyphicon-eye-open"></span>&nbsp;
              Winter
	      &nbsp;
            </label>
            <label class="btn btn-info" ng-model="log_radio" ng-click="send(2)" btn-radio="'2'">
              &nbsp;
	      <span class="glyphicon glyphicon-eye-open"></span>&nbsp;
              Spring
	      &nbsp;
            </label>
            <label class="btn btn-warning" ng-model="log_radio" ng-click="send(3)" btn-radio="'3'">
              <span class="glyphicon glyphicon-eye-open"></span>&nbsp;
              Summer
            </label>
            <label class="btn btn-danger" ng-model="log_radio" ng-click="send(2)" btn-radio="'2'">
              <span class="glyphicon glyphicon-eye-open"></span>&nbsp;
              Autumn
            </label>
          </div>
        </div> <!-- /col-xs-12 wrapping the form-->
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
      angular.module('themeApp', ['ui.bootstrap', 'ngSanitize']);
      var app = 
      angular.module('themeApp').controller("appController",
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
