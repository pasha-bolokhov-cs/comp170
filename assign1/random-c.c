/*
 * Assignment 1
 * Program name: random-c.cgi
 * Author: Pasha Bolokhov <pasha.bolokhov@gmail.com>
 * Date: January 8, 2014
 * Estimated Completion Time: 4-6h
 * Actual Completion Time: 8h
 * Description: 
 *     A C program (to be used as a CGI script) that prints a random number,
 *     a name (taken from QUERY_STRING), and current time, all embedded into HTML format
 * Invocation:
 *     http://site.example.com/path/random-pl.cgi?Steph
 * Requires: n/a
 */

#include <stdio.h>
#include <stdlib.h> 
#include <time.h>

int main () {
  time_t    time_sec;        /* time in seconds */
  struct tm ltime;           /* parsed time as returned by 'asctime_r()' */
  char      time_str[80];    /* time converted to a readable string */

  /* Seed the random number generator */
  srand(time(NULL));

  /* Send the header */
  printf("Content-type:text/html\n\n");

  /* HTML */
  printf("<html><title>C Example</title></head><body>");

  /* Generate a random number and display the "name" as per the query */
  printf("A random number is:%10d<br>\n ", rand());
  printf("Your name is: %20s<br>\n", getenv("QUERY_STRING"));

  /* Print the current time */
  time_sec = time(NULL);
  asctime_r(localtime_r(&time_sec, &ltime), time_str);
  printf("Current time is: %s<br>\n", time_str);

  /* Close the HTML */
  printf("</body></html>\n");
}
