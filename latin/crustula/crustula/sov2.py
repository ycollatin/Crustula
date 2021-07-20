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
from crustula.models import *
import random, json

def vGal(uerbum):
    """ traduction du verbe """
    if uerbum == "amat":
        return _("aime")
    if uerbum == "spectat":
        return _("regarde")
    return "???"
    
class Phrase:
    """
    classe représentant une phrase.

    Paramètres du constructeur:
    @param aSubject sujet de type Ov
    @param aObject objet de type Ov
    @param aVerb un verbe (type str)
    """
    def __init__(self, aSubject, aObject, aVerb):
        self.subject = aSubject
        self.object = aObject
        self.verb = aVerb
        self._slat = [self.subject.nomLatine, self.object.accLatine, self.verb]
        random.shuffle(self._slat)
        return
    
    @property
    def schema(self):
        return json.dumps({
            "S": self.subject.serializable,
            "O": self.object.serializable,
            "V": self.verb})

    @staticmethod
    def fromSchema(sch):
        """
        Désérialise une phrase
        @param sch un "schéma" de phrase sérialisée
        """
        eclats = json.loads(sch)
        return Phrase(Ov.fromserial(eclats["S"]),
                      Ov.fromserial(eclats["O"]),
                      eclats["V"])

    def sLat(self):
        """
        @return latine sententia
        """
        return " ".join(self._slat) + "."

    def sGal(self):
        """
        @return gallice sententia
        """
        return " ".join((self.subject.nomGallice, vGal(self.verb), self.object.accGallice)) + "."


def index(request):
    preferred_language(request)
    prior_phrase_sLat = correct = resp = recte = ""
    vocab = Sov.objects.get(name="sov2")
    nomina = list(vocab.ov_set.all())
    # liste des mots par ordre alpha, dans la langue "gauloise"
    nomina = sorted(nomina, key = lambda n: n.nomGallice)
    nominM = [o for o in nomina if o.genre=="m"]
    nominF = [o for o in nomina if o.genre=="f"]
    nominEr = [o for o in nomina if o.genre=="m" and not o.nompropre]

    sexus = random.choice(("m", "f"))
    if sexus == "m":
        subiectus = random.choice(nominM)
        obiectus = random.choice(nominF)
    else:
        subiectus = random.choice(nominF)
        obiectus = random.choice(nominM)
    if subiectus.nompropre and obiectus.nompropre:
        uerbum = "amat"
    else:
        uerbum = "spectat"
    l = [subiectus.nomLatine, obiectus.accLatine, uerbum]
    random.shuffle(l)
    phrase = Phrase(subiectus, obiectus, uerbum)
    sententia = phrase.sLat()
    
    #################################
    schema = request.POST.get("schema", "")
    if schema:
        respS = request.POST.get('respS')
        respO = request.POST.get('respO')
        prior_phrase = Phrase.fromSchema(schema)
        resp = " ".join((respS, vGal(prior_phrase.verb), respO))
        correct = prior_phrase.sGal()
        prior_phrase_sLat = prior_phrase.sLat()
        recte = correct.lower().replace(".", "") == resp.lower().replace(".", "")
        ## include "session.php.html" !!!!!!!!!!!!
        if recte:
            request.session["consec"] += 1
        else:
            if request.session['consec'] > request.session['prius']:
                request.session['prius'] = request.session['consec']
            request.session['consec']=0
    else:
        request.session["consec"] = 0
        request.session['prius']  = 0        
        
    return render(request,'crustula/sov2.html', context={
        "schema": phrase.schema,
        "sententia": sententia,
        "prior_sententia": prior_phrase_sLat,
        "gallice": phrase.sGal(),
        "nomina": nomina,
        "verbe": vGal(phrase.verb),
        "correct": correct,
        "resp": resp,
        "consec": request.session["consec"],
        "prius": request.session["prius"],
        "recte": recte,
    })
