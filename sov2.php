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
$alinea = "<br>\n";

$nominVs = array(
   "Aemilius",
   "Eupalamus",
   "Publius",
   "Aulus",
   "Marcus"
);

$nominEr = array(
   "uir,mon mari",
   "gener,mon gendre",
   "socer,mon beau-père",
   "puer,un enfant",
   "aper,un sanglier",
   "faber,un ouvrier",
   "magister,le maître"
);

$nominM = array_merge($nominVs, $nominEr);
natSort($nominM);

$nominF = array(
   "Aemilia",
   "capra,une chèvre",
   "fera,une bête",
   "Iulia",
   "Lucia",
   "Lucretia",
   "panthera,une panthère",
   "scurra,un bouffon",
   "Sempronia",
   "uipera,une vipère"
);

$nomina = array_merge($nominF, $nominM);

$nominaF = array();
$nominaL = array();
foreach($nomina as $n) {
   $partes = explode(',', $n);
   if (count($partes) > 1) {
       $nominaF[] = $partes[1];
       $nominaL[] = $partes[0];
   } else {
       $nominaF[] = $partes[0];
       $nominaL[] = $partes[0];
   }
}

natsort($nominaF);


function acc($n) {
   $pro[0] = "/us$/";  $dic[0] = "um";
   $pro[1] = "/ir$/";  $dic[1] = "irum";
   $pro[2] = "/ber$/"; $dic[2] = "brum";
   $pro[3] = "/ger$/"; $dic[3] = "grum";
   $pro[4] = "/per$/"; $dic[4] = "prum";
   $pro[5] = "/cer$/"; $dic[5] = "cerum";
   $pro[6] = "/ner$/"; $dic[6] = "nerum";
   $pro[7] = "/uer$/"; $dic[7] = "uerum";
   $pro[8] = "/a$/";   $dic[8] = "am";
   $pro[9] = "/us$/";  $dic[9] = "um";
   return preg_replace($pro, $dic,  $n);
}

function accF($n) {
   return $n.'m';
}

function lemmaF($f) {
   global $nomina,$nominaL;
   // nominatifs
   if (preg_match("/(a|us|er)$/", $f)) $red = $f;
   //echo "red k : -$red-";
   //uirum
   elseif (preg_match("/^(uirum)$/", $f)) $red = "uir";
   // modèle uita
   elseif (preg_match("/(\w*a)m$/", $f, $partes))
       $red = $partes[1]; 
   //echo "red am : -$red-";
   else {
       // modèle amicus
       $test = preg_replace("/um$/", "us", $f);
       if (in_array($test, $nominaL)) $red = $test; 
  
       // modèle puer
       $test = preg_replace("/erum$/", "er", $f);
       if (in_array($test, $nominaL)) $red = $test; 

       // modèle ager
       $test = preg_replace("/rum$/", "er", $f);
       if (in_array($test, $nominaL)) $red = $test; 
   }
   foreach ($nomina as $n) {
           if (preg_match("/^($red)$/", $n))
                   return $red;
           if (preg_match("/^($red)\,(.*)$/", $n, $partes))
                   return $partes[2]; 
   }
}

function gallice($s) {
   // in tabulam uertere sententiam :
   global $sujet, $verbe, $objet;
   $s = preg_replace("/\W$/", "", $s);
   $coll = explode(" ", $s);
   foreach($coll as $uer) { 
       //echo '*'.$uer.'*'.$alinea;
       if ($uer == "amat") $verbe = "aime";
       elseif ($uer == "spectat") $verbe = "regarde";
       elseif (preg_match("/m$/", $uer)) $objet = $uer;
       else $sujet = $uer;
   }
   //echo "*sujet : -$sujet- *objet : -$objet-";
   $sujet = lemmaF($sujet);
   $objet = lemmaF($objet);
   return "$sujet $verbe $objet."; 
}

function sorsColl($c) {
    if (count($c) == 1) return $c[0];
   $red = $c[mt_rand(0, count($c)-1)];   
   $partes = explode(',',$red);
   if (count($partes) > 1) return $partes[0];
   return $partes[0];
}

// décider du sexe du sujet
$sexus = array('m','f');
if (sorsColl($sexus) == 'm') {
    $subiectus = sorsColl($nominM);
    $obiectus = acc(sorsColl($nominF));
} else {
    $subiectus = sorsColl($nominF);
    $obiectus = acc(sorsColl($nominM));
}

if (ucfirst($subiectus) == $subiectus && ucfirst($obiectus) == $obiectus)
    $uerbum = "amat";
else $uerbum = "spectat";

function sent() {
    global $subiectus, $obiectus, $uerbum;
    $c = array ($subiectus, $obiectus, $uerbum);
    shuffle($c);
    return implode (" ", $c) . '.'; // .$alinea;
}
session_start();
?>
<html>
<head>
<title>CRVSTVLA - SOV II</title>
<?php 
   include "css.inc";
   include "meta.inc.php";   
?>
</head>
<body>
<p class="titre">
QVIS QVEM AMAT ?
</p>
<?php
if (isset( $_POST["sententia"])) 
    $priorsent = $_POST["sententia"]; 
if (isset($priorsent)) {
    echo "prior sententia : ".$priorsent.$alinea;
    echo "gallice : ".gallice($priorsent).$alinea;
    $respS = $_POST["respS"];
    $respO = $_POST["respO"];
    //echo "<br>sujet : $sujet, objet : $objet.<br>";
    $recte = ($sujet == $respS && $objet == $respO);
    if ($recte)
        echo "<div class=\"juste\">RECTE !</div>"; 
    else 
        echo "<div class=\"faux\"> Errauisti. Respondisti 
              $respS $verbe $respO.</div>";
    include "session.php.html";
} else {
   $_SESSION['prius'] = 0;
   $_SESSION['consec'] = 0;
}
?>
</p>
<p class="question">
   <?php 
   $sententia = sent();
   echo $sententia;
   ?> 
</p>
<form method="post">
<p class="question">
<?php


echo "<select name=\"respS\">\n";
$prim = 1;
foreach ($nominaF as $el) {
   echo "<option value=\"$el\"";
   if ($prim) {
      echo " selected";
      $prim = 0;
   }
   echo ">$el</option>\n";
}
echo "</select>\n";

if ($uerbum == "spectat") echo " regarde ";
else echo " aime "; 

echo "<select name=\"respO\">\n";
$prim = 1;
foreach ($nominaF as $el) {
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
