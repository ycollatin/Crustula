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
    "arbor, oris, f. : arbre",
    "campus, i, m. : plaine, champ",
    "otium, i, n. : repos",
    "ceruus, i, m. : cerf",
    "coruus, i, m. : corbeau",
    "cornu, us, n. : corne",
    "crus, cruris, n. : jambe, patte",
    "effigies, ei, f. : image",
    "fenestra, ae, f. : fenêtre",
    "fons, fontis, m. : source, fontaine",
    "luctus, us, m. : chagrin, détresse, deuil",
    "morsus, us, m. : morsure",
    "narratio, onis, f. : histoire; fable",
    "paenitentia, ae, f. : regret, repentir",
    "silua, ae, f. : forêt",
    "uerbum, i, n. : parole"
);

function sorsColl($c) {
    if (count($c) == 1) return $c[0];
    $red = $c[array_rand($c)]; 
    return $red;
}

$quaestio = sorsColl($lexicum);

function sol($q) {
   $partes = explode(' ', $q);
   switch ($partes[1]) {
       case 'i,': $d = 'deuxième'; break;
       case 'ae,': $d = 'première'; break;
       case 'ei,': $d = 'cinquième'; break;
       case 'us,': $d = 'quatrième'; break;
       default: $d = 'troisième';
   }
   switch ($partes[2]) {
       case 'f.': $g = 'féminin'; break;
       case 'm.': $g = 'masculin'; break;
       case 'n.': $g = 'neutre'; 
   }
   return "$d déclinaison, $g";
}

$selectD = array(
    'première','deuxième','troisième','quatrième','cinquième');
$selectG = array('féminin','masculin','neutre');    

if(isset($_POST["priorQ"])) {
    $priorQ = $_POST["priorQ"];
    $respD =  $_POST["respD"];
    $respG =  $_POST["respG"];

    $sol = sol($priorQ);
    $resp = "$respD déclinaison, $respG";
}
session_start();
?>
<html>
<head>
<title>CRVSTVLA - DECLINATIO (I)</title>
<?php 
   include "css.inc";
   include "meta.inc.php";   
?>
</head>
<body>
</body>
<p class="titre"> DECLINATIO </p>
<?php
if (isset($priorQ)){
   echo "prior quaestio : $priorQ : $sol $alin";
   $recte = ($resp == $sol);
   if ($recte)
	   echo "<div class=\"juste\">RECTE !</div>"; 
   else 
	   echo "<div class=\"faux\"> Errauisti. Respondisti $resp.</div>\n";
   include "session.php.html";
} else {
   $_SESSION['prius'] = 0;
   $_SESSION['consec'] = 0;
}
?>
</p>
<p class="question">
   <?php echo $quaestio; ?> 
</p>
<form method="post">
<p class="question">
<?php
echo "<select name=\"respD\">\n";
$prim = 1;
foreach ($selectD as $el) {
   echo "<option value=\"$el\"";
   if ($prim) {
      echo " selected";
      $prim = 0;
   }
   echo ">$el</option>\n";
}
echo"</select>";
echo ' déclinaison, ';
echo "<select name=\"respG\">\n";
$prim = 1;
foreach ($selectG as $el) {
   echo "<option value=\"$el\"";
   if ($prim) {
      echo " selected";
      $prim = 0;
   }
   echo ">$el</option>\n";
}
echo"</select>";

echo "<input type=\"submit\" value=\" Num recte dixi ? \">\n";
echo "<input type=\"hidden\" name=\"priorQ\" value=\"$quaestio\">";
?>
</p>
</form>
<p class="redi"><a href='./'>reditus</a> <a href="gpl.html" target="gpl">Licentia GPL</a></p>
</body>
</html>
