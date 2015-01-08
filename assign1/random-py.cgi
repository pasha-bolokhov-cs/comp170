#!/usr/bin/python

import os, random, time

print "Content-type:text/html\n\n"
print "<html>"
print "<head><title>Random</title></head>"
print "<body>"
print "A random number is: ", random.randint(1,100), "<br>"
print "Your name is: `", os.environ['QUERY_STRING'], "'<br>"
print "Current time is: %s<br>" % time.asctime(time.localtime())
print "</body>"
print "</html>"

