###############################################################################
#
#    This file is part of CRVSTVLA
#
#    CRVSTVLA is free software; you can redistribute it and/or modify
#    it under the terms of the GNU General Public License as published by
#    the Free Software Foundation; either version 2 of the License, or
#    (at your option) any later version.
#
#    CRVSTVLA is distributed in the hope that it will be useful,
#    but WITHOUT ANY WARRANTY; without even the implied warranty of
#    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#    GNU General Public License for more details.
#
#    You should have received a copy of the GNU General Public License
#    along with CRVSTVLA; if not, write to the Free Software
#    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
#
###############################################################################
from django.shortcuts import render
from .utils.i18n import *
from .utils.recte import *
from .utils.incrementum import *
import random
from crustula.models import Gaffiot

def index(request):
    preferred_language(request)
    cognita = request.POST.get("cognita", "0")
    lex = Lexicum("radices3", cognita)
    nominatiuum = request.POST.get("priorQ", "")
    r = request.POST.get("r", "")
    s = ""
    recte = False
    resp = ""
    priorQ = ""
    if nominatiuum:
        priorQ = lex.facQgenit(nominatiuum)
    if r:
       resp = r
       r = r.strip().lower()
       s = lex.solutio2(nominatiuum)
       recte = s == r
       if recte:
           lex.succes2(nominatiuum)
       else:
           lex.echec2(nominatiuum)
    facta = lex.bilan
    discenda = len(lex.bini) - facta
    linea = lex.Qincr()
    latine = linea["latine"]
    quaestio = lex.facQgenit(latine)
    return render(request,'crustula/radicesiii.html', context={
        "priorQ": priorQ,
        "s": s,
        "recte": recte,
        "resp": resp,
        "facta": facta,
        "discenda": discenda,
        "quaestio": quaestio,
        "latine": latine,
        "cog": lex.cognita_bin,
    })
