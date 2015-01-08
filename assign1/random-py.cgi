#!/usr/bin/python

import os, random

print "Content-type:text/html\n\n"
print "A random number is: ", random.randint(1,100)
print "A Query String submitted is: ", os.environ['QUERY_STRING']

