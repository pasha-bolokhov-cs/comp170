

SRC	=	random-c.c random-c-orig.c

PROGS	=	random-c.cgi random-c-orig.cgi

.PHONY: all
all: $(PROGS)

%.cgi: %.c
	$(CC) -o $@ $<

clean:
	-rm -f *~

