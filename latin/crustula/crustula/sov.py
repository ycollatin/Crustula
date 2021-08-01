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
from crustula.models import *
import random

try:
    vocab = Sov.objects.get(name="sov")
    

    M = list(vocab.ov_set.filter(genre="m"))
    F = list(vocab.ov_set.filter(genre="f"))
    acc = [(o.accLatine, o) for o in vocab.ov_set.all()] # tous les accusatifs latins
    nom = [(o.nomLatine, o) for o in vocab.ov_set.all()] # tous les nominatifs latins

except:
    print("Warning: the database should contain data in the table crustula_ov, referenced by the name 'sov' in the table crustula_sov ... something went wrong!")
    pass

def accusatiuus_est(uer):
    """
    Vérifie si uer est un accusatif
    @return un Ov ayant uer pour accusatif, sinon None 
    """
    for latine, o in acc:
        if latine == uer:
            return o
    return

def nominatiuus_est(uer):
    """
    Vérifie si uer est un nominatif
    @return un Ov ayant uer pour nominatif, sinon None 
    """
    for latine, o in nom:
        if latine == uer:
            return o
    return

def f_gallice(s):
    ## in tabulam uertere sententiam :
    while s.endswith("."): s = s[:-1]
    coll = s.split(" ")
    for uer in coll:
        if uer == "amat":
            verbe = _("aime")
            continue
        a = accusatiuus_est(uer)
        if a:
            objet = a
            continue
        n = nominatiuus_est(uer)
        if n:
            sujet = n
    return f"{sujet.nomGallice} {verbe} {objet.accGallice}."

def alea_jacta_est():
    """
    décider du sexe du sujet
    @return une paire d'OV : un sujet et un objet de genre mf ou fm
    """
    sexus =('m','f')
    if (random.choice(sexus) == 'm'):
        return random.choice(M), random.choice(F)
    else:
        return random.choice(F), random.choice(M)

def IIPropositiones():
    """
    fabrique de façon aléatoire le groupe sujet, verbe objet
    @return une phrase, et deux propositions
    """
    subiectus, obiectus = alea_jacta_est()
    s1 = subiectus.nomGallice
    o1 = obiectus.accGallice
    s2 = obiectus.nomGallice
    o2 = subiectus.accGallice
    p = [
        f"{s1} {_('aime')} {o1}.",
        f"{s2} {_('aime')} {o2}.",
    ]
    random.shuffle(p)
    c = [subiectus.nomLatine, obiectus.accLatine, 'amat']
    random.shuffle(c)
    phrase = " ".join(c) + "."
    return phrase, p[0], p[1]


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
    compte_points(request, recte)
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

