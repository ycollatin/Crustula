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

function sorsColl($c) {
    if (count($c) == 1) return $c[0];
   return $c[mt_rand(0, count($c)-1)];   
}

function genet($u) {
   $prim = preg_replace("/a$/","ae",$u);
   if ($prim != $u)
       return $prim;
   return preg_replace("/us$/","i",$u);
}

$lexicum = array(
   'amica amie',
   'amicus ami',
   'filia fille',
   'filius fils',
   'inimicus ennemi',
   'medicus médecin',
   'seruus esclave',
   'uicina voisine',
   'uicinus voisin');

$dema = array('fille','voisine');

$artLe = array('fils','médecin','voisin');
$artLa = array('fille','voisine');

$nomina = $lexicum;
for ($i=0; $i < count($lexicum); $i++)
   $nomina[$i] = preg_replace("/^.*\s/", "", $nomina[$i]);
    
$nomin = sorsColl($lexicum); 
$genit = $nomin;

function article($n) {
    global $artLe, $artLa;
    if (in_array($n, $artLe))
        return 'le ';
    elseif (in_array($n, $artLa))
        return 'la ';
    else return "l'";
}

function prep($n) {
    global $dema;
    if (in_array($n, $dema))
        return 'de ma ';
    else return 'de mon ';
}

function init($u) {
   preg_match("/(^.{3,3})/", $u, $i);
   return $i[1];
}

function primus($l) {
   $c = explode(' ', $l);
   return $c[0];
}

// corrigere

function vgallice($s) {
    global $lexicum;
    foreach ($lexicum as $l) 
        if (preg_match("/^($s)\s(.*)$/", $l, $partes))
            return $partes[2];
}

function nominatius($g) {
   $pro[0] = "/ae$/";
   $dic[0] = 'a';
   $pro[1] = "/i$/";
   $dic[1] = 'us';
   $n = preg_replace($pro, $dic, $g);
   return $n;
}

function gallice($s) {
   // traduit en français la question $s posée en latin
   global $solN, $solG;
   $coll = explode(' ',$s);
   $ei = array('e','i');
   if (in_array(substr($coll[0], -1), $ei)) {
       $solG = vgallice(nominatius($coll[0]));
       $solN = vgallice($coll[1]);
   } else {
       $solG = vgallice(nominatius($coll[1]));
       $solN = vgallice($coll[0]);
   }
   return article($solN)."$solN ".prep($solG).$solG;
}

if (isset($_POST["sententia"])) { 
    $priorsent = $_POST["sententia"]; 
    $respN = $_POST["respN"];
    $respG = $_POST["respG"];
}

// alter
$initNom = init($nomin);

while (init($genit) == $initNom)
    $genit = sorsColl($lexicum);

$genit = genet(primus($genit));
$nomin = primus($nomin);

$collS = array($genit, $nomin);
shuffle($collS);

$sententia = implode(' ', $collS); 
session_start();
?>
<html>
<head>
<title>CRVSTVLA - GEN</title>
<?php 
   include "css.inc"; 
   include "meta.inc.php";   
?>
</head>
<body>
<p class="titre">
CVIVS ?
</p>
<?php
if (!empty($priorsent)){
   echo "prior quaestio : ".$priorsent.$alin;
   echo "gallice : ".gallice($priorsent).$alin;
   //echo "<br>sujet : $sujet, objet : $objet.<br>";
   $recte = ($solN == $respN && $solG == $respG);
   //if ($solN == $respN && $solG == $respG)
   if ($recte)
	   echo "<div class=\"juste\">RECTE !</div>"; 
   else 
	   echo "<div class=\"faux\"> Errauisti. Respondisti le/la/l' $respN de mon/ma  $respG.</div>";
   include "session.php.html";
} else {
   $_SESSION['prius'] = 0;
   $_SESSION['consec'] = 0;
}
?>
<p class="question">
<?php echo $sententia; ?>
</p>
<form method="post">
<p class="question">
<?php

echo "Le/la/l'";
echo "<select name=\"respN\">\n";
$prim = 1;
foreach ($nomina as $el) {
   echo "<option value=\"$el\"";
   if ($prim) {
      echo " selected";
      $prim = 0;
   }
   echo ">$el</option>\n";
}
echo "</select>\n";

echo " de mon/ma ";

echo "<select name=\"respG\">\n";
$prim = 1;
foreach ($nomina as $el) {
   echo "<option value=\"$el\"";
   if ($prim) {
      echo " selected";
      $prim = 0;
   }
   echo ">$el</option>\n";
}
echo "</select>.&nbsp;&nbsp;&nbsp;\n";
echo "<input type=\"submit\" value=\" Num recte dixi ? \">\n";
echo "<input type=\"hidden\" name=\"sententia\" value=\"$sententia\">";
?>
</p>
</form>
<p class="redi"><a href='./'>reditus</a> <a href="gpl.html" target="gpl">Licence GPL</a></p>
</body>
</html>
