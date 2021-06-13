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
$alinea = "<br/>\n";

$nominM = array(
   "Aemilius",
   "Eupalamus",
   "Publius",
   "Aulus",
   "Marcus");

$nominF = array(
   "Aemilia",
   "Iulia",
   "Lucia",
   "Lucretia",
   "Sempronia");

$nomina = array_merge($nominF, $nominM);

function accM($n) {
   return preg_replace("/s$/", "m",  $n);
}

function accF($n) {
   return $n.'m';
}

function gallice($s) {
   // in tabulam uertere sententiam :
   global $sujet, $objet;
   $s = preg_replace("/\W$/", "", $s);
   $coll = explode(" ", $s);
   foreach($coll as $uer) { 
       //echo '*'.$uer.'*'.$alinea;
       if ($uer == "amat")
           $verbe = "aime";
       elseif (preg_match("/m$/", $uer))
           $objet = $uer;
       else $sujet = $uer;
   }
   $objet = preg_replace("/um$/","us",$objet);
   $objet = preg_replace("/am$/","a",$objet);
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
    $obiectus = accF($lemma_obiecti);
} else {
    $subiectus = sorsColl($nominF);
    $lemma_obiecti = sorsColl($nominM);
    $obiectus = accM($lemma_obiecti);
}

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
    global $subiectus, $lemma_obiecti;
    $p = array(
      "$subiectus aime $lemma_obiecti.",
      "$lemma_obiecti aime $subiectus.");
    shuffle ($p);
    return $p; 
}

session_start(); 
echo "<html>\n"
	."<head>\n"
	."<title>CRVSTVLA - SOV</title>\n"
	."<link rel=\"stylesheet\" href=\"crustula.css\" type=\"text/css\">\n";
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
   	echo "gallice : ".$gallice.$alinea;
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

