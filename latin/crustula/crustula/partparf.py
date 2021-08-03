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
from django.db.models import Q
from .utils.i18n import *
from .utils.recte import *

from crustula.models import Uerbum

import random, re, json

def index(request):
    preferred_language(request)
    recte = False
    solutio = resp = priorQ = traductio = ""
    
    if request.method == "POST":
        priorQ = request.POST.get("priorQ")
        schema = json.loads(request.POST.get("schema"))
        resp = request.POST.get("resp")
        uerb = Uerbum.fromserial(schema["u"])
        lingua = schema["l"]
        genus = schema["g"]
        if lingua == "l":
            solutio = uerb.galConiug(mode="partic", genre = genus)
        else:
            solutio = uerb.latConiug(mode="partic", genre = genus)
        recte = solutio.lower() == resp.strip().lower()
    compte_points(request, recte)
    # choisir des verbes, qui contiennent des virgules dans self.latine
    uerba = list(Uerbum.objects.filter(~Q(name="sum")))
    uerb = random.choice(uerba)
    lingua = random.choice(('l', 'g'))
    genus = random.choice(('m', 'f', 'n'))
    schema = json.dumps({"u": uerb.serializable, "l" : lingua, "g": genus})
    traduc = re.split(r", *", uerb.gallice)[0]
    quaestio = f"{uerb.latine} : {traduc}<br/>"
    if lingua == "l":
        quaestio += uerb.latConiug(mode="partic", genre = genus)
        traductio = _('traduction ?')
    else:
        quaestio += _("participe parfait")
        if genus == "m":
            quaestio += " " + _("masculin")
        elif genus == "f":
            quaestio += " " + _("féminin")
        else: # genus == "n"
            quaestio += " " + _("neutre")
    return render(request,'crustula/partparf.html', context={
        "priorQ": priorQ.replace("<br/>", " ; "),
        "quaestio": quaestio,
        "schema": schema,
        "resp": resp,
        "solutio": solutio,
        "traductio": traductio,
        "recte": recte,
        'prius': request.session['prius'],
        'consec': request.session['consec'],
    })
