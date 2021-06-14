<?php
/*
							sequentem.php

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

	Sequentem affiche progressivement la phrase, dont la traduction est
	d'emblée affichée,
	1) mot après mot 
	  et demande à l'élève de saisir
	   - niveau 1 : la dernière lettre ;
	   - niveau 2 : les deux dernières lettres ;
	2) lettre après lettre,
	  et demande à l'élève la lettre suivante ;

	3) et 4) : idem, sans la traduction.
	

*/
$alin = "<br>\n";
$exempla = array(

	array ("Deianira Euhenum flumen transire cupiebat.","Déjanire voulait traverser le fleuve Euhenus."),
	array ("Nessus Centaurus in tergo Deianiram cepit.","Le centaure Nessus prit Déjanire sur son dos."),
	array ("Sed in medio flumine eam uiolare uoluit.","Mais au milieu du fleuve il voulut la violer."),
	array ("Hercules interuenit.","Hercule survint."),
	array ("Deianira Herculis fidem implorauit.","Déjanire implora la fidélité d'Hercule."),
	array ("Ille Nessum sagittis confixit.","Il transperça Nessus de ses flèches."),
	array ("Nessus sciebat sagittas Hydrae felle tinctas uim ueneni habere.","Nessus savait que les flèches teintes du fiel de l'Hydre avaient la force d'un poison."),
	array ("Sanguinem suum excepit et Deianirae dedit.","Il recueillit de son sang et le donna à Déjanire."),
	array ("Ei dixit","Il lui dit"),
	array ("Philtrum est.","C'est un philtre."),
	array ("Si coniux te spernit, uestem eius perunge.","Si ton mari te délaisse, teins-en son vêtement."),
	array ("Id Deianira credidit, et sanguinem seruauit.","Déjanire le crut et conserva ce sang."),
	array ("Hercules Iolam Euryti filiam in coniugium petiit.","Hercule demanda en mariage Iole, fille d'Eurytus."),
	array ("Deianira timuit et uestem Herculi misit centauri sanguine tinctam.","Déjanire eut peur et envoya à Hercule un vêtement teint du sang du centaure."),
	array ("Hercules uestem induit statimque flagrare coepit.","Hercule revêtit le vêtement, et se mit aussitôt à brûler."),
	array ("demere autem cum uellet, uiscera sequebantur.","Lorsqu'il voulait l'ôter, ses entrailles venaient avec."),
	array ("Tum in pyram se imposuit et ustus est.","Alors, il se mit sur un bûcher et fut brûlé.")
	);

/*
   array("Ducem habere uolunt.","Ils veulent avoir un chef."),
   array("Legiones Marcellum sibi ducem ceperant.",
         "Les légions s'étaient choisi Marcellus comme chef."),
   array("Me Albani ducem creauere.","Les Albains m'ont désigné comme chef."),
   array("Ducem secuti sunt","Ils ont suivi leur chef."),
   array("hinc senatus, hinc plebs, suum quisque intuentes ducem, uelut in acie constiterant.",
         "D'un côté le sénat, de l'autre la plèbe, chacun observant son chef, s'étaient disposés comme à la guerre."),

//dux
   array("Sedullus dux Lemovicum occiditur.",
         "Sedullus, chef des Lemovices, est tué"),
   array("Ars est dux certior quam natura.",
         "L'art est un guide plus sûr que la nature."),
   array("Dux Parthorum vulnus accepit.",
         "Le chef des Parthes reçut une blessure."),
   array("Dux ego uester eram.","C'est moi qui étais votre chef."),
   array("Dux Graecorum militum Patron arma capere suos iubet",
         "Le chef des soldats Grecs, Patron, ordonne à ses hommes de prendre les armes."),
//ducis
   array("Saepe istius ducis nomen audiuerant.",
         "Ils avaient souvent entendu le nom de ce chef."),
   array("Paruum conspicimus magni tumulum ducis",
         "Nous regardons le petit tombeau du grand chef."),
   array("Miles ducis ardorem spectabat.",
         "Le soldat regardait l'ardeur du chef."),
   array("Id est uiri et ducis, non deesse fortunae praebenti se.",
         "C'est le propre de l'homme et du chef, de ne pas manquer à la fortune qui se présente."),
   array("Non omnia in ducis, aliquid et in militum manu est.",
         "Toutes choses ne sont pas entre les mains du chef, il y en a aussi entre celles du soldat."),
//duci
   array("Miles duci non defuit.","Le soldat ne manqua pas à son chef."),
   array("Imperat duci ut se in agrum Casinatem ducat.",
         "Il ordonne au guide de le conduire dans la région de Casinum."),
   array("Haec maxima erat cura duci.","Cela préoccupait beaucoup le chef."),
   array("ea res salutaris populo Romano ipsique duci atque exercitui est.",
         "Cette chose est salutaire au peuple romain, au chef lui-même et à l'armée."),
   array("Gratiam duci suo referunt.",
         "Ils sont reconnaissants envers leur chef."),
//duce
   array("Sine magistro duce natura mammas adpetunt",
         "Sans maître, avec la nature comme guide, ils cherchent les mammelles."),
   array("A duce Tarpeium mons est cognomen adeptus.",
         "Le mont Tarpéien tire son nom d'un chef."),
   array("Et ignotum iter sine duce non audebat ingredi.",
         "Et il n'osait pas s'engager sans guide dans ce chemin inconnu."),
   array("Ad unum omnes cum ipso duce occisi sunt.",
         "Ils furent tous tués jusqu'au dernier avec leur chef lui-même."),
   array("Duce hostium occiso urbem primo impetu capit.",
         "Le chef des ennemis tué, il prend la ville au premier assaut."),
//duces
   array("Hic inter duces duos fit contentio uter prius pontem occuparet.",
         "À ce moment il y eut un conflit entre les deux chefs pour savoir lequel occuperait le pont le premier."),
   array("Duces ii deliguntur.","Deux chefs sont choisis."),
   array("Si meum consilium valuisset, res publica non tot duces et exercitus amisisset.",
         "Si mon plan avait prévalu, l'état n'aurait pas perdu tant de chefs et d'armées."),
   array("Conueniunt duces.","Les chefs se réunissent."),
// ducum 
   array("Ducum fugit alter, alter occisus est.",
         "L'un des [deux] chefs s'enfuit, l'autre fut tué."),
   array("diversa erant ducum consilia.","Les avis des chefs étaient partagés."),
   array("Tria genera sunt ducum in apibus.","Il y a chez les abeilles trois genres de chefs."),
   array("Ipsi ducum fungebantur officio.","Ils remplissaient eux-mêmes la fonction de chefs."),
   array("Nihil nisi ducum iussu faciunt.","Ils ne font rien sans l'ordre des chefs."),
//ducibus
   array("Dum haec ab utrisque ducibus administrantur...",
       "Pendant que ces choses sont dirigées par les deux chefs..."),
   array("his copiis Vercassivellaunum Arvernum, unum ex quattuor ducibus, praeficiunt.",
      "Ils placent à la tête de ces troupes Vercassivellaunus, l'un des quatre chefs."),
   array("Videbam senatum ducibus orbatum.","Je voyais le sénat privé de guides."),
   array("His ducibus erimus profecto liberi brevi tempore.",
       "Avec ces chefs, nous serons sans doute libres dans peu de temps."),
   array("Hic quoque in summis habitus est ducibus.",
       "Lui aussi est considéré comme faisant partie des plus grands chefs."),
);       
*/

function sorsColl($c) {
    if (count($c) == 1) return $c[0];
    $red = $c[array_rand($c)]; 
    return $red;
}

// affecter ou récupérer le n° de phrase
if (isset ($_POST['nphrase']))
{
	$nphrase = $_POST['nphrase'];
	
}
//else $nphrase = rand(0, count ($exempla)-1); 
else $nphrase = 0;

// calculer latin et français
$gallice = $exempla[$nphrase][1];
$latine = $exempla[$nphrase][0];
// affecter ou récupérer le mode mot/lettre
// true : mot ; false : lettre.
if (isset ($_POST['modus']))
	$modus = $_POST['modus'];
else $modus = sorsColl (array (true, false));
//debog
$modus = true;

if ($modus)
{
	if (isset ($_POST['nmot']))
	{
		// affecter ou récupérer le n° du mot
		$nmot = $_POST['nmot'];
		$niveau = $_POST['niveau'];
	}
	else 
	{
		$nmot = 0;
		$niveau = 1;
	}
}
else
{
	if (isset ($_POST['nlettre']))
		$nlettre = $_POST['nlettre'];
	else $nlettre = 0;
}
if (isset ($_POST['justes']))
{
	$justes = $_POST['justes']; 
	$faux = $_POST['faux'];
}
else
{
	$justes = 0;
	$faux = 0;
}

//session_start();
echo "<html>\n";
echo "<head>\n";
echo "	<title>CRVSTVLA - SEQVENTEM LITTERAM INVENI</title>\n";
include "css.inc"; 
include "meta.inc.php";   
// compléter la feuille de style
echo "	<style>\n";
echo "	.juste {\n";
echo "	.font-family : sans-serif;\n";
echo "	font-size : 30px;\n";
echo "	color : Green;\n";
echo "	}\n";
echo "	.faux {\n";
echo "	font-family : sans-serif;\n";
echo "	font-size : 30px;\n";
echo "	color : Red;\n";
echo "	}";
echo "  </style>\n";

// script pour donner le focus à la ligne de saisie
echo "	<script>\n";
echo "	function sf(){document.f.reponse.focus()}";
echo "	</script>\n";
echo "</head>\n";
// Affichage
echo "<body onload=\"sf();\">\n";
echo "<p class=\"titre\">\n";
echo "Sequentem litteram inueni !";
echo "</p>\n";

// récupérer la réponse, l'afficher en vert ou rouge ;
if (isset ($_POST['reponse']))
{
	$reponse = $_POST['reponse'];
}

//echo "debog - nphrase:$nphrase: nmot:$nmot: reponse:$reponse:$alin";

// afficher la traduction
echo "<p class=\"question\">";
echo $gallice;
echo "</p>\n";

// calculer et afficher la partie lue
$imot = 0;
$ilettre = 0;
//$enlettres = ctype_alnum ($latine[0]);
$enlettres = 0;
// d'abord les mots déjà faits
echo "<form method=\"post\" class=\"textelat\" name=f>\n";
while ($ilettre < strlen ($latine) && $imot < $nmot)
{
	if (ctype_alnum ($latine[$ilettre]))  // afficher le car alpha
	{
		$enlettres = true;
	}
	else 
	{
	   if ($enlettres) 
	   {
		   $imot++;
		   $enlettres = false;
	   }
	}
	// si c'est le mot de la question précédente, calculer et afficher la sanction
	if ($imot == $nmot-1 && !ctype_alnum ($latine[$ilettre+1]))
	{
		if ($reponse == $latine[$ilettre]) $sanction = "juste";
		else $sanction = "faux";
		echo "<span class=\"$sanction\">".$latine[$ilettre]."</span>";
		if ($sanction == "juste") $justes++;
		else $faux++;
	}
	else echo $latine[$ilettre];
	$ilettre++;
}
// puis le dernier mot
//echo "debog ilettre :$ilettre:$alin";
//echo "debog dernier :" . !ctype_alnum ($latine[$ilettre+1]) . ":$alin";
$afficher = ctype_alnum ($latine[$ilettre+1]);
while ($ilettre < strlen ($latine) && ctype_alnum ($latine[$ilettre+1])) 
{
	echo $latine[$ilettre];
	$ilettre++;
	$afficher = false;
}

if (!$afficher && $ilettre < strlen($latine))
{
	// forme pour la ou les 2 lettre(s)
	echo "<input type=\"text\" name=\"reponse\" class=\"textelat\" size=\"1\" maxlength=\"1\">\n";
	// mise à jour des variables;
	$nmot++;
	echo "<input type=\"hidden\" name=\"nmot\" value=\"$nmot\">\n";
	echo "<input type=\"hidden\" name=\"nphrase\" value=\"$nphrase\">\n";
	//echo "<input type=\"hidden\" name=\"justes\" value=\"$justes\">\n";
	//echo "<input type=\"hidden\" name=\"faux\" value=\"$faux\">\n";
}
else if ($nphrase < count ($exempla))
{
	echo "$alin<input type=\"submit\" value=\"Alteram sententiam\">\n";
	$nphrase++;
	echo "<input type=\"hidden\" name=\"nphrase\" value=\"$nphrase\">\n";
}
else echo "$alin FINIS";
	echo "<input type=\"hidden\" name=\"justes\" value=\"$justes\">\n";
	echo "<input type=\"hidden\" name=\"faux\" value=\"$faux\">\n";
echo "</form>\n";
if ($nmot > 1)
{
	echo "$alin Justes : $justes - faux : $faux - ";
	echo  round ($justes /($faux + $justes) * 100);
	echo " % de réussite\n";
}
?>
<p class="redi"><a href='./'>reditus</a> <a href="gpl.html" target="gpl">Licentia GPL</a></p>
</body>
</html>
