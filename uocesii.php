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
$lexicum = "lexica/thema2.php";
include "meta.inc.php";
include "incrementum.php";
include $lexicum;

$alin = "<br>\n";

// récupérer l'état des connaissances
if (isset($_POST["cognita"]))
    $cog = $_POST["cognita"];
if (!isset($cog))
   $cognita = array(0);
else $cognita = explode("-", $cog);

//debog
//$cognita = array($maximum, $maximum, 0);

function facQ($gallice) {
    return "Quomodo latine dicitur : $gallice ?";
}

function solutio($gal) {
  global $bini;
  foreach($bini as $l)
     if (stripslashes($l[1]) == $gal)
         return $l[0];
}        
?>
<html>
<head>
<title>CRVSTVLA - VOCES II</title>
<?php 
   include "css.inc";
   include "meta.inc.php";
?>
</head>
<body>
<p class="titre">
VOCES II
</p>
<?php
if(isset($_POST["priorQ"])) {
   $gal = $_POST["priorQ"];
   //$gal = stripslashes($priorQ);
   $gal = stripslashes($gal);
   $priorQ = facQ($gal);

   $r = $_POST["r"];
}   
if (isset($r)) {
    $resp = $r;
    $r = stripslashes($r);
    $r = strtolower(trim($r));
    $s = solutio($gal);

    echo "prior quaestio : $priorQ$alin";
    echo "solutio : $s$alin";
    $recte = ($s == $r); 
    if ($recte) {
	    echo "<div class=\"juste\">RECTE !</div>"; 
            $cognita = succes($lexicum, $cognita, $gal); 
    } else {
	    echo "<div class=\"faux\"> Errauisti. Respondisti $resp </div>$alin"; 
            $cognita = echec($lexicum, $cognita, $gal);
    }
    $facta = bilan($cognita);
    $discenda = count($bini)-$facta;
    echo "$facta cognita, $discenda discenda.";
    if ($discenda == 0) echo " Omnia uerba nouisti.";
}
$linea = Qincr($lexicum, $cognita);
$latine = $linea[0];
$gallice = stripslashes($linea[1]);
$quaestio = facQ($gallice);
?>
<p class="question">
<?php echo $quaestio ?>
</p>
<form method="post">
<p class="question">
<?php
  echo "<input class=\"question\" type=\"text\" name=\"r\">&nbsp;";

echo "<input type=\"submit\" value=\" Num recte dixi ? \">\n";
echo "<input type=\"hidden\" name=\"priorQ\" value=\"$gallice\"\n>";
$cog = implode("-", $cognita);
echo "<input type=\"hidden\" name=\"cognita\" value=\"$cog\">";
?> 
</p>
</form>
<p class="redi"><a href='./'>reditus</a> <a href="gpl.html" target="gpl">Licentia GPL</a></p>
<?php
// debog
/*echo $alin."------------------".$alin;
for ($i=0;$i<count($cognita);$i++)
   echo decbin($cognita[$i]).'-';
*/
?>
</body>
