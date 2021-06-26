from django.http import Http404
from django.shortcuts import get_object_or_404,render
from .crustula import *

def index(request):
    return render(request,'crustula/index.html', context={})
