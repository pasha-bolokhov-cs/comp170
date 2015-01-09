#!/usr/bin/perl

#
# Assignment 1
# Program name: random-pl-orig.cgi
# Author: Pasha Bolokhov <pasha.bolokhov@gmail.com>
# Date: January 8, 2014
# Estimated Completion Time: 4-6h
# Actual Completion Time: 8h
# Description: 
#     A CGI script that prints a random number and the QUERY_STRING,
#     all embedded into HTML format
# Invocation:
#     http://site.example.com/path/random-pl-orig.cgi?myrequest
# Requires: n/a
#


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

