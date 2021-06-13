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
$amo = array(
     "amaui"=>"j'aimai",
     "amauisti"=>"tu aimas",
     "amauit"=>"elle/il aima",
     "amauimus"=>"nous aimÃ¢mes",
     "amauistis"=>"vous aimÃ¢tes",
     "amauerunt"=>"elles/ils aimÃ¨rent",
     "amo"=> "j'aime",
     "amas"=>"tu aimes",
     "amat"=>"elle/il aime",
     "amamus"=>"nous aimons",
     "amatis"=>"vous aimez",
     "amant"=>"elles/ils aiment"
);

$aimer =  array_flip($amo);    

function sorsColl($c) {
    if (count($c) == 1) return $c[0];
   return $c[mt_rand(0, count($c)-1)];   
}

if (sorsColl(array('l','g')) == 'l'){
   $quaestio = $amo[array_rand($amo)];
   $latine = 1;
} else $quaestio = $aimer[array_rand($aimer)];

$decet = array("/^(elle\s+|il\s+|il\W+elle\s+)/");
$decent = array("/^(elles\s+|ils\s+|ils\W+elles\s+)/");
session_start();
?>
<html>
<head>
<title>CRVSTVLA - AMAVI, AMO</title>
<?php 
   include "css.inc";
   include "meta.inc.php";
?>
</head>
<body>
<p class="titre">
AMAVI, AMO
</p>
<?php
if(isset($_POST["priorsent"])) {
    $priorsent = $_POST["priorsent"];
    $priorsent = stripslashes($priorsent);
    $r = $_POST["r"];
}
if (isset($r)) {
    $r = stripslashes($r);
    $resp = $r;
    $r = strtolower(trim($r));

    echo "prior sententia : $priorsent $alin";
    //echo "recte -".recte($rs, $ra, $priorsent)."-$alin";
    if (in_array($priorsent, $amo))
	    $s = $aimer[$priorsent];
    else $s = $amo[$priorsent];    

    $decet = "/^(elle\s+|il\s+|il\W+elle\s+)/";
    $r = preg_replace($decet, "elle/il ", $r);
    $decent = "/^(elles\s+|ils\s+|ils\W+elles\s+)/";
    $r = preg_replace($decent, "elles/ils ",$r);
    $recte = ($s == $r); 
    if ($recte)
	    echo "<div class=\"juste\">RECTE !</div>"; 
    else {
	    echo " : $s$alin";
	    echo "<div class=\"faux\"> Errauisti. Respondisti $resp$alin"; 
    }
    include "session.php.html";
} else {
   $_SESSION['prius'] = 0;
   $_SESSION['consec'] = 0;
}

?>
<p class="question">
<?php echo $quaestio
?>
</p>
<form method="post">
<p class="question">
<?php
echo "<input type=\"text\" name=\"r\">&nbsp;";
echo "<input type=\"submit\" value=\" Num recte dixi ? \">\n";
echo "<input type=\"hidden\" name=\"priorsent\" value=\"$quaestio\">";
?> 
</p>
(Traduire le parfait par le passÃ© simple)<br> 
</form>
<p class="redi"><a href='./'>reditus</a> <a href="gpl.html" target="gpl">Licentia GPL</a></p>
</body>
