#!/usr/bin/perl

$curr_time = localtime(time());

print "Content-type:text/html\n\n";
print "<html><head><title>Random</title></head><body>";
print "This is a random number: ", rand(10);
print "\n and the query string is \`$ENV{'QUERY_STRING'}\'<br>\n";
print "Current time is $curr_time<br>\n";
print "</body></html>\n";

