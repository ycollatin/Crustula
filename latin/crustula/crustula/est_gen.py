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
import random, json

from crustula.models import Gaffiot, Uerbum

def index(request):
    preferred_language(request)
    ### récupération des données du Gaffiot
    m = Gaffiot.objects.filter(comment="est-gen", genre="m")
    f = Gaffiot.objects.filter(comment="est-gen", genre="f")
    mares = []; feminae = []; mancipiaF = []; mancipiaM = []
    for o in m:
        if o.nompropre:
            mares.append(o)
        else:
            mancipiaM.append(o)
    for o in f:
        if o.nompropre:
            feminae.append(o)
        else:
            mancipiaF.append(o)
    quis = sorted (mares + feminae, key=lambda x: _(x.gallice))
    mancipia = sorted(mancipiaF + mancipiaM, key=lambda x: _(x.gallice))
    ### tirages au sort
    if random.choice(('m', 'f')) == 'f':
        qui = feminae
        manc = mancipiaF
    else:
        qui = mares
        manc = mancipiaM
    ### construction de sententia
    s = random.choice(qui)
    ## attention il faut éviter de choisir s à nouveau plus tard !
    att = random.choice(manc)
    g = random.choice(qui)
    while g == s:
        g = random.choice(qui) # ça évite le doublon
    est = Uerbum.objects.get(name="sum").latConiug(3, "s")
    coll = [s.latine, att.latine, est, g.genitif]
    random.shuffle(coll)
    sententia = " ".join(coll) + "."
    galPriorSent = latPriorsent = ""
    recte = False
    schema = request.POST.get("schema", "")
    if schema:
        sch = json.loads(schema)
        priorS = Gaffiot.fromserial(sch["s"])
        priorG = Gaffiot.fromserial(sch["g"])
        priorAtt = Gaffiot.fromserial(sch["att"])
        galPriorsent = _("{s} est {attr} de/d' {g}").format(
            s = _(priorS.gallice),
            g = _(priorG.gallice),
            attr = _(priorAtt.gallice),
        )
        respS = request.POST.get('respS','')
        respAttr = request.POST.get('respAttr','')
        respG = request.POST.get('respG','')
        r =  _("{s} est {attr} de/d' {g}").format(
            s = respS,
            g = respG,
            attr = respAttr,
        )
        recte = r == galPriorsent
        if recte:
            request.session["consec"] += 1
        else:
            if request.session['consec'] > request.session['prius']:
                request.session['prius'] = request.session['consec']
            request.session['consec']=0
    else: # schema est ""
        request.session["consec"] = 0
        request.session['prius']  = 0
    return render(request,'crustula/est-gen.html', context={
        "sententia": sententia,
        "est": est,
        "de": _("de/d'"),
        "quis": [_(q.gallice) for q in quis],
        "mancipiaFr": [_(o.gallice) for o in mancipia],
        "schema": json.dumps({
            "s": s.serializable,
            "g": g.serializable,
            "att": att.serializable,
        }),
        "galPriorsent": galPriorsent,
        "latPriorsent": request.POST.get("latPriorsent", ""),
        "gallice": _("Gallice"),
        "r": r,
        'prius': request.session['prius'],
        'consec': request.session['consec'],
        "recte": recte,
    })
