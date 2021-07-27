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
import random, json, re

from crustula.models import Sum, Uerbum

def sententia():
    """
    Tire au sort un nombre et une personne, puis un attribut
    @return le nombre "s" ou "p", la personne 1, 2 ou 3, l'attribut de type Sum
    """
    pers = random.randint(1,3)
    nomb = random.choice(("s","p"))
    if pers < 3:
        attr = random.choice(list(Sum.objects.filter(genus="homines")))
    else:
        attr = random.choice(list(Sum.objects.filter(genus="homines")) +
                             list(Sum.objects.filter(genus="alia")))
    return nomb, pers, attr

def sent_gallice(subiect, sum, nomb, pers, attr):
    return  _("{subiect}{uerb} {attr}").format(
        subiect =subiect[nomb][pers],
        uerb = sum.galConiug(pers, nomb),
        attr = attr.galNom(nomb)
    )

def sent_latine(subiect, sum, nomb, pers, attr):
    return "{attr} {uerb}.".format(
           attr = attr.latNom(nomb),
           uerb = sum.latConiug(pers, nomb)
       )

def index(request):
    preferred_language(request)
    sum = Uerbum.objects.get(name="sum")
    subiect = {
        "s": {
            1: _("Je "),
            2: _("Tu "),
            3: _("C'")
        },
        "p": {
            1: _("Nous "),
            2: _("Vous "),
            3: _("Ce ")
        }
    }

    nomb, pers, attr = sententia()
    sentGallice = sent_gallice(subiect, sum, nomb, pers, attr)
    resp = question = sentLatine = priorsent = ""
    s = ""
    recte = False
    prius = request.session.get("prius", 0)
    request.session["prius"] = prius
    consec = request.session.get("consec", 0)
    request.session["consec"] = consec
    schema = request.POST.get("schema", "")
    r = request.POST.get("r", "")
    if r:
       resp = r
       decoded = json.loads(schema)
       prevNomb = decoded["nomb"]
       prevPers = decoded["pers"]
       prevAttr = Sum.fromserial(decoded["attr"])
       sentLatine = sent_latine(subiect, sum, prevNomb, prevPers, prevAttr)
       priorsent = sent_gallice(subiect, sum, prevNomb, prevPers, prevAttr)
       r = r.replace(".","").strip().lower()
       s = sentLatine.replace(".","").strip().lower()
       recte = set(re.split(r"\s+", r)) == set(re.split(r"\s+", s))
       if recte:
            request.session["consec"] += 1
       else:
            if request.session['consec'] > request.session['prius']:
                request.session['prius'] = request.session['consec']
            request.session['consec']=0
    else: ## r = ""
        request.session["consec"] = 0
        request.session['prius']  = 0
    return render(request,'crustula/sum.html', context={
        "question": sentGallice,
        "schema": json.dumps({
            "nomb": nomb, "pers": pers, "attr": attr.serializable}),
        "priorsent": priorsent,
        "sentLatine": sentLatine,
        "recte": recte,
        "resp": resp,
        'prius': request.session['prius'],
        'consec': request.session['consec'],
    })
