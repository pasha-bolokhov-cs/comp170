#!/usr/bin/perl

#
# Assignment 1
# Program name: random-pl.cgi
# Author: Pasha Bolokhov <pasha.bolokhov@gmail.com>
# Date: January 8, 2014
# Estimated Completion Time: 4-6h
# Actual Completion Time: 8h
# Description: 
#     A CGI script that prints a random number, a name (taken from QUERY_STRING),
#     and current time, all embedded into HTML format
# Invocation:
#     http://site.example.com/path/random-pl.cgi?Meagan
# Requires: n/a
#


# generate a random number
$r = rand(10);

# get the current time
$curr_time = localtime(time);

# print the random number, QUERY_STRING and 
# the current time wrapped in HTML
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

