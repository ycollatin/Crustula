<?php
/*
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
*/
$alin = "<br>\n";
$exempla = array(
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

function sorsColl($c) {
    if (count($c) == 1) return $c[0];
    $red = $c[array_rand($c)]; 
    return $red;
}

$q = sorsColl($exempla);
$gallice = $q[1];
$latine = $q[0];
$latine = preg_replace("/\b([Dd]u(x|c(e[ms]?|i(bus|s)?|um)))/",'<input class="question" type="text" name="resp">',
    $latine);

function sol($sent) {
    global $exempla, $linea;
    foreach ($exempla as $ex) {
        $g = $ex[1];
	if ($g == $sent) {
           $linea = $ex[0];
	   preg_match("/([Dd]u[xc]\w*)\b/", $linea, $partes);
	   return strtolower($partes[1]);
	}
    }
}
if(isset($_POST['resp'])) {
    $resp = $_POST['resp'];
    $resp = strtolower($resp); 
    $priorsent = $_POST['priorsent']; 
    $priorsent = stripslashes($priorsent);
    $recte = ($resp == sol($priorsent));
}
session_start();
?>
<html>
<head>
<title>CRVSTVLA - DVX</title>
<?php 
   include "css.inc"; 
   include "meta.inc.php";   
?>
</head>
<body>
<p class="titre">
dux, ducis, m. : chef
</p>
<?php
if (isset($priorsent)){
   echo "prior sententia : $priorsent$alin$linea$alin";
   if ($recte)
	   echo "<div class=\"juste\">RECTE !</div>"; 
   else 
	   echo "<div class=\"faux\"> Errauisti. Respondisti $resp";
   include "session.php.html";
} else {
   $_SESSION['prius'] = 0;
   $_SESSION['consec'] = 0;
}

?>
</p>
<p class="question">
   <?php 
   echo $gallice;
   ?> 
</p>
<form method="post">
<p class="question">
<?php
echo $latine;
?>
&nbsp;<input type="submit" value="Num recte dixi ?">
<input type="hidden" name="priorsent" value="<?php echo $gallice; ?>">
</p>
</form>
<p class="redi"><a href='./'>reditus</a> <a href="gpl.html" target="gpl">Licentia GPL</a></p>
</body>
</html>
</body>


