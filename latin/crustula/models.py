from django.db import models
from django.contrib.auth.models import User
from django.utils import timezone

from .crustula.utils.i18n import *

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
        return f"{self.latine} : {self.galle}"

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

class Sov(models.Model):
    """
    classe utile pour chaque crutula de type "sov"
    """
    name = models.CharField(max_length=10)

    def __str__(self):
        return f"SOV: {self.name}"

class Ov(models.Model):
    """
    vocabulaire pour Sujet/Objet ; essentiellement des noms au nominatif
    et à l'accusatif
    """
    latine  = models.CharField(max_length=255)
    gallice = models.CharField(max_length=255)
    sovs = models.ManyToManyField(Sov)

    def __str__(self):
        return f"{self.latine} : {self.galle} ({self.sovs.all()})"

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
        if g[1]:
            # la traduction est déclinée à l'accusatif
            return g[1]
        # pas de déclinaison : on renvoie le nominatif
        return g[0]
