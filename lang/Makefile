DESTDIR =
TRANSLATABLE = $(shell ls ../*.php)
POFILES      = $(shell ls *.po)
LANGUAGES    = $(patsubst %.po,%,$(POFILES))
MOFILES      = $(patsubst %.po,locale/%/LC_MESSAGES/crustula.mo,$(POFILES))


all: messages.pot $(POFILES) $(MOFILES)
	@for d in $(SUBDIRS); do $(MAKE) -C $$d $@ DESTDIR=$(DESTDIR) ; done

messages.pot: $(TRANSLATABLE)
	xgettext -o $@ $(TRANSLATABLE) --join-existing --language=PHP --from-code=utf-8

%.po: messages.pot
	msgmerge --update $@ messages.pot

locale/%/LC_MESSAGES/crustula.mo: %.po
	d=$$(dirname $@); [ -d $$d ] || mkdir -p $$d
	msgfmt -o $@ $<

clean:
	rm -f *~
	@for d in $(SUBDIRS); do $(MAKE) -C $$d $@ DESTDIR=$(DESTDIR) ; done

install:
	@for d in $(SUBDIRS); do $(MAKE) -C $$d $@ DESTDIR=$(DESTDIR) ; done

.PHONY: all clean install
