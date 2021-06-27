from django.db import models
from django.contrib.auth.models import User
from django.utils import timezone

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
    