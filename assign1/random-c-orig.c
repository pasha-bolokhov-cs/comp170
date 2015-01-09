/*
 * Assignment 1
 * Program name: random-c-orig.cgi
 * Author: Pasha Bolokhov <pasha.bolokhov@gmail.com>
 * Date: January 8, 2014
 * Estimated Completion Time: 4-6h
 * Actual Completion Time: 8h
 * Description: 
 *     A C program (build with the purpose to be used as a CGI script)
 *     that prints a random number and the QUERY_STRING, all embedded into HTML format
 * Invocation:
 *     http://site.example.com/path/random-c-orig.cgi?myrequest
 * Requires: n/a
 */


#include <stdio.h>
#include <stdlib.h> 
#include <time.h>

int main () {
  /* Seed the random number generator */
  srand(time(NULL));

  /* Send the header */
  printf("Content-type:text/html\n\n");

  /* HTML */
  printf("<html><title>C Example</title></head><body>");

  /* Generate a random number and display the environment variable QUERY_STRING" */
  printf("A random number is:%10d<br>\n ", rand());
  printf("The query string I submitted is: %20s\n", getenv("QUERY_STRING"));

  /* Close the HTML */
  printf("</body></html>");
}
