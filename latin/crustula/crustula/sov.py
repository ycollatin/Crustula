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
import random

nominM = [
    N_("Aemilius"),
    N_("Eupalamus"),
    N_("Publius"),
    N_("Aulus"),
    N_("Marcus")]

nominF = [
    N_("Aemilia"),
    N_("Iulia"),
    N_("Lucia"),
    N_("Lucretia"),
    N_("Sempronia")]

accusM = [
   N_("Aemilium"),
   N_("Eupalamum"),
   N_("Publium"),
   N_("Aulum"),
   N_("Marcum")]

accusF = [
    N_("Aemiliam"),
    N_("Iuliam"),
    N_("Luciam"),
    N_("Lucretiam"),
    N_("Semproniam")]

declinatio = N_("si non declinatione neque sermonem transferre");
def declinatio_est():
    return _(declinatio) != declinatio

nomina = nominF + nominM
accus = accusF + accusM

nominADaccus = []
accusADnomin = []

def accusatiuus_est(n):
    return n in accus

nominADaccus = {n: accus[i] for i, n in enumerate(nomina)}            
accusADnomin = {a: nomina[i] for i, a in enumerate(accus)}

def f_gallice(s):
    ## in tabulam uertere sententiam :
    while s.endswith("."): s = s[:-1]
    coll = s.split(" ")
    for uer in coll:
        if uer == "amat":
            verbe = _("aime")
        elif accusatiuus_est(uer):
            objet = uer
        else:
            sujet = uer
    if declinatio_est():
        sujet = _(sujet)
        objet = _(objet)
    else:
        objet = accusADnomin[objet]
    return f"{sujet} {verbe} {objet}."

def alea_jacta_est():
    ## décider du sexe du sujet
    sexus =('m','f')
    if (random.choice(sexus) == 'm'):
        subiectus = random.choice(nominM)
        lemma_obiecti = random.choice(nominF)
    else:
        subiectus = random.choice(nominF)
        lemma_obiecti = random.choice(nominM)

    obiectus = nominADaccus[lemma_obiecti]
    return subiectus, obiectus, lemma_obiecti

def IIPropositiones():
    """
    fabrique de façon aléatoire le groupe sujet, verbe objet
    @return une phrase, et deux propositions
    """
    subiectus, obiectus, lemma_obiecti = alea_jacta_est()
    if declinatio_est():
        s1 = _(subiectus)
        o1 = _(obiectus)
        s2 = _(accusADnomin[obiectus])
        o2 = _(nominADaccus[subiectus])
    else:
        s1 = subiectus
        o1 = lemma_obiecti
        s2 = lemma_obiecti
        o2 = subiectus
    p = [
        f"{s1} {_('aime')} {o1}.",
        f"{s2} {_('aime')} {o2}.",
    ]
    random.shuffle(p)
    c = [subiectus, obiectus, 'amat']
    random.shuffle(c)
    return " ".join(c) + ".", p[0], p[1]


def index(request):
    preferred_language(request)
    priorsent = request.POST.get("sententia","")
    gallice = ""
    resp=""
    recte = False
    prius = request.session.get("prius", 0)
    request.session["prius"] = prius
    consec = request.session.get("consec", 0)
    request.session["consec"] = consec
    if priorsent:
        gallice = f_gallice(priorsent)
        resp = request.POST.get("resp","")
        recte = resp == gallice
        if recte:
            request.session["consec"] += 1
        else:
            if request.session['consec'] > request.session['prius']:
                request.session['prius'] = request.session['consec']
            request.session['consec']=0
    else: ## priorsent == False
        request.session["consec"] = 0
        request.session['prius']  = 0
                
    sententia, r1, r2 = IIPropositiones()
    return render(request,'crustula/sov.html', context={
        "priorsent": priorsent,
        "gallice": gallice,
        "lingue": _("gallice"),
        'prius': request.session['prius'],
        'consec': request.session['consec'],
        "resp": resp,
        "question": sententia,
        "recte": recte,
        "r1": r1,
        "r2": r2,
    })

