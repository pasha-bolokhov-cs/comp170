#!/usr/bin/env perl
#

use strict;

print <<END;
Content-type: text/html\n
<html>
  <head>
    <title>Environment</title>
  </head>
  <body>
    <pre>
END

foreach my $key (sort keys(%ENV)) {
    print "      ", $key, " = ", $ENV{$key}, "\n";
}

print <<END;
    </pre>
  </body>
</html>
END

