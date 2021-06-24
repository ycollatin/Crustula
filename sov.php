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

include_once 'i18n.inc.php';


$declinatio = N_("si non declinatione neque sermonem transferre");
$declinatio_est = T_($declinatio) != $declinatio;

$alinea = "<br/>\n";

$nominM = array(
    N_("Aemilius"),
    N_("Eupalamus"),
    N_("Publius"),
    N_("Aulus"),
    N_("Marcus"));

$nominF = array(
    N_("Aemilia"),
    N_("Iulia"),
    N_("Lucia"),
    N_("Lucretia"),
    N_("Sempronia"));

$accusM = array(
   N_("Aemilium"),
   N_("Eupalamum"),
   N_("Publium"),
   N_("Aulum"),
   N_("Marcum"));

$accusF = array(
    N_("Aemiliam"),
    N_("Iuliam"),
    N_("Luciam"),
    N_("Lucretiam"),
    N_("Semproniam"));

$nomina = array_merge($nominF, $nominM);
$accus = array_merge($accusF,$accusM);
$nominADaccus=array();
$accusADnomin=array();

function accusatiuus_est($n){
    global $accus;
    return in_array($n, $accus, true);
}
             
for($i=0; $i < count($nomina); $i++){
    $nominADaccus[$nomina[$i]] = $accus[$i];
    $accusADnomin[$accus[$i]] = $nomina[$i];
}

function gallice($s) {
    // in tabulam uertere sententiam :
    global $sujet, $objet, $accusADnomin, $declinatio_est;
    $s = preg_replace("/\W$/", "", $s);
    $coll = explode(" ", $s);
    foreach($coll as $uer) { 
        //echo '*'.$uer.'*'.$alinea;
        if ($uer == "amat")
            $verbe = T_("aime");
        elseif (accusatiuus_est($uer))
            $objet = $uer;
        else $sujet = $uer;
    }
    if ($declinatio_est){
        $sujet = T_($sujet);
        $objet = T_($objet);
    } else {
        $objet = $accusADnomin[$objet];
    }
    return "$sujet $verbe $objet."; 
}

function sorsColl($c) {
    if (count($c) == 1) return $c[0];
   return $c[mt_rand(0, count($c)-1)];   
}

// décider du sexe du sujet
$sexus = array('m','f');
if (sorsColl($sexus) == 'm') {
    $subiectus = sorsColl($nominM);
    $lemma_obiecti = sorsColl($nominF);
} else {
    $subiectus = sorsColl($nominF);
    $lemma_obiecti = sorsColl($nominM);
}
$obiectus = $nominADaccus[$lemma_obiecti];

function sent() {
    global $subiectus, $obiectus, $alinea;
    $c = array ($subiectus, $obiectus, 'amat');
    shuffle($c);
    return implode (" ", $c) . '.';
}

function IIPropositiones()
{
   // Potius quam nomen quaerere inter multa,
   // II sententias proponere
    global $declinatio_est;
    global $subiectus, $lemma_obiecti, $obiectus;
    global $accusADnomin, $nominADaccus;
    if ($declinatio_est){
        $s1 = T_($subiectus);
        $o1 = T_($obiectus);
        $s2 = T_($accusADnomin[$obiectus]);
        $o2 = T_($nominADaccus[$subiectus]);
    } else { // non est declinatio
        $s1 = $subiectus;
        $o1 = $lemma_obiecti;
        $s2 = $lemma_obiecti;
        $o2 = $subiectus;
    }
    $p = array(
        "$s1 " . T_("aime") . " $o1.",
        "$s2 " . T_("aime") . " $o2.");
    shuffle ($p);
    return $p; 
}

session_start(); 
echo "<html>\n"
	."<head>\n"
	."<title>CRVSTVLA - SOV</title>\n"
	."<link rel=\"stylesheet\" href=\"crustula.css\" type=\"text/css\">\n"
    ."<link rel=\"icon\" href=\"favicon.ico\">\n";
//include "css.inc";
include "meta.inc.php";   
echo "</head>\n"
	."<body>\n"
	."<p class=\"titre\">\n"
	."QVIS QVEM AMAT ?\n"
	."</p>\n";

if (isset($_REQUEST['sententia']))
    $priorsent = $_POST["sententia"]; 
if (isset($priorsent)){
   	echo "prior sententia : ".$priorsent.$alinea;
   	$gallice = gallice($priorsent);
   	echo T_("gallice :")." ".$gallice.$alinea;
   	$resp = $_POST["resp"];
   	//echo "<br>sujet : $sujet, objet : $objet.<br>";
   	$recte = $resp == $gallice;
   	if ($recte) echo "<div class=\"juste\">RECTE !</div>"; 
   	else echo "<div class=\"faux\"> Errauisti. Respondisti $resp</div>";
   	include 'session.php.html';
} else {
  	$_SESSION['prius'] = 0;
  	$_SESSION['consec'] = 0;
}
echo "</p>\n" 
	."<p class=\"question\">\n";
$sententia = sent();
echo $sententia;
echo "</p>\n"
	."<form method=\"post\">\n"
	."<p class=\"question\">\n";
$trans = IIPropositiones();
foreach ($trans as $p) 
{
    echo "<input type=\"submit\" name= \"resp\" value=\"$p\" class=\"question\"><br /><br />\n";
}
echo "<input type=\"hidden\" name=\"sententia\" value=\"$sententia\">";
?>
</form>
<p class="redi"><a href='./'>reditus</a> <a href="gpl.html" target="gpl">Licentia GPL</a></p>
</body>
</html>

