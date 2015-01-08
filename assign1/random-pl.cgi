#!/usr/bin/perl

$r = rand(10);
$curr_time = localtime(time);

print <<"EOF";
Content-type:text/html

<html>
    <head>
        <title>Random</title>
    </head>
    <body>
        This is a random number: $r<br>
        Your name is \`$ENV{'QUERY_STRING'}\'<br>
        Current time is: $curr_time<br>
    </body>
</html>
EOF

