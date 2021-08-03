from django.db import models
from django.contrib.auth.models import User
from django.utils import timezone

from .crustula.utils.i18n import *

import re

class Student(models.Model):
    user = models.OneToOneField(User, on_delete=models.CASCADE)
    classe = models.CharField(max_length=20)

class Worksheet(models.Model):
    title = models.CharField(max_length=140)
    summary = models.TextField(blank=True)

    def __str__(self):
        return self.title


class Exercise(models.Model):
    title = models.CharField(max_length=140)
    summary = models.TextField(blank=True)
    url = models.CharField(max_length=20)
    
    def __str__(self):
        return self.title

class WorksheetContent(models.Model):
    ws = models.ForeignKey('Worksheet', on_delete=models.PROTECT)
    ex = models.ForeignKey('Exercise', on_delete=models.PROTECT)

    def __str__(self):
        return f"{self.ws.title} => {self.ex.title}"
    
class Score(models.Model):
    val = models.FloatField()
    exercise = models.ForeignKey('Exercise', on_delete=models.PROTECT)

    def __str__(self):
        return f"{self.exercise.title} => {self.val}"

class LogRecord(models.Model):
    timestamp = models.DateTimeField(default=timezone.now)
    record = models.CharField(max_length=255)

    def __str__(self):
        return f"[{self.timestamp}]: self.record"
    
class Gaffiot(models.Model):
    """
    traductions latin-français
    """
    comment = models.CharField(max_length=20)
    latine  = models.CharField(max_length=255)
    gallice = models.CharField(max_length=255)  
    genitif = models.CharField(max_length=255, default="")
    genre = models.CharField(max_length=255, default="m")
    def __str__(self):
        return f"{self.latine} : {self.gallice}"

    @staticmethod
    def traduction(comment, gettext):
        """
        produit une liste d'objets [{"latine": ..., "gallice": ...}, ...]
        dont les items "gallice" sont traduits avec la fonction gettext
        """
        return [
            {"latine": gaf.latine, "gallice": gettext(gaf.gallice),
             "genitif": gaf.genitif, "genre": gaf.genre} for
            gaf in Gaffiot.objects.filter(comment=comment)
        ]

    @property
    def nompropre(self):
        """
        Signale les noms propres (qui commencent par une capitale)
        """
        nom = self.latine.split("/")[0]
        return nom == nom[0].upper() + nom[1:].lower()

    @property
    def serializable(self):
        return {
            "comment": self.comment,
            "latine": self.latine,
            "gallice": self.gallice,
            "genitif": self.genitif,
            "genre" : self.genre,
        }

    @staticmethod
    def fromserial(dic):
        return Gaffiot(comment=dic["comment"], latine=dic["latine"], gallice=dic["gallice"], genitif=dic["genitif"], genre=dic["genre"])

class Sov(models.Model):
    """
    classe utile pour chaque crutula de type "sov"
    """
    name = models.CharField(max_length=10, unique = True)

    def __str__(self):
        return self.name

class Ov(models.Model):
    """
    vocabulaire pour Sujet/Objet ; essentiellement des noms au nominatif
    et à l'accusatif
    """
    latine  = models.CharField(max_length=255, unique = True)
    gallice = models.CharField(max_length=255, default="<nominatif>/")
    genre   = models.CharField(max_length=1, default="m")
    sovs = models.ManyToManyField(Sov)

    def __str__(self):
        return f"{self.latine} : {self.gallice} ({self.genre}, {self.sovs.all()})"
    @property
    def imprecis(self):
        """
        signale si un mot ne désigne Pas une personne précise ; en français
        ça se traduit généralement par le fait que la traduction française
        tient en deux mots, un article et un nom
        """
        return " " in self.gallice

    @property
    def nompropre(self):
        """
        Signale les noms propres (qui commencent par une capitale)
        """
        nom = self.latine.split("/")[0]
        return nom == nom[0].upper() + nom[1:].lower()
    
    @property
    def serializable(self):
        return {
            "lat": self.latine,
            "gal": self.gallice,
            "gen" : self.genre,
        }

    @staticmethod
    def fromserial(dic):
        return Ov(latine=dic["lat"], gallice=dic["gal"], genre=dic["gen"])

    @property
    def nomLatine(self):
        """
        @return le nominatif, en latin
        """
        return self.latine.split("/")[0]

    @property
    def accLatine(self):
        """
        @return l'accusatif, en latin
        """
        return self.latine.split("/")[1]

    @property
    def nomGallice(self):
        """
        @return le nominatif, en "gaulois"
        """
        return _(self.gallice).split("/")[0]

    @property
    def accGallice(self):
        """
        @return l'accusatif, en "gaulois"
        """
        g = _(self.gallice).split("/")
        if len(g) > 0:
            if g[1]:
                # la traduction est déclinée à l'accusatif
                return g[1]
        # pas de déclinaison : on renvoie le nominatif
        return g[0]

class Uerbum(models.Model):
    """
    Une classe pour les verbes
    - name est la forme du verbe au présent de l'indicatif, première p. du s.
    - latine peut être quelque chose comme :
      sum/es/est/sumus/estis/sunt
      ou :
      constituo, is, ere, tui, tutum
    - gallice peut être quelque chose comme :
      suis/es/est/sommes/êtes/sont
      ou :
      organiser, organisé
    """

    name    = models.CharField(max_length=25, unique = True)
    latine  = models.CharField(max_length=255)
    gallice = models.CharField(max_length=255, default="")
    
    def __str__(self):
        return self.latine + " => " + _(self.gallice)

    def latConiug(self, pers = 0, nomb = "s", mode = "indic", temps = "pres"):
        """
        Conjugaison latine, sur la base de self.latine
        - self.latine peut être quelque chose comme :
          sum/es/est/sumus/estis/sunt
          ou :
          constituo, is, ere, tui, tutum
        @param pers la personne, 1, 2 ou 3 (0 par défaut)
        @param nomb le nombre, "s" ou "p" ("s" par défaut)
        @param mode le mode, indicatif par défaut ; valeurs possibles :
          "indic", "infin", "partic", ...
        @param temps le temps, présent par défaut ; valeurs possibles :
          "pres", ...
        """
        eclats = re.split(r", *", self.latine)
        # toujours là, le présent de l'indicatif
        pres_indic1 = eclats[0]
        # les autres sont là, éventuellement
        if len(eclats) > 1: pres_indic20 = eclats[1] # termin. 2ème pers.
        if len(eclats) > 2: infin0 = eclats[2]       # termin. inifinitif
        if len(eclats) > 3: parf0 = eclats[3]        # termin. parfait
        if len(eclats) > 4: part0 = eclats[4]        # participe, (in)complet
        #########################################
        if mode == "indic":
            if temps == "pres":
                formes = pres_indic1.split("/")
                if len(formes) == 6:
                    if nomb == "s":
                        index = pers-1
                    else:
                        index = pers+2
                    return self.latine.split("/")[index]
        return
    
    def galConiug(self, pers = 0, nomb = "s", mode = "indic", temps = "pres"):
        """
        Conjugaison "gauloise", sur la base de _(self.gallice)
        - gallice peut être quelque chose comme :
          suis/es/est/sommes/êtes/sont
          ou :
          organiser, organisé
        @param pers la personne, 1, 2 ou 3 (0 par défaut)
        @param nomb le nombre, "s" ou "p" ("s" par défaut)
        @param mode le mode, indicatif par défaut ; valeurs possibles :
          "indic", "infin", "partic", ...
        @param temps le temps, présent par défaut ; valeurs possibles :
          "pres", ...
        """
        eclats = re.split(r", *", _(self.gallice))
        # eclats peut être [_("suis/es/est/sommes/êtes/sont")]
        # ou :
        # [_("organiser"), _("organisé")]
        ###########################################
        # l'index 0 est toujours là, c'est un présent (6 formes) ou un infinitif
        if "/" in eclats[0]:
            formes = eclats[0].split("/")
            if mode == "indic":
                if temps == "pres":
                    if nomb == "s":
                        index = pers-1
                    else:
                        index = pers+2
                    return formes[index]
        else: # pas de / dans le premier éclat
            if mode == "infin":
                return eclats[0]
            elif mode == "partic":
                return eclats[1]
        return

class Sum(models.Model):
    """
    Une classe pour des sujets et des attributs ; facilite la manipulation
    de nominatifs, au singulier, au pluriel
    """
    latine  = models.CharField(max_length=255, unique = True)
    gallice = models.CharField(max_length=255, default="<singulier>/<pluriel>")
    genus   = models.CharField(max_length=25, default="homines")
    genre   = models.CharField(max_length=1, default="m")
    
    @property
    def serializable(self):
        return {
            "latine": self.latine,
            "gallice": self.gallice,
            "genus" : self.genus,
            "genre" : self.genre,
        }

    @staticmethod
    def fromserial(dic):
        return Sum(latine=dic["latine"], gallice=dic["gallice"], genre=dic["genre"], genus=dic["genus"])
    
    def __str__(self):
        return self.latine + " => " + _(self.gallice)


    def latNom(self, nomb):
        if nomb == "s":
            index = 0
        else:
            index = 1
        return self.latine.split("/")[index]

    def galNom(self, nomb):
        if nomb == "s":
            index = 0
        else:
            index = 1
        return _(self.gallice).split("/")[index]
