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
$mares = array(
   "Aemilius",
   "Naso,Nasonis",
   "uir,uiri,son mari",
   "gener,generi,mon gendre",
   "faber,fabri,un ouvrier",
   "sodalis,sodalis,mon camarade"
);

$feminae = array(
   "Aemilia",
   "Iulia",
   "ornatrix,ornatricis,la coiffeuse",
   "soror,sororis,ma soeur",
   "uxor,uxoris,ma femme",
   "Venus,Veneris"
);

$nomina = array_merge($feminae, $mares);

foreach($nomina as $nomen) {
   $partes = explode(',', $nomen);
   $c = count($partes);
   if ($c < 3) $gal[] = $partes[0];
   else $gal[] = $partes[2];
}
natsort($gal);

function sorsColl($c) {
    if (count($c) == 1) return $c[0];
   return $c[mt_rand(0, count($c)-1)];   
}

function acc($n) {
    // accusatiuum reddit, data linea tota.
    $partes = explode(',', $n);
    $cp = count($partes);
    if ($cp == 1) {
        //$pro = array(); $dic = array();
        $pro[] = "/(a)$/"; $dic[] = "am";
	$pro[] = "/(us)$/"; $dic[] = "um";
	$red = preg_replace($pro, $dic, $n);
	return $red;
    }
    unset($pro); unset($dic);
    $pro[] = "/(i)$/"; $dic[] = "um";
    $pro[] = "/(is)$/"; $dic[] = "em";
    $red = preg_replace($pro, $dic, $partes[1]);
    return $red;
}

function accadgall($n) {
    global $nomina;
    foreach($nomina as $a)
        if (acc($a) == $n) { 
	    $partes = explode(',', $a);
            if (count($partes) < 3) return $partes[0];
            else return $partes[2];
	}
}

function gal($n) {
    global $nomina;
    $n = trim($n);
    foreach($nomina as $nomen) {
        $partes = explode(',', $nomen);
	if ($partes[0] == $n) {
	    if (count($partes) < 3) return $partes[0];
	    else return $partes[2];
	}
    }
}

function cod() {
    global $nomina, $feminae, $genusCOD;
    $linea = sorsColl($nomina);
    $nucleus = acc($linea);
    if (in_array($linea, $feminae))
        $genusCOD = 'f';
    else $genusCOD = 'm';
    return $nucleus;
}

function subiect() {
    global $nomina, $mares, $feminae, $genusCOD;
    if ($genusCOD == 'f')
        $linea = sorsColl($mares);
    else $linea = sorsColl($feminae);
    $nucleus = preg_replace("/(\,.*)$/", "", $linea);
    return $nucleus;
}

function gallice($s) {
   $s = preg_replace("/(\.)$/", "", $s);
   preg_match("/\b(\w*[aeu]m)\b/", $s, $partes);
   $objet = accadgall($partes[1]);
   $s = preg_replace("/(".$partes[1].")/", '', $s);
   $sujet = preg_replace("/(amat)/", "", $s);
   $sujet = gal($sujet);
   return "$sujet aime $objet."; 
}


// décider du sexe du sujet

function sententia() {
   $obiectus = cod();
   $subiectus = subiect();
   $p = array($subiectus, $obiectus, 'amat');
   shuffle($p);
   return implode(" ", $p).'.';
}
session_start();
?>
<html>
<head>
<title>CRVSTVLA - SOV III</title>
<?php 
   include "css.inc";
   include "meta.inc.php";   
?>
</head>
<body>
<p class="titre">
QVIS QVEM AMAT (III)?
</p>
<?php
if (isset($_POST["sententia"])) 
   $priorsent = $_POST["sententia"]; 
if (isset($priorsent)) {
    $gallice = gallice($priorsent);
    echo "prior sententia : ".$priorsent.$alin;
    echo "gallice : $gallice $alin";
    $respS = $_POST["respS"];
    $respO = $_POST["respO"];
    $resp = "$respS aime $respO.";
    //echo "<br>sujet : $sujet, objet : $objet.<br>";
    $recte = ($gallice == $resp);
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
   $sententia = sententia();
   echo $sententia;
   ?> 
</p>
<form method="post">
<p class="question">
<?php


echo "<select name=\"respS\">\n";
$prim = 1;
foreach ($gal as $el) {
   echo "<option value=\"$el\"";
   if ($prim) {
      echo " selected";
      $prim = 0;
   }
   echo ">$el</option>\n";
}
echo "</select>\n";

echo " aime "; 

echo "<select name=\"respO\">\n";
$prim = 1;
foreach ($gal as $el) {
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
<p class="redi"><a href='./'>reditus</a> <a href="gpl.html" target="gpl">Licentia GPL</a></p>
</body>
</html>
