import os, sys
from django.urls import path

from . import views

urlpatterns = [
    path('', views.index, name='index'),
]


c_dir = os.path.join("crustula", "crustula")
for root, dirs, files in os.walk(c_dir):
    if root == os.path.join(c_dir):
        for f in files:
            if not f.endswith(".py"): continue
            url = f[:-3]
            mod_name = f"crustula.crustula.{url}"
            try:
                imported_module = __import__(
                    mod_name, globals=None, locals=None, fromlist=True)
                sys.modules[imported_module.__name__] = imported_module
                globals()[imported_module.__name__] = imported_module
                urlpatterns.append(path(url, imported_module.index, name = url))
            except ModuleNotFoundError as e:
                print(e)
