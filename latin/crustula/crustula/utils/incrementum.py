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

########################## module INCREMENTVM  ################################
##
##   Ce module a pour but de gérer le questionnement sur une liste
##   de paires question-réponse.
##   Il utilise un tableau d'entiers longs pour transmettre de page
##   en page l'état des items acquis et non acquis. un autre tableau
##   garde quant à lui la liste des échecs récents.
##
##   En cas d'échec sur une question, le bit représentant la question
##   est désarmé, et considéré comme devant être demandé en priorité.
##
##   Si la liste est entièrement sue, une nouvelle question est ajoutée.
########################################################################
import random, itertools
from .i18n import *
from crustula.models import Gaffiot

maximum = 2147483647;

class Lexicum:
    """
    Une classe pour travailler avec un lexique.

    Paramètres du constructeur:
    @param mot_cle une catégorie dans la table Gaffiot, de la BDD
    @param cognita une chaîne de zéros et de uns qui permet de reconstruire
      self.cognita et self.visible
    Les propriétés :
     - self. bini sont est liste d'objets {"latine": <str>, "gallice": <str>}
       formant un vocabulaire (forme latine, forme traduite)
     - self.cognita est une liste de booléens qui marquent si un élément de
       vocabulaire est connu
     - self.visible est le nombre d'éléments de vocabulaire que l'on 
       peut presenter jusque là; valeur par défaut : "0"
    """
    def __init__(self, mot_cle, cognita = "0"):
        self.bini = Gaffiot.traduction(comment = mot_cle, gettext = _)
        self.cognita=[]
        for i in range(len(self.bini)):
            if i < len(cognita) and cognita[i] == "1":
                self.cognita.append(True)
            else:
                self.cognita.append(False)
        self.visible  = len(cognita)
        return

    @property
    def listeN(self):
        """
        @return la liste des mots de vocabulaire non connus, parmi les
          mots déjà présentés
        """
        return [val
                for cognitus, val in zip(self.cognita,self.bini[:self.visible])
                if not cognitus]

    @property
    def listeC(self):
        """
        @return la liste des mots de vocabulaire connus
        """
        iter = itertools.compress(self.bini, self.cognita)
        return list(iter)

    @property
    def cognita_bin(self):
        """
        @return une représentation binaire sous forme de chaîne de longueur
        self.visible, composée de 0 et de 1 selon self.cognita
        """
        bins = ["1" if cognitus else "0"
                for cognitus in self.cognita[:self.visible]
                ]
        return "".join(bins)
    
    def Qincr(self):
        """
        @return un élément de vocabulaire, parmi les éléments connus ou pas
           s'il existe des éléments inconnus, avec 3 chances sur 8 qu'il
           soit inconnu
        """
        liste = listeC = self.listeC
        listeN = self.listeN
        if listeN and (not listeC or random.randint(0,7) >= 3):
            liste = listeN
        return random.choice(liste)

    def perfectum(self):
        """
        @return vrai si tout est connu !
        """
        # on exécute un AND de tous les éléments de self.cognita, dans
        # la limite des self.visible premiers.
        return list(itertools.accumulate(self.cognita[:self.visible],
                                         func = lambda x,y: x and y))[-1]

    def index(self, gal):
        """
        @return l'index d'un mot de vocabulaire, d'après sa valeur "locale"
        """
        return [i for i, voc in enumerate(self.bini) if voc["gallice"] == gal][0]
    
    def index2(self, lat):
        """
        @return l'index d'un mot de vocabulaire, d'après sa valeur "latine"
        """
        return [i for i, voc in enumerate(self.bini) if voc["latine"] == lat][0]
    
    def ultima(self, gal):
        """
        @return vrai si gal est le dernier item à avoir été présenté
        """
        return self.index(gal) == self.visible -1

    def ultima2(self, lat):
        """
        @return vrai si lat est le dernier item à avoir été présenté
        """
        return self.index2(lat) == self.visible -1

    def succes (self, gal):
        """
       armer le gal enclavé.
       s'il n'y a plus d'enclave, 
          et si la question posée était nouvelle,
             ajouter un item dans le questionnement
        @param lex nom d'un "commentaire" de la table Gaffiot de la BDD
        """
        self.cognita[self.index(gal)] = True
        if self.perfectum() and self.ultima(gal) and \
           self.bilan < len(self.bini):
            self.visible += 1
        return
        
    def succes2 (self, lat):
        """
       armer le lat enclavé.
       s'il n'y a plus d'enclave, 
          et si la question posée était nouvelle,
             ajouter un item dans le questionnement
        @param lex nom d'un "commentaire" de la table Gaffiot de la BDD
        """
        self.cognita[self.index2(lat)] = True
        if self.perfectum() and self.ultima2(lat) and \
           self.bilan < len(self.bini):
            self.visible += 1
        return
        
    def echec(self, gal):
        """
        déclare l'échec de gal, donc crée l'enclave correspondante
        @param gal un  mot dans la locale courante
        """
        self.cognita[self.index(gal)] = False
        return

    def echec2(self, lat):
        """
        déclare l'échec de lat, donc crée l'enclave correspondante
        @param gal un  mot dans la locale courante
        """
        self.cognita[self.index2(lat)] = False
        return

    @property
    def bilan(self):
        return sum([1 if x else 0 for x in self.cognita])

    def solutio(self, gal):
        for data in self.bini:
            if data["gallice"] == gal:
                return data["latine"]
        return ""

    def correct(self, r, gal):
        r = r.strip().lower()
        s = self.solutio2(gal)
        return s, r==s
    
    def solutio2(self, lat):
        """
        renvoie une solution : génitif
        """
        for data in self.bini:
            if data["latine"] == lat:
                return data["genitif"]
        return ""

    def correct2(self, r, gal):
        r = ",".join([i.lower().strip() for i in r.split(",")])
        s = self.solutio2(gal)
        return s, r==s
    
    def facQgenit(self, nominatiuum):
        i = self.index2(nominatiuum)
        g = self.bini[i]["gallice"]
        if g:
            translation = _(g) 
            return f"{nominatiuum} ({translation}): genitiuum ?"
        return f"{nominatiuum} : genitiuum ?"

def facQ(gallice):
    return f"Quomodo latine dicitur : {gallice} ?"

