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
import random

from crustula.models import Gaffiot

def gaffiotFromLemma(vocab, lemma):
    """
    retrouve la ligne de Gaffiot étant donné un lemme
    @param vocab une liste d'objets de type Gaffiot
    @param lemma un lemme, dont le premier mot est un nominatif
    @return un objet de type Gaffiot
    """
    nom = lemma.split(" ")[0]
    for v in vocab:
        if v.latine == nom:
            return v
    return

def declin(gaf, K):
    """
    décline un mot latin
    @param gaf une entrée du Gaffiot
    @param K un cas, en "gaulois"
    """
    if K == _("nominatif"):
        return gaf.latine
    elif K == _("genitif"):
        return gaf.genitif
    elif K == _("accusatif"):
        if gaf.genre == "f":
            return gaf.latine + "m"
        else:
            return gaf.latine[:-1] + "m"
    return

def gaf2lemma(g):
    """
    Formule un lemme à partir d'une entrée de la table Gaffiot
    """
    if g.genre == "f":
        gen = "ae"
    else: # g.genre in ("m", "n")
        if g.latine.endswith("ius"):
            gen = "ii"
        else:
            gen = "i"
    return f"{g.latine} {gen}, {g.genre}. : {_(g.gallice)}"
    
def index(request):
    preferred_language(request)
    vocab = list(Gaffiot.objects.filter(comment="nag12"))
    priorQ = request.POST.get("priorQ", "")
    resp = request.POST.get("resp", "").strip()
    sol = ""
    recte = False
    priorL = ""
    if priorQ:
        eclats = priorQ.split("|")
        priorL = eclats[0]
        priorQ = eclats[1]
        priorK = priorQ.split(" ")[0]
        priorGaffiot = gaffiotFromLemma(vocab, priorL)
        sol = declin(priorGaffiot, priorK)
        recte = sol == resp
    compte_points(request, recte)
    lemme = gaf2lemma(random.choice(vocab))
    quaestio = random.choice((
        _("nominatif"), _("accusatif"), _("genitif")
    ))
    return render(request,'crustula/nag12.html', context={
        "priorQ": priorQ,
        "priorL": priorL,
        "lemme": lemme,
        "quaestio": quaestio,
        "resp": resp,
        "sol": sol,
        "recte": recte,
        'prius': request.session['prius'],
        'consec': request.session['consec'],
    })
