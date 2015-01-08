#!/usr/bin/python

import os, random

print "Content-type:text/html\n\n"
print "<html>"
print "<head><title>Random</title></head>"
print "<body>"
print "A random number is: ", random.randint(1,100), "<br>"
print "Query String submitted is: `", os.environ['QUERY_STRING'], "'<br>"
print "</body>"
print "</html>"

