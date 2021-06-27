CRUSTULA, Python implementation
===============================

This implementation is based on Python + Django + SQLite database

The internationalisation is done with Gettext.

Creating/maintaing a crustulum
------------------------------

Every crustulum is in the directory :code:`crustula/crustula`.
A model can be taken with the file :code:`crustula/crustula/sov.py`.

Those lines are mandatory at the begin of a crustulum:

.. code-block:: python

    from django.shortcuts import render
    from .utils.i18n import *


There must be one function named index, with that template:

.. code-block:: python


    def index(request):
        preferred_language(request)
	#####################################
	#                                   #
	# as many program lines as you want #
	#                                   #
	#####################################
	return render(request,'crustula/foo.html', context={
	    "foo_var1": val1,
	    "foo_var2": val2,
	    ...
	})


That will work with a file located in
:code:`crustula/templates/crustula/foo.html` as a Jinja2 template,
where :code:`{{ foo_var1 }}` is dynamically replaced by :code:`val1`'s
value, :code:`{{ foo_var2 }}` by :code:`val2`'s value, and so on.

One can make a copy of the file :code:`crustula/crustula/SAMPLE.py` as a basis
to develop new crustula; the begin of the file mentions a GPL-2+ license.

Internationalization HOWTO
--------------------------

**How to add a new language**
    Make a new directory; for example for German language, it should be
    :code:`locale/de/LC_MESSAGES`; then run :code:`./manage.py makemessages` to
    create a new localisation file, which should appear as
    :code:`locale/de/LC_MESSAGES/django.po`

**Translate HTML contents**	  
    Find files which miss a translation and create them. For example, one
    should create the file :code:`crustula/templates/crustula/index-de.html`,
    based on the contents of similar localized files.

**Translate or maintain the translation in PO file**
    Run :code:`./manage.py makemessages` to update translatable strings,
    then edit the PO file. For example for German language, one should edit
    the file :code:`locale/de/LC_MESSAGES/django.po`. The comments in this
    file refer to parts of crustula's conde which contain translatable
    strings. Untranslated strings will appear as they were defined in the
    programs, in original form.

**Compile translations to make them active**
    Run the command :code:`./manage.py compilemessages`. This will generate
    MO files, like :code:`locale/de/LC_MESSAGES/django.mo`. MO files are
    mandatory to let Python display translated strings.


    

