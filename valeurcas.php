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
include "lexica/cas1.php";
$titre = "QVEM CASVM ?";


$alin = "<br>\n";

function sorsColl($c) {
    if (count($c) == 1) return $c[0];
    return $c[mt_rand(0, count($c)-1)];   
}

function trans($ph, $m) { 
   global $aides;
   global $u;
   preg_match('/^(.*)-(.*)-(.*)$/', $ph, $eclats);
   $u = $eclats[2];
   if ($m == 'q')
      return $eclats[1].'...'.$eclats[3];
   if ($m == 'o')
      return $eclats[1].$aides[0].$eclats[3];
}        

function solutio($phl, $uox, $casus, $niveau) {
   global $bini;
   global $i;
   for($i=0; $i<count($bini); $i++) {
         $lin = $bini[$i];
         if ($lin[0] == $phl) { 
            if ($niveau == 1)
               return $lin[2];
             preg_match('/^(.*)-(.*)-(.*)$/', $lin[0], $eclats);
             return $eclats[2];
         }                 
   }
}        

function graisse($sententia) {
   global $u;
   preg_match('/^(.*)-(.*)-(.*)$/', $sententia, $eclats);
   $u = $eclats[2];
   return $eclats[1].'<span class="conseil">'.$u.'</span>'.$eclats[3];
}        

function lacuneA($lin) {
   $lin = str_replace('-', '', $lin);
   $phl = trans($lin, 'o');
   $ecl = explode(' ', $phl);
   $lacune = $ecl[mt_rand(0, count($ecl)-1)]; 
   $lacune = preg_replace('/[,\.]/', '', $lacune); 
   $phl = preg_replace("/$lacune/", '...', $phl, 1);
   $phla = $phl;
   return $phla;
}        

// niveau
if(isset($_POST["niveau"])) {
    $niveau = $_POST["niveau"];
    $status = $_POST["status"];
}
if (!isset($status)) {
   $ch = str_repeat('0', count($bini) + 30-count($bini) % 30);
   $niveau = 1;
} else { 
   // décryptage du status
   $ch = '';
   $lstatus = explode('-', $status);
   foreach ($lstatus as $ecl){
      $checl = decbin(hexdec($ecl));
      $checl = substr($checl, 1);
      $ch .= $checl;
   }
}

session_start();
?>
<html>
<head>
<title>CRVSTVLA - <?php echo $titre ?></title>
<?php 
   include "css.inc";
   include "meta.inc.php";
?>
</head>
<body>
<p class="titre">
<?php 
echo "$titre</p>";
if (isset($_POST['resp'])){
   $priorphl = trim($_POST["priorQ"]);
   // extraire la solution
   $resp = trim($_POST["resp"]);
   for($i=0; $i<count($bini); $i++) {
         $lin = $bini[$i];
         $orig = trans($lin[0], 'q');
         if ($orig == $priorphl) break;
   }
   // débog : changement de niveau
   if ($resp == "plus") {
      $niveau++;
      $ch = str_repeat('0', count($bini) + 30-count($bini) % 30);
   }           
   echo graisse($priorphl).$alin;
   if (!isset($uox)) $uox = '';
   if (!isset($casus)) $casus = '';
   $sol = solutio($priorphl, $uox, $casus, $niveau); 
   echo "Solutio : $sol$alin";
   $recte = strtolower($resp) == strtolower($sol);
   if ($recte) {
      echo "<div class=\"juste\">RECTE !</div>"; 
      // mettre status à jour
      $ch{$i} = '1';
   } else echo "<div class=\"faux\"> Errauisti. Respondisti : $resp</div>";
   include "session.php.html";    
}
// debog
//echo "ch(".strlen($ch).") : *$ch*$alin";

// maj de la liste de questionnement;
$biniq = array();
for ($i=0;$i<count($bini);$i++) 
   if ($ch{$i} == '0') $biniq[] = $bini[$i];
if (count($biniq) == 0) {
   // liste vide : hausser le niveau
   $niveau++;
   $biniq = $bini;
   $ch = str_repeat('0', count($bini) + 30-count($bini) % 30);
}        
echo "$alin niveau $niveau, ". (count($bini) - count($biniq))."/".count($bini);   

// sententiam sortiri 
$p = sorsColl($biniq);
$l = $p[0]; 
$g = $p[1];
$u = $p[2];
$dataM = $p[3];

$afftr = true;

if ($niveau == 1) {
   // 1er niveau : les mots latin et français en gras ; cas demandé. 
   $phla = $l;
   $g = graisse($g);
   $l = graisse($l);
   $q = "À quel cas est \"$u\" ?";
   $aide = ""; 
}
elseif ($niveau == 2) {
   // 2ème niveau : mise en gras du français ; données morpho ; lacune à combler.
   $g = graisse($g);
   $phla = $l;
   $l = trans($l, 'q');
   $q = "Hic scribe uerbum latinum quod deest. ";
   $aide = $dataM; 
}
elseif ($niveau == 3) {
   // 3ème niveau : mise en gras du français ; pas de données, lacune. 
   $phla = $l;
   $l = trans($l, 'q');
   $g = graisse($g);
   $q = "Hic scribe uerbum latinum quod deest. ";
   $aide = ""; 
}        
elseif ($niveau == 4) {
   // 4ème        : plus de traduction. 
   $l = trans($l, 'q');
   $g = "";
   $q = "Hic scribe uerbum latinum quod deest. ";
   $aide = ""; 
}        
else {
   // 5ème        : lacune aléatoire
   $l = lacuneA($l);
   $q = "Hic scribe uerbum latinum quod deest. ";
   $aide = ""; 
}        

echo '<p class="questmin">';
echo "$l</p>$aide$alin$g";
echo "<p class=\"questmin\">$q</p>";
?>
<form method="post">
<p class="question">
<input class="question" type="text" name="resp">&nbsp;
<input type="submit" value="Num recte dixi ?">
<input type="hidden" value="<?php echo $phla ?>" name="priorQ">
<?php
// cryptage du status
unset($lstatus);
$chstatus = '1';
for ($i=0;$i<strlen($ch);$i++) {
   $chstatus .= $ch{$i};
   if (strlen($chstatus) == 31) {
      $lstatus[] = dechex(bindec($chstatus));
      $chstatus = '1';
   }
}
$status = implode ('-', $lstatus);
?>
<input type="hidden" value="<?php echo $status ?>" name="status">
<input type="hidden" value="<?php echo $niveau ?>" name="niveau">
</p>
</form>
<p class="redi"><a href='./'>reditus</a> <a href="gpl.html" target="gpl">Licentia GPL</a></p>
</body>
</html>
