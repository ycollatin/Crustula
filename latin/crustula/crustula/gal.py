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
import re

def index(request):
    respF = solF = respK = solK = attribut = motprec = mot = ""
    recte=False
    preferred_language(request)
    vocab = Sov.objects.get(name="gal")
    nomina = list(vocab.ov_set.all()) 
    fonctions = [
        _("sujet du verbe"),
        _("COD du verbe"),
        _("attribut du sujet")
    ]

    cas = [
        _("au nominatif"),
        _("à l'accusatif")
    ]

    phprec = request.POST.get("phprec","")
    if phprec:
        motprec = request.POST.get("motprec","")
        respF = request.POST.get("respF","") # stripslashes?
        respK = request.POST.get("respK","") # stripslashes?
        ## solution
        eclats = phprec.split(" ")
        if motprec == eclats[0]:
            solF = fonctions[0]
            solK = cas[0]
        elif eclats[1] == _('est'):
            solF = fonctions[2]
            solK = cas[0]
        else:
            solF = fonctions[1]
            solK = cas[1]
        prius = request.session.get("prius", 0)
        request.session["prius"] = prius
        consec = request.session.get("consec", 0)
        request.session["consec"] = consec
        recte = (respF == solF) and (respK == solK)
        if recte:
            request.session["consec"] += 1
        else:
            if request.session['consec'] > request.session['prius']:
                request.session['prius'] = request.session['consec']
            request.session['consec']=0
    else:
        request.session['prius'] = 0
        request.session['consec'] = 0

    ## décider du sexe du sujet
    sexus = random.choice(('m', 'f'))
    nominM = [o for o in nomina if o.genre=="m" and not o.imprecis]
    nominF = [o for o in nomina if o.genre=="f" and not o.imprecis]
    nominAttF = [o for o in nomina if o.genre =="f" and o.imprecis]
    nominAttM = [o for o in nomina if o.genre =="m" and o.imprecis]
    if (sexus == 'm'):
        sujet = random.choice(nominM)
    else:
        sujet = random.choice(nominF)

    ## tirer le type de phrase
    thetype = random.choice(('svo','sva'))
    if (thetype == 'svo'):
        if sexus == "f":
            objet = random.choice(nominAttM)
        else:
            objet = random.choice(nominAttM)
        phrase = re.sub(
            r"\(.*\)", "",
            f"{sujet.nomGallice} {_('aime')} {objet.accGallice}")
        if random.random() > 1/3:
            mot = objet.accGallice
        else:
            mot = sujet.nomGallice
    else:
        if sexus == 'f':
            attribut = random.choice(nominAttF)
        else:
            attribut = random.choice(nominAttM)
        phrase = re.sub(
            r"\(.*\)", "",
            f"{sujet.nomGallice} {_('est')} {attribut.nomGallice}")
        if random.random() > 1/3:
            mot = attribut.nomGallice
        else:
            mot = sujet.nomGallice
    # la phrase es choisie
    phrase_precedente = _('Phrase précédente : {phprec}').format(phprec=phprec),
    mot_prec = _("{motprec} est {solF} ; il serait en latin au {solK}").format(
        motprec=motprec, solF=solF, solK=solK)
    return render(request,'crustula/gal.html', context={
        "phrase": phrase.replace("_", " "),
        "mot_est": f"{mot} {_('est')}",
        "phrase_precedente": phrase_precedente,
        "phprec": phprec,
        "mot_prec": mot_prec,
        "mot": mot,
        "juste": _("JUSTE !"),
        "faux_reponse": _("Faux. Tu as répondu"),
        "respF": respF,
        "respK": respK,
        'prius': request.session['prius'],
        'consec': request.session['consec'],
        "recte": recte,
        "fonctions": fonctions,
        "cas": cas,
        "en_latin": _("En latin, ce mot serait donc"),

    })
