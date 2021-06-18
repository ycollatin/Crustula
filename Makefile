DESTDIR =
SUBDIRS = lang

all:
	@for d in $(SUBDIRS); do $(MAKE) -C $$d $@ DESTDIR=$(DESTDIR) ; done
clean:
	rm -f *~
	@for d in $(SUBDIRS); do $(MAKE) -C $$d $@ DESTDIR=$(DESTDIR) ; done

install:
	@for d in $(SUBDIRS); do $(MAKE) -C $$d $@ DESTDIR=$(DESTDIR) ; done

.PHONY: all clean install
