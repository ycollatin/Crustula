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

"""
Cet utilitaire facilite une bonne intégration des variables de session
"prius" et "consec"
"""

def compte_points(request, recte):
    if request.method == "GET":
        request.session["consec"] = 0
        request.session['prius']  = 0
    else:
        if recte:
            request.session["consec"] += 1
        else:
            # mémorise la meilleure valeur de "consec" dans "prius"
            if request.session['consec'] > request.session['prius']:
                request.session['prius'] = request.session['consec']
            # remet à zéro "consec"
            request.session['consec']=0
    return

         
