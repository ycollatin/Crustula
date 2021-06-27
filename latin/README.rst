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


Internationalization HOWTO
--------------------------

* adding a new language

