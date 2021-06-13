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
$version = array(
     "uehor"=>"je suis transporté",
     "ueheris"=>"tu es transporté(e)",
     "uehitur"=>"il/elle est transporté(e)",
     "uehimur"=>"nous sommes transporté(e)s",
     "uehimini"=>"vous êtres transporté(e)s",
     "uehuntur"=>"elles/ils sont transporté(e)s",
     "ueho"=>"je transporte",
     "uehis"=>"tu transportes",
     "uehit"=>"elle/il transporte",
     "uehimus"=>"nous transportons",
     "uehitis"=>"vous transportez",
     "uehunt"=>"ils transportent",
     );
$theme =  array_flip($version);    

function sorsColl($c) {
    if (count($c) == 1) return $c[0];
   return $c[mt_rand(0, count($c)-1)];   
}

$sens = sorsColl(array('t','v'));
if ($sens == 't')     
   $quaestio = $theme[array_rand($theme)];
else $quaestio = $version[array_rand($version)]; 
session_start(); 
?>
<html>
<head>
<title>CRVSTVLA - VEHO</title>
<?php 
   include "css.inc";
   include "meta.inc.php";
?>
</head>
<body>
<p class="titre">
VEHO, VEHOR
</p>
<?php
if(isset($_POST["priorsent"]))
    $priorsent = $_POST["priorsent"];
if (isset($priorsent)){
   $priorsens = $_POST["priorsens"];
   $resp = $_POST["resp"];
   $resp = strtolower(trim($resp));
   if ($priorsens == 't') 
	   $sol = $version[$priorsent];
   else $sol = $theme[$priorsent];

   echo "prior sententia : $priorsent, $sol $alin";
   $recte = ($resp == $sol);
   if ($recte)
	   echo "<div class=\"juste\">RECTE !</div>"; 
   else {
	   echo "$solutio $alin";
	   echo "<div class=\"faux\"> Errauisti. Respondisti $resp.</div>"; 
   }
   include "session.php.html";
} else {
   $_SESSION['prius'] = 0;
   $_SESSION['consec'] = 0;
}
?>
<p class="question">
<?php echo $quaestio; ?>
</p>
<form method="post">
<p class="question">
<?php
if ($sens == "t") {
    echo "<select name=\"resp\">\n";
    $prim = 1;
    foreach ($version as $el) {
       echo "<option value=\"$el\"";
        if ($prim) {
           echo " selected";
           $prim = 0;
        }
        echo ">$el</option>\n";
       }
    echo "</select>\n";
} else {
   echo "<input type=\"text\" name=\"resp\">";
}
echo "<input type=\"submit\" value=\" Num recte dixi ? \">\n";
echo "<input type=\"hidden\" name=\"priorsent\" value=\"$quaestio\">";
echo "<input type=\"hidden\" name=\"priorsens\" value=\"$sens\">";
?> 
</p>
</form>
<p class="redi"><a href='./'>reditus</a> <a href="gpl.html" target="gpl">Licentia GPL</a></p>
</body>
</html>
