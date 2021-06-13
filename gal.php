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

$fonctions = array(
    "sujet du verbe",
    "COD du verbe",
    "attribut du sujet");

$cas = array(
    "au nominatif",
    "à l'accusatif");

$nominF = array(
   "Aemilia",
   "Iulia",
   "Lucia",
   "Lucretia",
   "Sempronia");

$attF = array(
   "mon_amie",
   "ma_s&oelig;ur",
   "une_voisine",
   "sa_fille",
   "une_inconnue");

$nominM = array(
   "Aemilius",
   "Eupalamus",
   "Publius",
   "Aulus",
   "Marcus");

$attM = array(
   "son_ami",
   "mon_frère",
   "un_Gaulois",
   "le_consul",
   "un_marin");


$nomina = array_merge($nominF, $nominM);

function sorsColl($c) {
    if (count($c) == 1) return $c[0];
   return $c[mt_rand(0, count($c)-1)];   
}
// récupération de la phrase précédente et de la réponse
if (isset($_REQUEST['phprec'])) {
    $phprec = $_POST["phprec"];
    $motprec = $_POST["motprec"];
    $respF = stripslashes($_POST["respF"]);
    $respK = stripslashes($_POST["respK"]);
    // solution
    $eclats = explode(" ", $phprec);
    if ($motprec == $eclats[0]) {
	$solF = $fonctions[0]; 
	$solK = $cas[0];
    }
    elseif ($eclats[1] == 'est') {
        $solF = $fonctions[2];
	$solK = $cas[0];
    } else {
        $solF = $fonctions[1];
        $solK = $cas[1];
    }

   $recte = ($respF == $solF) && ($respK == $solK);
}

// décider du sexe du sujet
$sexus = sorsColl(array('m','f'));
if ($sexus == 'm') {
    $sujet = sorsColl($nominM);
} else {
    $sujet = sorsColl($nominF);
}

// tirer le type de phrase
$type = sorsColl(array('svo','sva'));
if ($type == 'svo') {
    if ($sexus == 'f') $objet = sorsColl($nominM + $attM); 
    else $objet = sorsColl($nominF + $attF);
    $phrase = "$sujet aime $objet";
} else {
    if ($sexus == 'f') $attribut = sorsColl($attF);
    else $attribut = sorsColl($attM);
    $phrase = "$sujet est $attribut";
}

session_start(); 
?>
<html>
<head>
<title>CRVSTVLA - SOV</title>
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
if (isset($phprec)) {
    //$priorsent = $_POST["sententia"]; 
    echo "Phrase précédente : ".$phprec.$alinea;
    echo "$motprec est $solF ; il serait en latin au $solK";
    if ($recte)
	    echo "<div class=\"juste\">JUSTE !</div>"; 
    else 
	    echo "<div class=\"faux\"> Faux. Tu as répondu $respF, $respK.</div>";
    include "session.php.html";
} else {
   $_SESSION['prius'] = 0;
   $_SESSION['consec'] = 0;
}
?>
</p>
<p class="question">
   <?php 
   $p = str_replace("_"," ",$phrase);
   echo $p;
   ?> 
</p>
<form method="post">
<p class="question">
<?php
// tirage de la question
$eclats = explode(" ", $phrase);
$mot = $eclats[sorsColl(array(0,2,2))];
$mot = str_replace("_", " ", $mot);
echo "$mot est ";

echo "<select name=\"respF\">\n";
$prim = 1;
foreach ($fonctions as $el) {
   echo "<option value=\"$el\"";
   if ($prim) {
      echo " selected";
      $prim = 0;
   }
   echo ">$el</option>\n";
}
echo "</select>\n";

echo ". En latin, ce mot serait donc ";

echo "<select name=\"respK\">\n";
$prim = 1;
foreach ($cas as $el) {
   echo "<option value=\"$el\"";
   if ($prim) {
      echo " selected";
      $prim = 0;
   }
   echo ">$el</option>\n";
}
echo "</select>\n";

echo "<input type=\"submit\" value=\" Num recte dixi ? \">\n";
echo "<input type=\"hidden\" name=\"phprec\" value=\"$phrase\">";
echo "<input type=\"hidden\" name=\"motprec\" value=\"$mot\">";
?>
</p>
</form>
<p class="redi"><a href='./'>reditus</a> <a href="gpl.html" target="gpl">Licence GPL</a></p>
</body>
</html>
