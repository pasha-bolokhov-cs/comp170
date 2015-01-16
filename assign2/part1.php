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
    <div>
      <?php
        echo "Hello World<br>";
        echo "The name given is `", $_GET['name'], "'<br>";
	echo "Current date is ", date("Y-m-d H:i:s"), "<br>";
        echo "The browser accessing the page is `", $_SERVER['HTTP_USER_AGENT'], "'<br>";
      ?>
    </div>

    <br>
    <div style="background-color: red; width: 800px; height: 2px; margin-bottom: 2px"><div>
    <div style="background-color: magenta; width: 600px; height: 2px; margin-bottom: 2px;"><div>
    <div style="background-color: red; width: 800px; height: 2px; margin-bottom: 2px;"><div>

  </body>
</html>
