from django.http import Http404
from django.shortcuts import get_object_or_404,render
from .crustula import *
from .crustula.utils.i18n import *

def index(request):
    preferred = preferred_language(request)
    response = render(request,f'crustula/index-{preferred}.html', context={})
    response.set_cookie(key='preferred_language', value=preferred,
                        max_age=604800, samesite='Strict')
    return response
