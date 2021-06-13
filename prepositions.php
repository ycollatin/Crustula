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
/*
DONATVS :
  da praepositiones casus accusativi.
ad apud ante adversum cis citra circum circa contra erga extra inter intra
infra iuxta ob pone per prope secundum post trans ultra praeter propter
supra usque penes.

  da praepositiones casus ablativi. 
ab abs cum coram clam de e ex pro prae palam sine absque tenus. 

  da utriusque casus praepositiones. 
in sub super subter.  

*/

$prae_acc = array(
  "ad :  vers, à, près de",
  "apud : près de, chez",
  "ante : devant, avant ; adv. avant",
  "aduersus a, um : contraire ( = contre)",
  "cis : en deçà",
  "citra : en deçà de, contrairement à",
  "circum : autour de",
  "circa : autour de",
  "contra : contre",
  "erga : devant, en face de",
  "extra : en dehors de",
  "inter : parmi, entre",
  "intra : au-dedans, à l'intérieur de",
  "infra : au-dessous de, en bas de",
  "iuxta : à côté de",
  "ob : à cause de",
  "pone : derrière",
  "per : à travers, par",
  "prope  : près de",
  "secundum : après, derrière, selon, suivant, conformément à",
  "post : après",
  "trans : de l'autre côté",
  "ultra : plus loin que, plus que",
  "praeter  : devant, le long de, au-delà de, excepté",
  "propter : à cause de, à côté",
  "supra : au dessus de, au delà de",
  "usque ad : jusqu'à",
  "penes : en possession de"
);

$prae_abl = array(
  "ab : à partir de, après un verbe passif = par",
  "abs : par, de",
  "cum : avec",
  "coram  : devant, publiquement",
  "de : au sujet de, du haut de, de",
  "e : hors de, de",
  "ex : hors de, de",
  "pro : devant, pour, à la place de, en considération de",
  "prae : devant, à cause de",
  "palam : en présence de, devant",
  "sine : sans",
  "absque : sans, excepté, loin de",
  "tenus : jusqu'à"
);

$prae_uterque = array( 
  "in : dans, sur, contre (lieu où l'on va) : dans, sur (lieu où l'on est)",
  "sub : sous, de dessous, immédiatement après, au moment de : sous, aux environs de, vers la même époque que ",
  "super : sur, au-dessus de, au-delà de, pendant : sur, au-dessus de, en plus de, au sujet de ",
  "subter : sous, au pied de : sous, au pied de (poétique)"
  //"clam : à l'insu de : à l'insu de"
);

$omnes = array_merge($prae_abl, $prae_acc, $prae_uterque);

$alin = "<br>\n";

function sorsColl($c) {
    if (count($c) == 1) return $c[0];
   return $c[mt_rand(0, count($c)-1)];   
}

function dic_quaestionem($p) {
   return "De quel cas est suivi la préposition<br>\n$p ?";
}

function solutio($p) {
   global $prae_acc, $prae_abl, $prae_uterque;
   if (in_array($p, $prae_acc))
      return "accusatif";
   elseif (in_array($p, $prae_abl))
      return "ablatif";
   else {
      $eclats = explode(":", $p);
      $rprep = $eclats[0];
      $rdef = $eclats[1];
      foreach ($prae_uterque as $linea) {
         $eclats = explode(":", $linea);
	 if ($rprep == $eclats[0]) {
            if ($rdef == $eclats[1])
	       return "accusatif";
	    else return "ablatif";
	 }
      }
   }
}

$praep = sorsColl($omnes);
if (substr_count($praep, ":") == 2) {
   $eclats = explode(":", $praep);
   if(sorsColl(array("acc","abl")) == "acc")
      $quaestio = dic_quaestionem("$eclats[0] : $eclats[1]");
   else $quaestio = dic_quaestionem("$eclats[0] : $eclats[2]");
} else $quaestio = dic_quaestionem($praep);

session_start();
?>
<html>
<head>
<title>CRVSTVLA - PRAEPOSITIONES</title>
<?php include "css.inc" ?>
</head>
<body>
<p class="titre">
CRVSTVLA - PRAEPOSITIONES
</p>
<?php
$priorQ = $_POST["priorQ"];
$priorQ = stripslashes($priorQ);
$r = $_POST["r"];
if (!empty($r)) {
    $resp = $r;
    $r = stripslashes($r);
    $r = strtolower(trim($r));
    $pQ = $priorQ;
    echo "prior quaestio : ".dic_quaestionem($priorQ);
    $s = solutio($pQ); 
    $recte = ($s == $r); 
    if ($recte)
	    echo "<div class=\"juste\">RECTE !</div>"; 
    else {
	    echo "solutio : $s$alin";
	    echo "<div class=\"faux\"> Errauisti. Respondisti $resp$alin"; 
    }
    include "session.php.html";
} else {
   $_SESSION['prius'] = 0;
   $_SESSION['consec'] = 0;
}
?>
<p class="question">
<?php echo $quaestio
?>
</p>
<form method="post">
<p class="question">
<?php
   $choix = array("accusatif", "ablatif");
   echo "<select name=\"r\">\n";
   $prim = 1;
   shuffle($choix);
   foreach ($choix as $el) {
     echo "<option value=\"$el\"";
     if ($prim) {
      echo " selected";
      $prim = 0;
     }
   echo ">$el</option>\n";
}
echo "</select>\n";
echo "<input type=\"submit\" value=\" Num recte dixi ? \">\n";
echo "<input type=\"hidden\" name=\"priorQ\" value=\"$praep\">";
?> 
</p>
</form>
<p class="redi"><a href='./'>reditus</a> <a href="gpl.html" target="gpl">Licentia GPL</a></p>
</body>
