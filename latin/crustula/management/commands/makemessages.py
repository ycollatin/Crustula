from django.core.management.commands import makemessages
from django.core.management.utils import (
    find_command, handle_extensions, popen_wrapper,
)
from crustula.models import Gaffiot
import os,re

class Command(makemessages.Command):
    xgettext_options = makemessages.Command.xgettext_options + ['--keyword=N_']
    
    ## on récupère aussi les entrées du Gaffiot
    
    def build_potfiles(self):
        """
        Build pot files and apply msguniq to them.
        """
        unefois = False ## je en sais pas pourquoi le gaffiot est ajouté 2 fois
        file_list = self.find_files(".")
        self.remove_potfiles()
        self.process_files(file_list)
        # POT-Creation-Date
        pcd = re.compile(r'"POT-Creation-Date:.*"')
        fixed_date = 'POT-Creation-Date: 2021-07-02 16:56+0000'
        potfiles = []
        for path in self.locale_paths:
            potfile = os.path.join(path, '%s.pot' % self.domain)
            if not os.path.exists(potfile):
                continue
            args = ['msguniq'] + self.msguniq_options + [potfile]
            msgs, errors, status = popen_wrapper(args)
            if errors:
                if status != STATUS_OK:
                    raise CommandError(
                        "errors happened while running msguniq\n%s" % errors)
                elif self.verbosity > 0:
                    self.stdout.write(errors)
            msgs = makemessages.normalize_eols(msgs)
            msgs = pcd.sub('"'+fixed_date+'\\\\n"', msgs)
            with open(potfile, 'w', encoding='utf-8') as fp:
                fp.write(msgs)
            ### ici on ajoute des lignes dans le fichier potfile !!!!
            if not unefois:
                unefois = True
                with open(potfile, "a") as outfile:
                    comments = set ([ g.comment for g in Gaffiot.objects.all()])
                    comments = list(comments)
                    comments.sort()
                    i = 1
                    for c in comments:
                        for g in Gaffiot.objects.filter(comment=c):
                            outfile.write(f"\n#: Gaffiot/{c}/{g.latine}/:{i}\n")
                            i+=1
                            protected = str(g.gallice).replace('"','\\"')
                            outfile.write(f'''msgid "{protected}"\nmsgstr ""\n''')
            potfiles.append(potfile)
        return potfiles
        
