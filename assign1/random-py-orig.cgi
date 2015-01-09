#!/usr/bin/python

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
#     http://site.example.com/path/random-py-orig.cgi?myrequest
# Requires: n/a
#

import os, random

print "Content-type:text/html\n\n"
print "<html>"
print "<head><title>Random</title></head>"
print "<body>"
print "A random number is: ", random.randint(1,100), "<br>"
print "Query String submitted is: `%s'<br>" % os.environ['QUERY_STRING']
print "</body>"
print "</html>"

