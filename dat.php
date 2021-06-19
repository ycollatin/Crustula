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
srand ((double) microtime() * 10000000);
if (isset($_POST['sententia'])) {
    $priorsent = $_POST["sententia"]; 
    $respN = $_POST["respN"];
    $respA = $_POST["respA"];
    $respD = $_POST["respD"];
}

$alin = "<br>\n";
$lexicum = array(
  "Aemilia",
  "Cornelia",
  "Lucretia",
  "Sempronia",
  "Tullia",
  "Aulus",
  "Brutus",
  "Marcus",
  "Publius",
  "Titus");

function acc($n) {
    $pro[0] = "/a$/";
    $dic[0] = 'am';
    $pro[1] = "/us$/";
    $dic[1] = 'um';
    $r = preg_replace($pro, $dic, $n);
    return $r;
}

function dat($n) {
    $pro[0] = "/a$/";
    $dic[0] = 'ae';
    $pro[1] = "/us$/";
    $dic[1] = 'o';
    $r = preg_replace($pro, $dic, $n);
    return $r;
}    

function sorsColl($c) {
    if (count($c) == 1) return $c[0];
   return $c[mt_rand(0, count($c)-1)];   
   //return array_rand($c);
}

function sorsS() {
    global $lexicum;
    $facsimile = $lexicum;
    $fors = array_rand($facsimile); 
    $nomin = $facsimile[$fors];
    unset($facsimile[$fors]);  
    $fors = array_rand($facsimile); 
    $datiu = dat($facsimile[$fors]);
    unset($facsimile[$fors]);  
    $accus = acc($facsimile[array_rand($facsimile)]); 
    $coll = array($nomin, $accus, $datiu, 'commendat');
    shuffle($coll);
    return implode(' ', $coll) . '.';
}

function morph($f) {
    //echo "morph -$f-$alin";
    if (preg_match("/am$/", $f)>0) return 'acc';
    elseif (preg_match("/ae$/", $f)>0) return 'dat';
    elseif (preg_match("/um$/", $f)>0) return 'acc';
    elseif (preg_match("/o$/", $f)>0) return 'dat';
    elseif (preg_match("/us$/", $f)>0) return 'nom';
    elseif (preg_match("/a$/", $f)>0) return 'nom';
}

function lemma($f) {
    $pro[0] = "/am$/";   $dic[0] = 'a';
    $pro[1] = "/ae$/";   $dic[1] = 'a';
    $pro[2] = "/um$/";   $dic[2] = 'us';
    $pro[3] = "/o$/";   $dic[3] = 'us';
    return preg_replace($pro, $dic, $f);
}

function gallice($s) {
   global $sujet, $qui, $aqui;
   $s = substr($s, 0, -1); 
   $eclats = explode(' ', $s);
   foreach($eclats as $e) {
       $m = morph($e);
       if ($m == 'dat') $aqui = lemma($e);
       elseif ($m == 'acc') $qui = lemma($e);
       elseif ($m =="nom") $sujet = $e;
   }
   return "$sujet recommande $qui à $aqui.";
}

$sententia = sorsS();
session_start();
?>
<html>
<head>
<title>CRVSTVLA - DAT</title>
<?php 
   include "css.inc";
   include "meta.inc.php";
?>
</head>
<body>
<p class="titre">
QVIS CVI QVEM COMMENDAT ?
</p>
<?php
if (!empty($priorsent)) {
   echo "prior quaestio : ".$priorsent.$alin;
   echo "gallice : ".gallice($priorsent).$alin;
   //echo "<br>sujet : $sujet, objet : $objet.<br>";
   $recte = ($sujet == $respN && $qui == $respA && $aqui == $respD);
   //if ($sujet == $respN && $qui == $respA && $aqui == $respD)
   if ($recte)
	   echo "<div class=\"juste\">RECTE !</div>"; 
   else 
	   echo "<div class=\"faux\"> Errauisti. "
		   ."Respondisti $respN reccommande $respA à $respD";
   include "session.php.html";
} else {
   $_SESSION['prius'] = 0;
   $_SESSION['consec'] = 0;
}

?>
</div>
<p class="question">
<?php
echo "$sententia </p>";
echo "<form method=\"post\">\n";
echo "<p class=\"question\">\n";
echo "<select name=\"respN\">\n";
$prem = 1;
foreach ($lexicum as $el) {
   echo "<option value=\"$el\"";
   if ($prem) {
      echo " selected";
      $prem = 0;
   }
   echo ">$el</option>\n";
}
echo "</select>\n";

echo " recommande ";

echo "<select name=\"respA\">\n";
$prem = 1;
foreach ($lexicum as $el) {
   echo "<option value=\"$el\"";
   if ($prem) {
      echo " selected";
      $prem = 0;
   }
   echo ">$el</option>\n";
}
echo "</select>\n";

echo " à ";

echo "<select name=\"respD\">\n";
$prem = 1;
foreach ($lexicum as $el) {
   echo "<option value=\"$el\"";
   if ($prem) {
      echo " selected";
      $prem = 0;
   }
   echo ">$el</option>\n";
}
echo "</select>.\n";
echo "<input type=\"submit\" value=\" Num recte dixi ? \">\n";
echo "<input type=\"hidden\" name=\"sententia\" value=\"$sententia\">";
?>
</p>
</form>
</body>
<p class="redi"><a href='./'>reditus</a> <a href="gpl.html" target="gpl">Licentia GPL</a></p>
</html>

