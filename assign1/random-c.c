#include <stdio.h>
#include <stdlib.h> 
#include <time.h>

int main () {
  time_t    time_sec;
  char      time_str[80];
  struct tm ltime;

  /* Seed the random number generator */
  srand(time(NULL));

  /* Send the header */
  printf("Content-type:text/html\n\n");

  /* HTML */
  printf("<html><title>C Example</title></head><body>");

  /* Generate a random number and display the environment variable QUERY_STRING" */
  printf("A random number is:%10d<br>\n ", rand());
  printf("Your name is: %20s<br>\n", getenv("QUERY_STRING"));
  time_sec = time(NULL);
  asctime_r(localtime_r(&time_sec, &ltime), time_str);
  printf("Current time is: %s<br>\n", time_str);

  /* Close the HTML */
  printf("</body></html>");
}
