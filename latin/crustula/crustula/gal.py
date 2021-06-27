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
import re

fonctions = [
    N_("sujet du verbe"),
    N_("COD du verbe"),
    N_("attribut du sujet")
]

cas = [
    N_("au nominatif"),
    N_("à l'accusatif")
]

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

nominMaccus = [
    N_("Aemilius(objet)"),
    N_("Eupalamus(objet)"),
    N_("Publius(objet)"),
    N_("Aulus(objet)"),
    N_("Marcus(objet)")]

nominFaccus = [
    N_("Aemilia(objet)"),
    N_("Iulia(objet)"),
    N_("Lucia(objet)"),
    N_("Lucretia(objet)"),
    N_("Sempronia(objet)")]

attFnomin = [
   N_("mon_amie(attribut)"),
   N_("ma_sœur(attribut)"),
   N_("une_voisine(attribut)"),
   N_("sa_fille(attribut)"),
   N_("une_inconnue(attribut)")
]

attFaccus = [
   N_("mon_amie(objet)"),
   N_("ma_sœur(objet)"),
   N_("une_voisine(objet)"),
   N_("sa_fille(objet)"),
   N_("une_inconnue(objet)")
]

attMnomin = [
   N_("son_ami(attribut)"),
   N_("mon_frère(attribut)"),
   N_("un_Gaulois(attribut)"),
   N_("le_consul(attribut)"),
   N_("un_marin(attribut)")
]

attMaccus = [
   N_("son_ami(objet)"),
   N_("mon_frère(objet)"),
   N_("un_Gaulois(objet)"),
   N_("le_consul(objet)"),
   N_("un_marin(objet)")
]


nomina = nominF + nominM


def index(request):
    respF = solF = respK = solK = attribut = motprec = mot = ""
    recte=False
    preferred_language(request)
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
    if (sexus == 'm'):
        sujet = random.choice(nominM)
    else:
        sujet = random.choice(nominF)

    ## tirer le type de phrase
    thetype = random.choice(('svo','sva'))
    if (thetype == 'svo'):
        if sexus == 'f':
            objet = random.choice(nominMaccus + attMaccus)
        else:
            objet = random.choice(nominFaccus + attFaccus)
        phrase = re.sub(
            r"\(.*\)", "",
            f"{_(sujet)} {_('aime')} {_(objet)}")
    else:
        if sexus == 'f':
            attribut = random.choice(attFnomin)
        else:
            attribut = random.choice(attMnomin)
        phrase = re.sub(
            r"\(.*\)", "",
            f"{_(sujet)} {_('est')} {_(attribut)}")
    # la phrase es choisie
    eclats = phrase.split(" ")
    mot = eclats[random.choice((0,2,2))]
    mot = mot.replace("_", " ")
    phrase_precedente = f"{_('Phrase précédente :')} {phprec}"
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
