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
$lat = array(
    "amo",
    "amas",
    "amare",
    "amaui",
    "amatum"
);    

$gal = array(
    "j'aime",
    "tu aimes",
    "aimer",
    "j'ai aimé",
    "aimé, pour aimer");

$selectaL = $lat;
shuffle($selectaL);
$selectaG = $gal;    
shuffle($selectaG);

function sorsColl($c) {
    if (count($c) == 1) return $c[0];
    $red = $c[array_rand($c)]; 
    return $red;
}

$lingua = sorsColl(array('l','g'));
if ($lingua == 'l') {
    $quaestio = sorsColl($lat);
    $eligenda = $selectaG;
} else {
    $quaestio = sorsColl($gal);
    $eligenda = $selectaL; 
}    

if (isset($_POST["priorQ"])) {
    $priorQ = stripslashes($_POST["priorQ"]);
    $resp = stripslashes($_POST["resp"]);

    $langueR = 'l';
    foreach($lat as $el)
        if ($priorQ == $el) $langueR = 'g';
    if ($langueR != 'g') {
            $pos = array_search($priorQ, $gal);
            if (isset($pos)) $sol = $lat[$pos];
    } else {
            $pos = array_search($priorQ, $lat);
            if (isset($pos)) $sol = $gal[$pos];
    }    
}
session_start();
?>
<html>
<head>
<title>CRVSTVLA - TE AMAVI</title>
<?php 
   include "css.inc";
   include "meta.inc.php";   
?>
</head>
<body>
</body>
<p class="titre">
TE AMAVI.
</p>
<?php
if (isset($priorQ)){
   echo "prior sententia : $priorQ - $sol $alin";
   // echo $solutio.$alin;
   //echo "<br>solutio : -$sol-<br>";
   //echo "<br>réponse : -$resp-<br>";
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
echo "<select name=\"resp\">\n";
$prim = 1;
foreach ($eligenda as $el) {
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
