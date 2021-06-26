from django.contrib import admin
from .models import Student, Worksheet, Exercise, WorksheetContent, Score,\
    LogRecord

admin.site.register(Student)
admin.site.register(Worksheet)
admin.site.register(Exercise)
admin.site.register(WorksheetContent)
admin.site.register(Score)
admin.site.register(LogRecord)
