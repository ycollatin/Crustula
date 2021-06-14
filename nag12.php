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

$lexicum = array(

	"ira ae, f. : colère",
	"natura ae, f. : nature",
	"memoria ae, f. : mémoire, souvenir",
	"pugna ae, f. : la bataille, le combat, le pugilat",
	"cura ae, f. : soin, souci",
	"fama ae, f. : la nouvelle, la rumeur, la réputation",
	"uia ae, f. : route, chemin, voyage",
	"herba ae, f. : herbe",
	"columna ae, f. : colonne",
	"gratia ae, f. : reconnaissance",
	"inuidia ae, f. : jalousie, envie, haine",
	"hora ae, f. : heure",
	"gloria ae, f. : gloire",
	"anima ae, f. : coeur, âme",
	"forma ae, f. : forme, beauté",
	"fortuna ae, f. : fortune, chance",
	"regina ae, f. : reine",
	"sapientia ae, f. : sagesse",
	"arena ae, f. : sable",
	"turba ae, f. : foule, désordre, émoi",
	"umbra ae, f. : ombre",
	"puella ae, f. : fille, jeune fille",
	"flamma ae, f. : flamme",
	"iniuria ae, f. : injustice, violation du droit",
	"aqua ae, f. : eau",
	"uita ae, f. : vie",
	"fuga ae, f. : la fuite",
	"poena ae, f. : châtiment",
	"silua ae, f. : forêt",
	"dea ae, f. : déesse",
	"porta ae, f. : porte (d'une ville)",
	"amicitia ae, f. : amitié",
	"lacrima ae, f. : larme",
	"prudentia ae, f. : prévoyance",
	"uictoria ae, f. : victoire",
	"prouincia ae, f. : province",
	"terra ae, f. : terre",
	"causa ae, f. : cause",
	"fera ae, f. : la bête sauvage",
	"mora ae, f. : délai, retard, obstacle",
	"sententia ae, f. : avis, opinion",
	"opera ae, f. : le soin, l'effort",
	"coma ae, f. : chevelure, cheveux",
	"ara ae, f. : autel",
	"praeda ae, f. : butin, dépouilles, proie",
	"persona ae, f. : masque, rôle, caractère",
	"pecunia ae, f. : argent",
	"patria ae, f. : patrie",

	"oculus i, m. : oeil",
	"humerus i, m. : épaule",
	"uentus i, m. : vent",
	"numerus i, m. : nombre",
	"somnus i, m. : sommeil",
	"deus i, m. : dieu",
	"seruus i, m. : esclave",
	"dominus i, m. : maître",
	"tribunus i, m. : tribun",
	"cibus i, m. : nourriture",
	"amicus i, m. : ami",
	"legatus i, m. : légat, envoyé",
	"campus i, m. : plaine",
	"filius ii, m. : fils",
	"morbus i, m. : maladie",
	"populus i, m. : peuple",
	"uulgus i, n. : foule",
	"annus i, m. : année",
	"animus i, m. : coeur, courage",
	"necessarius i, m. : le parent, l'ami, l'allié",
	"umerus i, m. : l'épaule",
	"mundus i, m. : monde, univers",
	"equus i, m. : cheval",
	"lucus i, m. : bois sacré",
);

$casus = array("nominatif", "accusatif", "génitif");

function declin($lem, $casus, $plur = 0) {
  if (!$plur) {
     switch ($casus) {
      case 'nom': 
         return $lem;
         break;
      case 'acc':
         $pro[] = '/a$/'; $dic[] = 'am';
         $pro[] = '/us$/'; $dic[] = 'um';
         break;
      case 'gén':
         $pro[] = '/a$/'; $dic[] = 'ae';
         $pro[] = '/us$/'; $dic[] = 'i';
         break;
      case 'dat':
         $pro[] = '/a$/'; $dic[] = 'ae';
         $pro[] = '/us$/'; $dic[] = 'o';
         break;
      case 'abl':
         $pro[] = '/a$/'; $dic[] = 'a';
         $pro[] = '/us$/'; $dic[] = 'o';
         break;
      }
  } else {
     switch ($casus) {
      case 'nom': 
         $pro[] = '/a$/'; $dic[] = 'ae';
         $pro[] = '/us$/'; $dic[] = 'i';
         break;
      case 'acc':
         $pro[] = '/a$/'; $dic[] = 'as';
         $pro[] = '/us$/'; $dic[] = 'os';
         break;
      case 'gén':
         $pro[] = '/a$/'; $dic[] = 'arum';
         $pro[] = '/us$/'; $dic[] = 'orum';
         break;
      case 'dat':
      case 'abl':
         $pro[] = '/a$/'; $dic[] = 'is';
         $pro[] = '/us$/'; $dic[] = 'is';
         break;
     } 
   }
  return preg_replace($pro, $dic, $lem);
}

function morph($m) {

}

function sorsColl($c) {
    if (count($c) == 1) return $c[0];
   return $c[mt_rand(0, count($c)-1)];   
}

$lemme = sorsColl($lexicum);
$quaestio = sorscoll($casus);
session_start();
?>
<html>
<head>
<title>CRVSTVLA - Decl nom acc gen 1 2</title>
<?php 
   include "css.inc";
   include "meta.inc.php";   
?>
</head>
<body>
<p class="titre">
DECLINATIONES I II, nom. acc. gen.
</p>
<?php
if (isset($_POST["priorQ"]))
    $priorQ = $_POST["priorQ"];
if (isset($priorQ)){
   $eclats = explode("|", $priorQ);
   $priorQ = preg_replace("/\|/", " <span class=\"juste\">" , $priorQ)." ?";
   $priorL = $eclats[0];
   // lemmam extrahere :
   preg_match("/^(\w+)\s/", $priorL, $partes);
   $priorL = $partes[1];
   $priorK = substr($eclats[1], 0,3);
   $resp = trim($_POST["resp"]);
   $sol = declin($priorL, $priorK);
   echo "Prior quaestio : $priorQ</span>$alin$sol";
   $recte = $resp == $sol;
   if ($recte)
	   echo "<div class=\"juste\">RECTE !</div>"; 
   else 
	   echo "<div class=\"faux\"> Errauisti. Respondisti : $resp</div>";
   include "session.php.html";    
} else {
   $_SESSION['prius'] = 0;
   $_SESSION['consec'] = 0;
}
?>
<p class="question">
<?php
    echo "$lemme$alin";
    echo "$quaestio ?$alin";
?>
</p>
<form method="post">
<p class="question">
<input class="question" type="text" name="resp">
<input type="submit" value="Num recte dixi ?">
<input type="hidden" value="<?php echo "$lemme|$quaestio" ?>" name="priorQ">
</p>
</form>
<p class="redi"><a href='./'>reditus</a> <a href="gpl.html" target="gpl">Licentia GPL</a></p>
</body>
</html>
