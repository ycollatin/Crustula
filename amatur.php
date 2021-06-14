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
$feminae = array(
    "Fadilla",
    "Seuera",
    "Supera",
    "Crispina",
    "Clara",
    "Longina",
    "Lucilla",
    "Drusilla",
    "Proba",
    "Faustina",
    "Paula",
    "Lepida",
    "Marcella"
);

$mares = array(
    "Appius",
    "Aulus",
    "Caius",
    "Cnaeus",
    "Decimus",
    "Lucius",
    "Mamercus",
    "Manius",
    "Marcus",
    "Numerius",
    "Publius",
    "Quintus",
    "Sextus",
    "Septimus",
    "Spurius"
);

function sorsColl($c) {
    if (count($c) == 1) return $c[0];
   return $c[mt_rand(0, count($c)-1)];   
}

function accus($n) {
    $pro[0] = "/a$/"; $dic[0] = "am";
    $pro[1] = "/us$/"; $dic[1] = "um";
    $red = preg_replace($pro, $dic, $n);
    return $red;
}

function sententia() {
    global $subiectus, $obiectus, $feminae, $mares;
    if (sorsColl(array('f','m')) == 'f') {
        $subiectus = sorsColl($feminae);
        $obiectus = accus(sorsColl($mares));
    } else {
        $obiectus = accus(sorsColl($feminae));
        $subiectus = sorsColl($mares);
    }
    $red = array($subiectus, $obiectus, "amat");
    shuffle($red);
    return implode(' ', $red);
}

$sententia = sententia();

function lemma($f) {
   $pro[0] = "/am$/"; $dic[0] = "a";
   $pro[1] = "/um$/"; $dic[1] = "us";
   $pro[2] = "/o$/";  $dic[2] = "us";
   $red = preg_replace($pro, $dic, $f);
   return $red;
}

$amatus = '<input type="text" name="rs">'; 
$amans = 'a/ab <input type="text" name="ra">'; 

$partes = array($amatus, $amans, "amatur");
shuffle($partes);
$quaestio = implode(" ", $partes);

function abl($l) {
   $pro = "/us$/"; $dic = "o";
   $red = preg_replace($pro, $dic, $l);
   return $red;
}

function recte($rs, $ra, $s) {
    global $solutio;
    $rs  = trim($rs); $ra = trim($ra);
    if (preg_match("/(\w*us)\b/", $s, $partes)) {
        $amansS = $partes[1];
        preg_match("/(\w*am)\b/", $s, $partes);
        $amatusS = $partes[1];
    } else {
       preg_match("/(\w*a)\b/", $s, $partes);
       $amansS = $partes[1];
       preg_match("/(\w*um)\b/", $s, $partes); 
       $amatusS = $partes[1];
    }
    $amatusS = lemma($amatusS);
    $amansR  = lemma($ra);
    $amatusR = $rs;
    $solutio = $amatusS.' a/ab '.abl($amansS).' amatur.';
    //echo "--amansS : $amansS ; amansR : $amansR ; amatusS : $amatusS ; 
    //      amatusR : $amatusR--";
    $amansR = ucwords(strtolower($amansR));
    $amatusR = ucwords(strtolower($amatusR));
    if ($amansS == $amansR && $amatusS == $amatusR) return 1;
    return 0;
}
session_start();
?>
<html>
<head>
<title>CRVSTVLA - AMATVR</title>
<?php 
   include "css.inc";
   include "meta.inc.php";
?>
</head>
<body>
<p class="titre">
QVIS QVEM AMAT ? - LIBER II
</p>
<?php
if(isset($_POST["sententia"])) {
   $priorsent = $_POST["sententia"]; 
   echo "prior sententia : $priorsent $alin";
   $rs = $_POST["rs"];
   $ra = $_POST["ra"];
   //echo "recte -".recte($rs, $ra, $priorsent)."-$alin";
   $recte = recte($rs, $ra, $priorsent);
   if ($recte)
	   echo "<div class=\"juste\">RECTE !</div>"; 
   else {
	   echo "$solutio $alin";
	   echo "<div class=\"faux\"> Errauisti. Respondisti $rs a/ab $ra amatur."; 
   }
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
<?php echo "$quaestio."; 
echo "<input type=\"submit\" value=\" Num recte dixi ? \">\n";
echo "<input type=\"hidden\" name=\"sententia\" value=\"$sententia\">";
?> 
</p>
</form>
<p class="redi"><a href='./'>reditus</a> <a href="gpl.html" target="gpl">Licence GPL</a></p>
</body>
</html>
