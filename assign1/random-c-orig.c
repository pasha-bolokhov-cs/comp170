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
