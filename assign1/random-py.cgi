#!/usr/bin/python

#
# Assignment 1
# Program name: random-py.cgi
# Author: Pasha Bolokhov <pasha.bolokhov@gmail.com>
# Date: January 8, 2014
# Estimated Completion Time: 4-6h
# Actual Completion Time: 8h
# Description: 
#     A CGI script that prints a random number, a name (taken from QUERY_STRING),
#     and current time, all embedded into HTML format
# Invocation:
#     http://site.example.com/path/random-py.cgi?Teagan
# Requires: n/a
#


import os, random, time

print "Content-type:text/html\n\n"
print "<html>"
print "<head><title>Random</title></head>"
print "<body>"
print "A random number is: ", random.randint(1,100), "<br>"
print "Your name is: `%s'<br>" % os.environ['QUERY_STRING']
print "Current time is: %s<br>" % time.asctime(time.localtime())
print "</body>"
print "</html>"

