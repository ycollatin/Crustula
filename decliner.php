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
agenda
   deabus, filiabus, loca, turrim !
*/
include "decl.php";
$alin = "<br>\n";

if(isset($_POST["priorQ"]))
    $priorQ = $_POST["priorQ"];
if (isset($priorQ)){
   $eclats = explode("|", $priorQ);
   $niveau = $eclats[4];
}   
if (!isset($niveau))
  $niveau = 1;

// liste des modèles en fonction du niveau
$listeM = array_slice($modeles, 0, $niveau);

// tirage du modèle et du lemme;
$m = sorsM($listeM);
$l = sorsN($m);

// tirage de la morpho
$n = sorsNb();
$c = sorsK();

function quaest($lemma, $casus, $numerus) {
   return $lemma[4]."<br>\n$casus $numerus ?";
}

$quaestio = quaest($l, $c, $n);

session_start();
?>
<html>
<head>
<title>CRVSTVLA - DECL</title>
<?php 
   include "css.inc";
   include "meta.inc.php";
?>
</head>
<body>
<p class="titre">
DECL
</p>
<?php
if (!empty($priorQ)){
   // lemmam extrahere :
   $lemma = $eclats[0];
   $modele = $eclats[1];
   $casus = $eclats[2];
   $numerus = $eclats[3];
   $priorN = $eclats[4];
   $linea = linea($lemma, $modele);
   //function decline($l, $r, $m, $g, $c, $n) {
   // array("altitudo","altitudin","miles","f","dinis, f. : altitude, hauteur"),
   $sol = decline($lemma, $linea[1], $modele, $linea[3], $casus, $numerus);
   $resp = trim($_POST["resp"]);
   echo "Prior quaestio : "
      .$lemma.", ".quaest($linea, $casus, $numerus). " solutio : $sol";
   $recte = $resp == $sol;
   if ($recte)
	   echo "<div class=\"juste\">RECTE !</div>"; 
   else 
	   echo "<div class=\"faux\"> Errauisti. Respondisti : $resp</div>";
   include "session.php.html";
   if ($_SESSION['consec'] == 7 && $niveau < 10) {
       $niveau++;
       $_SESSION['consec'] = 0;
   } elseif ($_SESSION['consec'] == 0 && $niveau > 0) $niveau--;
} else {
   $_SESSION['prius'] = 0;
   $_SESSION['consec'] = 0;
}
echo "$alin niveau $niveau $alin";
?>
<p class="question">
<?php
    echo "$quaestio $alin";
?>
</p>
<p>
<form class="question" method="post">
<input class="question" type="text" name="resp">&nbsp;
<input type="submit" value="Num recte dixi ?">
<input type="hidden" value="<?php echo "$l[0]|$m|$c|$n|$niveau" ?>" name="priorQ">
</p>
</form>
<p class="redi"><a href='./'>reditus</a> <a href="gpl.html" target="gpl">Licence GPL</a></p>
</body>
</html>
