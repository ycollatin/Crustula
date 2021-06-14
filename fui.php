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
$fus = array(
     "fui"=>"je fus",
     "fuisti"=>"tu fus",
     "fuit"=>"elle/il fut",
     "fuimus"=>"nous fûmes",
     "fuistis"=>"vous fûtes",
     "fuerunt"=>"elles/ils furent"
     );
$fui =  array_flip($fus);    

function sorsColl($c) {
    if (count($c) == 1) return $c[0];
   return $c[mt_rand(0, count($c)-1)];   
}

$lingua = sorsColl(array('l','g'));
if ($lingua == 'l')     
   $quaestio = $fui[array_rand($fui)];
else $quaestio = $fus[array_rand($fus)];

session_start();
?>
<html>
<head>
<title>CRVSTVLA - FVI</title>
<?php 
   include "css.inc"; 
   include "meta.inc.php";   
?>
</head>
<body>
<p class="titre">
FVI
</p>
<?php
if (isset($_POST["priorsent"])) {
    $priorsent = $_POST["priorsent"];
    $r = $_POST["r"];
}
if (isset($r)) {
    $r = strtolower(trim($r));
    $resp = $r;

    echo "prior sententia : $priorsent $alin";
    //echo "recte -".recte($rs, $ra, $priorsent)."-$alin";
    if (in_array($priorsent, $fui))
	    $s = $fus[$priorsent];
    else $s = $fui[$priorsent];    

    $decet = "/^(elle\s+|il\s+|il\W+elle\s+)/";
    $r = preg_replace($decet, "elle/il ", $r);
    $decent = "/^(elles\s+|ils\s+|ils\W+elles\s+)/";
    $r = preg_replace($decent, "elles/ils ",$r);
    $recte = ($r == $s);
    if ($recte) 
	    echo "<div class=\"juste\">RECTE !</div>"; 
    else {
	    echo "latine : $s$alin";
	    echo "<div class=\"faux\"> Errauisti. Respondisti $resp"; 
    }
    include "session.php.html";
} else {
   $_SESSION['prius'] = 0;
   $_SESSION['consec'] = 0;
}

?>
<p class="question">
<?php echo $quaestio; 
      echo "</p>\n";
if ($lingua == "l")
    echo '<div class="centre">répondre par le passé simple</div>';
?>
<form method="post">
<p class="question">
<?php
echo "<input type=\"text\" name=\"r\">&nbsp;";
echo "<input type=\"submit\" value=\" Num recte dixi ? \">\n";
echo "<input type=\"hidden\" name=\"priorsent\" value=\"$quaestio\">";
?> 
</p>
</form>
<p class="redi"><a href='./'>reditus</a> <a href="gpl.html" target="gpl">Licence GPL</a></p>
</body>
</html>
