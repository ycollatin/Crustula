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
    "absum, abes, abesse, afui : être absent",
    "ago, is, ere, egi, actum : faire",
    "cupio, is, ere, cupiui, cupitum : désirer",
    "incipio, is, ere, incepi, inceptum : commencer",
    "contemno, is, ere, contempsi, contemptum : mépriser",
    "dico, is, ere, dixi, dictum : dire",
    "expedio, is, ire, iui, itum : délivrer, tirer de",
    "eludo, is, ere, elusi, elusum : éviter, tromper",
    "laudo, as, are : louer, féliciter",
    "mitto, is, ere, misi, missum : envoyer",
    "teneo, es, ere, tenui, tentum : retenir",
    "tollo, is, ere, sustuli, sublatum : enlever",
    "uenio, is, ire, ueni, uentum : venir",
    "uideo, es, ere, uidi, uisum : voir"
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
       case 'as,': $m = 'amo'; break;
       case 'es,': $m = 'moneo'; break;
       case 'is,': {
           if ($partes[2] == "ire,") $m = "audio";
	   elseif (preg_match("/(io)\,$/", $partes[0]))
	       $m = "capio";
	   else $m = "lego"; 
	   break;
       }
       default: $m = 'sum';
   }
   return $m;
}

$selectM = array(
    'sum','amo','moneo','lego','capio','audio');
shuffle($selectM);

if(isset($_POST["priorQ"])) {
    $priorQ = $_POST["priorQ"];
    $resp =  $_POST["resp"];
    $sol = sol($priorQ);
}
session_start();
?>
<html>
<head>
<title>CRVSTVLA - SVM, AMO, MONEO, LEGO...</title>
<?php 
   include "css.inc";
   include "meta.inc.php";   
?>
</head>
<body>
</body>
<p class="titre"> SVM, AMO, MONEO, LEGO...</p>
<?php
if (isset($priorQ)){
   echo "prior quaestio : $priorQ : modèle $sol $alin";
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
modèle&nbsp;
<?php
echo "<select name=\"resp\">\n";
$prim = 1;
foreach ($selectM as $el) {
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
