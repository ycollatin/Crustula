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
$latinogallicum = array(
     "ira, ae, f." => "colère",
     "uita, ae, f." => "vie",
     "cura, ae, f." => "soin, souci",
     "fama, ae, f." => "renommée, réputation",
     "gloria, ae, f." => "gloire",
     "turba, ae, f." => "désordre, foule",
     "puella, ae, f." => "jeune fille",
     "aqua, ae, f." => "eau",
     "dominus, i, m." => "maître",
     "deus, i, m." => "dieu",
     "amicus, i, m." => "ami",
     "filius, ii, m." => "fils",
     "equus, i, m." => "cheval",
     "uentus, i, m." => "vent",
     "populus, i, m." => "peuple",
     "oculus, i, m." => "oeil"
);

$latgal =  array(
     "ira" => "colère",
     "uita" => "vie",
     "cura" => "soin, souci",
     "fama" => "renommée, réputation",
     "gloria" => "gloire",
     "turba" => "désordre, foule",
     "puella" => "jeune fille",
     "aqua" => "eau",
     "dominus" => "maître",
     "deus" => "dieu",
     "amicus" => "ami",
     "filius" => "fils",
     "equus" => "cheval",
     "uentus" => "vent",
     "populus" => "peuple",
     "oculus" => "oeil"
);


$gallolatinum =  array_flip($latinogallicum);    
$gallat = array_flip($latgal);

function sorsColl($c) {
    if (count($c) == 1) return $c[0];
   return $c[mt_rand(0, count($c)-1)];   
}
$l = sorsColl(array('l','g'));
if ($l == 'l'){
   $quaestio = $latinogallicum[array_rand($latinogallicum)];
   $latine = 1;
} else $quaestio = $gallolatinum[array_rand($gallolatinum)];

session_start();
?>
<html>
<head>
<title>CRVSTVLA - LEXICVM I</title>
<?php 
   include "css.inc";
   include "meta.inc.php";
?>
</head>
<body>
<p class="titre">
LEXICVM I
</p>
<?php
if (isset($_POST["priorQ"])) {
    $priorQ = $_POST["priorQ"];
    $priorQ = stripslashes($priorQ);
    $r = $_POST["r"];
}
if (isset($r)) {
    $resp = $r;
    $r = stripslashes($r);
    $r = strtolower(trim($r));

    echo "prior quaestio : $priorQ";
    if (in_array($priorQ, $latinogallicum))
	    $s = $gallat[$priorQ];
    else $s = $latinogallicum[$priorQ];    

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
if ($l == 'l')
  echo "<input type=\"text\" name=\"r\">&nbsp;";
else {
   echo "<select name=\"r\">\n";
   $prim = 1;
   shuffle($latinogallicum);
   foreach ($latinogallicum as $el) {
     echo "<option value=\"$el\"";
     if ($prim) {
      echo " selected";
      $prim = 0;
     }
   echo ">$el</option>\n";
}
echo "</select>\n";

}
echo "<input type=\"submit\" value=\" Num recte dixi ? \">\n";
echo "<input type=\"hidden\" name=\"priorQ\" value=\"$quaestio\">";
?> 
</p>
</form>
<p class="redi"><a href='./'>reditus</a> <a href="gpl.html" target="gpl">Licentia GPL</a></p>
</body>
