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

