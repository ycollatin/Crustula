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

from crustula.models import Gaffiot

import random, json

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
    elif K == _("ablatif"):
        if gaf.genre == "f":
            return gaf.latine
        else:
            return gaf.latine[:-2] + "o"
    return

def desordre(l, alea):
    """
    Renvoie une phrase où les mots d'une liste sont ordonnés selon
    l'ordre de la liste de nombres alea
    """
    return " ".join([l[i] for i in alea])

def index(request):
    preferred_language(request)
    recte = False
    solutio = resp = priorsent = ""
    rs = request.POST.get("rs", "").strip()
    ra = request.POST.get("ra", "").strip()
    if rs:
        schema = json.loads(request.POST.get("schema"))
        priorsent = request.POST.get("priorsent")
        amatus = Gaffiot.fromserial(schema["o"])
        amans = Gaffiot.fromserial(schema["s"])
        recteS = declin(amatus, _("nominatif"))
        recteA = declin(amans, _("ablatif"))
        alea = schema["a"]
        solutio = desordre([recteS, "a/ab " + recteA, "amatur"], alea)
        resp = desordre([rs, f"a/ab {ra}", "amatur"], alea) + "."
        recte = recteS.lower() == rs.lower() and recteA.lower() == ra.lower()
    compte_points(request, recte)
    feminae = list(Gaffiot.objects.filter(comment="amatur", genre="f"))
    mares = list(Gaffiot.objects.filter(comment="amatur", genre="m"))
    if random.choice(("m", "f")) == "f":
        subiectus = random.choice(feminae)
        obiectus = random.choice(mares)
    else:
        subiectus = random.choice(mares)
        obiectus = random.choice(feminae)
    alea = list(range(3))
    random.shuffle(alea)
    schema = {
        "s": subiectus.serializable, "o": obiectus.serializable, "a": alea}
    sententia = [
        declin(subiectus, _("nominatif")),
        declin(obiectus,_("accusatif")),
        "amat"
    ]
    sententia = " ".join(sententia)
    
    amatus = '<input type="text" name="rs"/>' 
    amans = 'a/ab <input type="text" name="ra"/>'
    quaestio = desordre([amatus, amans, "amatur"], alea)
    return render(request,'crustula/amatur.html', context={
        "quaestio": quaestio,
        "sententia": sententia,
        "recte": recte,
        'prius': request.session['prius'],
        'consec': request.session['consec'],
        "schema": json.dumps(schema),
        "resp": resp,
        "solutio": solutio,
        "priorsent": priorsent,
    })
