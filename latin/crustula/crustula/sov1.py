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
import json

def decl(nomen, k):
    """
    décline un nom
    @param nomem une liste telle que ['pat-er-rem', 'm', _('mon père')]
    @param k un cas tel que "n" ou "a"
    @return le nom décliné : "pater" ou "patrem"
    """
    eclats = nomen[0].split("-");
    radical = eclats[0]
    if (k == 'n'):
        return radical + eclats[1]
    return radical + eclats[2]

def upper_first(s):
    return s[0].upper()+s[1:]

class Phrase:
    def __init__(self, person, number, aSubject, aObject):
        self.person = person
        self.number= number
        self.subject = aSubject
        self.object = aObject
        return
    
    @property
    def schema(self):
        return json.dumps({"p": self.person, "n": self.number, "S": self.subject, "O": self.object})

    def conj(self, uerbum):
        """
        conjugaison latine
        @param uerbum un verbe sous la forme 'dilig-o-is-it-imus-itis-unt'
        """
        eclats = uerbum.split("-")
        radical = eclats[0]
        if self.number == 's':
            return radical + eclats[self.person]
        return radical + eclats[self.person+3]

    def conjG(self, verbe):
        """
        Conjugaison dans la langue non-latine
        @param verbe Gaulois à conjuguer comme ["j'aime",'tu aimes','aime',...]
        """
        if (self.number == 's'):
            return verbe[self.person-1]
        return verbe[self.person + 2]

    def sLat(self, uerbum, nomina):
        """
        Latina sententia
        @param uerbum un verbe comme 'dilig-o-is-it-imus-itis-unt'
        @param un tableau de noms
        """
        ## uerbum 
        fVerbum = self.conj(uerbum)
        ## subiectum
        if self.person == 3 and self.number == 's':
            sub = decl(self.subject, 'n') # nominative
        else:
            sub = ''
        ## obiectum
        obj = decl(self.object, 'ac') # accusative
        ## ordinem
        tabula = [sub, obj, fVerbum]
        random.shuffle(tabula);
        ## finis
        return ' '.join(tabula) + '.'

    def sGal(self, verbe, nomina):
        """
        Gallica sententia
        @param verbe un verbe Gaulois comme ["j'aime",'tu aimes','aime',...]
        @param nomina liste de noms
        @return : une phrase
        """
        ## uerbum sortitur
        ## verbe
        formeV = self.conjG(verbe)
        sujet = ""
        ## sujet
        if self.number == 's' and self.person == 3:
            sujet = self.subject[2]
            if "/" in sujet: # il faut choisir entre nominatif et accusatif
                sujet = sujet.split("/")[0] 
        ## objet 
        objet = self.object[2];
        if "/" in objet: # il faut choisir entre nominatif et accusatif
                objet = objet.split("/")[1] 
        ## retour
        return upper_first("{} {} {}".format(sujet, formeV, objet))

    @staticmethod
    def fromSchema(sch):
        """
        Désérialise une phrase
        @param sch un "schéma" de phrase sérialisée
        """
        eclats = json.loads(sch)
        return Phrase(eclats["p"],
                      eclats["n"],
                      eclats["S"],
                      eclats["O"])

class RandomPhrase(Phrase):
    def __init__(self, nomina):
        person = random.choice((1, 2, 3, 3, 3, 3, 3))
        if person != 3:
            number = random.choice(('s', 'p'))
        else:
            number = random.choice(('s','s','s','s','s','s','p'))
        aSubject = ""
        if person == 3 and number == 's':
            aSubject = random.choice(nomina)
        aObject = random.choice(nomina)
        while aObject == aSubject:
            aObject = random.choice(nomina)
        Phrase.__init__(self, person,number, aSubject, aObject)
        return


def index(request):
    preferred_language(request)
    nomina = [
        # Translators: for declensions, translate to: nominative/accusative
        ['pat-er-rem', 'm', _('mon père')],     # 0
        # Translators: for declensions, translate to: nominative/accusative
        ['mat-er-rem', 'f', _('ma mère')],      # 1
        # Translators: for declensions, translate to: nominative/accusative
        ['frat-er-rem', 'm', _('mon frère')],   # 2
        # Translators: for declensions, translate to: nominative/accusative
        ['sor-or-orem', 'm', _('ma soeur')],    # 3
        # Translators: for declensions, translate to: nominative/accusative
        ['filiu-s-m', 'n', _('mon fils')],      # 4
        # Translators: for declensions, translate to: nominative/accusative
        ['fili-a-am', 'f', _('ma fille')],      # 5
        # Translators: for declensions, translate to: nominative/accusative
        ['ux-or-orem',  'f', _('ma femme')],    # 6
    ]
    uerbum = 'dilig-o-is-it-imus-itis-unt'
    verbe = [_("j'aime"),_('tu aimes'),_('aime'),
             _('nous aimons'), _('vous aimez'),_('ils aiment')]
    sol = ""
    recte = False
    meta = random.choice(('latine','gallice'));
    phrase = RandomPhrase(nomina); 
    if meta == 'latine':
        sententia = phrase.sGal(verbe, nomina)
    else:
        sententia = phrase.sLat(uerbum, nomina)
    #################################
    schema = request.POST.get("schema", "")
    if schema:
        resp = request.POST.get('resp').strip()
        ## solutionem ab sententia
        priorAbs = Phrase.fromSchema(schema)
        pMeta = request.POST.get('meta')
        if pMeta == 'latine':
            ## alphabeticum ordinem ut comparatio pertinens fiat.
            sol = priorAbs.sLat(uerbum, nomina);
            solC = sol.replace(".", "")
            tabS = solC.split(" ")
            tabS.sort(key=lambda x: x.lower()) ## ordre insensible à la casse
            solC = ' '.join(tabS)

            respC = resp.replace(".", "")
            tabR = re.split(r"[\s]+", respC)
            tabR.sort(key=lambda x: x.lower()) ## ordre insensible à la casse
            respC = ' '.join(tabR)
        else:
            sol = priorAbs.sGal(verbe, nomina);
            solC = sol.replace(".", "")
            respC = resp.replace(".", "")
            ## éliminer les espace surnuméraires;
            respC = re.sub(r"[\s]+", " ", respC)
        solC = solC.strip()
        respC = respC.strip()
        recte = solC.lower() == respC.lower()
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
    return render(request,'crustula/sov1.html', context={
        "schema": schema,
        "sol": sol,
        "recte": recte,
        "sententia": sententia,
        "meta": meta,
        "phrase_schema": phrase.schema,
        "help1": _("Tous les déterminants sont des déterminants possessifs !"),
        "help2": _("pour « aimer », utilise le verbe"),
        "consec": request.session["consec"],
        "prius": request.session["prius"],
    })
