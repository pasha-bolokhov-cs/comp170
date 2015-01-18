<!-- 
    A test program to show function 'parse_url()'
-->
<html>
  <body>
    <?php
       $a_url = "https://www.microsoft.com:5030/download/windows10/beta/purchase.php?key=0aa909nf45g#accept_license";
       $components = parse_url($a_url);
       echo "A URL `${a_url}'<br> splits into components:<br><br>";
       print_r($components);
    ?>
  </body>
</html>
