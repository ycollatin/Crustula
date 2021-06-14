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
// Agents , prÃ©p a/ab + ablatif.

$alin = "<br>\n";

$feminae = array(
   "Aemilia",
   "Annia",
   "Faustina",
   "Galla",
   "Iulia",
   "Lucia",
   "Octauia",
   "Lucretia",
   "Papiria",
   "Sempronia");

$mares = array(
   "Aemilius",
   "Aulus",
   "Baebius",
   "Eupalamus",
   "Marcus",
   "Mucius",
   "Papinius",
   "Publius",
   "Rabirius",
   "Titinius"
   );

$homines = array_merge($feminae, $mares);   
natsort($homines);

$loca = array(
    "a castris, du camp",
    "ab urbe, de la ville",
    "ab oppido, de la place forte",
    "Roma, de Rome"
);    

$locaFr = array();
foreach($loca as $l)
    $locaFr[] = eLexAdFr($l);
    
$regimina = array_merge($locaFr, $homines);

$uerbaA = array(
    "abest, est absent(e)",
    //"exit, sort",
    "fugit, s'enfuit",
    "proficiscitur, part",
    "secedit, s'Ã©loigne",
    "uenit, vient",
);

$uerbaP = array(
    "amatur, est aimÃ©(e) de",
    "curatur, est soignÃ©(e) par",
    "decipitur, est trompÃ©(e) par",
    "uerberatur, est frappÃ©(e) par",
    "laudatur, est louÃ©(e) par",
    "probatur, est approuvÃ©(e) par",
    "reprehenditur, est blÃ¢mÃ©(e) par"
);

$uerba = array_merge($uerbaA, $uerbaP);
$uerbaFr = array();
foreach($uerba as $u)
    $uerbaFr[] = eLexAdFr($u);
natsort($uerbaFr);    

function sorsColl($c) {
    if (count($c) == 1) return $c[0];
    $red = $c[array_rand($c)]; 
    //return preg_replace("/\,.*$/", "", $red);
    return $red;
}

function eLexAdLat($l) {
    $red = preg_replace("/\,.*$/", "", $l);
    return $red;
}

function eLexAdFr($l)  {
    $red = preg_replace("/^.*\,\s/", "", $l);
    return $red;
}

function lemma($f) {
    //echo "-$f-";
    $pro[0] = "/a$/"; $dic[0] = "a";
    $pro[1] = "/o$/"; $dic[1] = "us";
    $red = preg_replace($pro, $dic, $f);
    return $red;
}

function eLatAdFr($l) {
    global $homines, $loca;
    //echo "--$l--";
    $nomen = preg_replace("/^ab?\s/", "", $l);
    //echo "-$nomen-";
    $nomen = lemma($nomen);
    //echo "*$nomen-";
    foreach ($homines as $h) {
        if ($h == $nomen) return $h;
    }
    foreach ($loca as $unde)
        if (eLexAdLat($unde) == $l) return eLexAdFr($unde);
}

function eVLatAdFr($u) {
    global $uerba;
    //echo "-$u-";
    foreach($uerba as $v) {
        preg_match("/^($u)\,\s(.*)$/", $v, $partes);
        //echo "$v, partes1 -".$partes[1];
        if (isset($partes[1]) && $partes[1] == $u)
        //if ($partes[1] == $u)
            return $partes[2];
    }
}

function facAgentem($n) {
    if (in_array($n[0], array('A','E','I','O')))
        $prep = 'ab ';
    else $prep = 'a ';
    $pro[0] = "/us$/"; $dic[0] = "o";
    $pro[1] = "/a$/"; $dic[1] = "a";
    $red = preg_replace($pro, $dic, $n);
    return $prep.$red;
}

function sententia() {
    global $feminae, $mares, $uerbaA, $uerbaP, $loca;
    $genus = sorsColl(array('f','m'));
    if ($genus == 'f') $nomin = eLexAdLat(sorsColl($feminae));
    else $nomin = eLexAdLat(sorsColl($mares));
    if (sorsColl(array('a','p')) == 'p') {
        $uerbum = eLexAdLat(sorsColl($uerbaP));
        if ($genus == 'f') $agens = eLexAdLat(sorsColl($mares));
        else $agens = eLexAdLat(sorsColl($feminae));
        $agens = facAgentem($agens);
        $coll = array($nomin, $uerbum, $agens);
    } else {
        $uerbum = eLexAdLat(sorsColl($uerbaA));
        $locum = eLexAdLat(sorsColl($loca));
        $coll = array($nomin, $uerbum, $locum);
    }
    shuffle($coll);
    return implode(' ', $coll).'.';
}

$sententia = sententia();

function gallice($s) {
    global $sujet, $verbe, $regim;
    $s = substr($s, 0, -1); // punctum remouere
    // ablatiuum
    preg_match("/\b(ab?\s\w+)/", $s, $partes);
    //echo "xx$partes[1]xx";
    //if (!$partes[1])
    if (!isset($partes[1]))
        preg_match("/(Roma)/", $s, $partes);
    $regim = eLatAdFr($partes[1]);
    // ablatiuum tollere
    $s = preg_replace("/\bab?\s\w+/", "", $s);
    $s = preg_replace("/Roma/", "", $s);
    //echo "s : -$s-";
    preg_match("/\b(\w*[tr])\b/", $s, $partes);
    $verbe = eVLatAdFr($partes[0]);
    $sujet = preg_replace("/".$partes[0]."/", "", $s);
    $sujet = trim($sujet); // gloriari non decet.
    // ajuster l'accord du pp franÃ§ais
    if (substr($sujet, -1) == "a" && preg_match("/(Ã©)\s/", $verbe))
        $verbe = preg_replace("/Ã©\s/", "Ã©e ", $verbe); 
    return "$sujet $verbe $regim.";
}

// Responsa capere
if(isset($_POST['respS'])) {
    $respS = $_POST['respS'];
    $respV = stripslashes($_POST['respV']);
    if (preg_match("/a$/", $respS))
    $respV = preg_replace("/Ã©\s/", "Ã©e ", $respV); 
    $respR = $_POST['respR'];
    //$respR = preg_replace("/^\w*\s/","",$respR);

    $priorSent = $_POST['priorSent'];
}
session_start();
?>
<html>
<head>
<title>CRVSTVLA - agent</title>
<?php 
   include "css.inc";
   include "meta.inc.php";
?>
</head>
<body>
<p class="titre">
VNDE ? A QVO ?
</p>
<?php
if (isset($priorSent)) {
   echo "prior sententia : ".$priorSent.$alin;
   echo "gallice : ".gallice($priorSent).$alin;
   //echo "<br>solutio : -$sujet-, verbe : -$verbe- rÃ©gime : -$regim-.<br>";
   //echo "<br>rÃ©ponse : -$respS-, verbe : -$respV- rÃ©gime : -$respR-.<br>";
   $recte = ($sujet == $respS && $verbe == $respV && $regim == $respR);
   if ($recte)
	   echo "<div class=\"juste\">RECTE !</div>"; 
   else 
	   echo "<div class=\"faux\"> Errauisti. Respondisti "
		   ."$respS $respV $respR.</div>";
   include "session.php.html";
} else {
   $_SESSION['prius'] = 0;
   $_SESSION['consec'] = 0;
}
?>
</p>
<p class="question">
   <?php 
   echo $sententia;
   ?> 
</p>
<form method="post">
<p class="question">
<?php

echo "<select name=\"respS\">\n";
$prim = 1;
foreach ($homines as $el) {
   echo "<option value=\"$el\"";
   if ($prim) {
      echo " selected";
      $prim = 0;
   }
   echo ">$el</option>\n";
}
echo "</select>\n";

echo "&nbsp;";

echo "<select name=\"respV\">\n";
$prim = 1;
foreach ($uerbaFr as $el) {
   echo "<option value=\"$el\"";
   if ($prim) {
      echo " selected";
      $prim = 0;
   }
   echo ">$el</option>\n";
}
echo "</select>\n";

echo "&nbsp;";

echo "<select name=\"respR\">\n";
$prim = 1;
foreach ($regimina as $el) {
   echo "<option value=\"$el\"";
   if ($prim) {
      echo " selected";
      $prim = 0;
   }
   echo ">$el</option>\n";
}
echo "</select>\n";
echo "<input type=\"submit\" value=\" Num recte dixi ? \">\n";
echo "<input type=\"hidden\" name=\"priorSent\" value=\"$sententia\">";
?>
</p>
</form>
<p class="redi"><a href='./'>reditus</a> <a href="gpl.html" target="gpl">Licence GPL</a></p>
</body>
</html>
