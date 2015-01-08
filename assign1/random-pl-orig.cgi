#!/usr/bin/perl

$r = rand(10);

print <<"EOF";
Content-type:text/html

<html>
    <head>
        <title>Random</title>
    </head>
    <body>
        This is a random number: $r
        and the query string is \`$ENV{'QUERY_STRING'}\'<br>
    </body>
</html>
EOF

