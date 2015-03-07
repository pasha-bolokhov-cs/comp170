<?php
/* 
  Assignment 10
  Program name: themes.php
  Author: Pasha Bolokhov <pasha.bolokhov@gmail.com>
  Date: March 7, 2015
  Estimated Completion Time: 8 hr
  Actual Completion Time: 12 hr
  Description: 
	A PHP program which allows the user to chooser different themes (CSS classes)
	and saves the choice in a PHP session
  Invocation: via URL
  Requires: n/a
 */

/* start or restore a session */
session_start();

/* check if we have input */
$jsonData = file_get_contents("php://input");
$data = json_decode($jsonData);

/* we were just asked to save the theme: save and exit */
if (count($data) != 0 && property_exists($data, "theme")) {
	switch ($data->theme) {
	case "clear":
		clear_session();
		exit;

	default:
		$_SESSION["theme"] = $data->theme;
		exit;
	}
}

/*
 * Completely remove all session data
 */
function clear_session()
{
	session_unset();
	session_destroy();
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

    <!-- Our themes -->
    <link rel="stylesheet" href="themes.css">
  </head>



  <!-- *************** -->
  <!--                 -->
  <!-- Determine Theme -->
  <!--                 -->
  <!-- *************** -->
<?php
if (!isset($_SESSION['theme'])) 
	$_SESSION['theme'] = "default";

/* set 'theme' Javascript variable */
echo <<<"EOF_THEME_SCRIPT"
<script>
	theme = "${_SESSION['theme']}";
</script>
EOF_THEME_SCRIPT;
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
	  <h1 class="text-center">Persistent Colours</h1>
	</div>
      </div>


    </div> <!-- /container-fluid -->



    <!------------->
    <!-- Content -->
    <!------------->
    <div class="jumbotron" ng-class="theme">
      <div class="container">

        <div class="row" ng-cloak>
	  <div class="col-xs-12">
	    <div class="lead text-center">
		  <h1>Colours of the <em>{{ theme }}</em> season</h1>
		  <h2><em>Experience</em>... the persistence of colours</h2>
		  <br>
		  Across a refreshed page
	    </div>
	  </div>
        </div>



        <!------------->
        <!-- Buttons -->
        <!------------->
	<br>
	<br>        
        <hr>
        <div class="row" ng-cloak>
          <div class="col-xs-12 text-center">
            <div class="btn-group">
              <label class="btn btn-default" ng-model="log_radio" ng-click='send("clear")' btn-radio="'0'">
        	&nbsp;
        	<span class="glyphicon glyphicon-eye-open"></span>&nbsp;
                Clear
        	&nbsp;
              </label>
              <label class="btn btn-primary" ng-model="log_radio" ng-click='send("winter")' btn-radio="'1'">
		&nbsp;
        	<span class="glyphicon glyphicon-eye-open"></span>&nbsp;
		Winter
        	&nbsp;
              </label>
              <label class="btn btn-info" ng-model="log_radio" ng-click='send("spring")' btn-radio="'2'">
                &nbsp;
        	<span class="glyphicon glyphicon-eye-open"></span>&nbsp;
                Spring
        	&nbsp;
              </label>
              <label class="btn btn-warning" ng-model="log_radio" ng-click='send("summer")' btn-radio="'3'">
                <span class="glyphicon glyphicon-eye-open"></span>&nbsp;
                Summer
              </label>
              <label class="btn btn-danger" ng-model="log_radio" ng-click='send("autumn")' btn-radio="'4'">
                <span class="glyphicon glyphicon-eye-open"></span>&nbsp;
                Autumn
              </label>
            </div>
          </div> <!-- /col-xs-12 wrapping the form-->
        </div> <!-- /row -->


      </div> <!-- /container -->
    </div> <!-- /jumbotron -->



    <div class="container-fluid">



      <!------------->
      <!-- Results -->
      <!------------->

      <!-- error message -->
      <hr ng-show="showResult || waiting">
      <div class="row" ng-show="showResult && error" ng-cloak>
	<div class="col-xs-12 col-md-8 col-md-offset-2">
	  <alert class="text-center" type="danger" close="reset()">{{ error }}</alert>
	</div>
      </div> <!-- /div with any errors -->

      <!-- ... loading ... -->
      <div class="row" ng-show="waiting">
	<div class="col-xs-12 col-md-8 col-md-offset-2">
	  <alert class="text-center" type="warning"><em>...&nbsp;loading&nbsp;...</em></alert>
	</div>
      </div> <!-- /div with ...loading... -->

      <!-- actual results -->
      <div class="row" ng-show="showResult && !error" ng-cloak>
	<div class="col-xs-12 col-md-8 col-md-offset-2">
	  <alert type="info" class="text-center" close="reset()">
	    {{ result }}
	  </alert>
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

		// Permanent initialization
		$scope.theme = theme;

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

		$scope.send = function(chosenTheme) {
			/* Re-initialize */
			$scope.error = false;
			/** Not really waiting long time here
				$scope.waiting = true;
			*/
			$scope.showResult = false;

			/* take on the chosen theme */
			if (chosenTheme === "clear")
				$scope.theme = "default";
			else
				$scope.theme = chosenTheme;
			$scope.request["theme"] = chosenTheme;

			/* Request object is ready to send */

			// Send the request to the PHP script
			$http.post("themes.php", $scope.request)
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

				// We do not need any result here except when error or cleared
				if (!$scope.error)
					$scope.showResult = false;
				if (chosenTheme === "clear") {
					$scope.showResult = true;
					$scope.result = "Session cleared";
				}
			});
		}	/* send() */

      });
    </script>
  </body>

</html>
