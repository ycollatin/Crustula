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

function sorsColl($c) {
    if (count($c) == 1) return $c[0];
    return $c[mt_rand(0, count($c)-1)];   
}

function trans($ph, $m) { 
   global $aides;
   preg_match('/^(.*)-(.*)-(.*)$/', $ph, $eclats);
   $aides = explode('|',$eclats[2]);
   if ($m == 'q')
      return $eclats[1].'...'.$eclats[3];
   if ($m == 'o')
      return $eclats[1].$aides[0].$eclats[3];
}        

// niveau
$niveau = $_POST["niveau"];
$status = $_POST["status"];
if (empty($status)) {
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
echo "debog resp :$resp:";
if (isset ($_POST["resp"])) {
   $priorphl = trim($_POST["priorQ"]);
   // extraire la solution
   $resp = trim($_POST["resp"]);
   if ($niveau < 5) {
      for($i=0; $i<count($bini); $i++) {
         $lin = $bini[$i];
         $orig = trans($lin[0], 'q');
         if ($orig == $priorphl) break;
      }
      preg_match("/^.*-(.*)-.*$/", $lin[0], $eclats);
      $eclats = explode('|', $eclats[1]);
      $sol = $eclats[0];
      //$recte = $resp == $sol;
      $priorphl = preg_replace('/(\.\.\.)/', "<span class=\"juste\">$sol</span>", $priorphl);
      echo "Prior quaestio : $priorphl";
   } else {
      $ec = explode('...', $priorphl);
      $init = $ec[0]; $finis = $ec[1];
      for($i=0; $i<count($bini); $i++) {
          // rétablir la phrase originale
          $lin = $bini[$i];
          $orig = trans($lin[0], 'o');
          if (preg_match('/^'.$init.'(.*)'.$finis.'$/', $orig, $ecl)) break;
      }
      $sol = $ecl[1];
      echo "Prior quaestio : $orig";
      //$recte = strtolower($resp) == strtolower($sol);
   }
   $recte = strtolower($resp) == strtolower($sol);
   if ($recte) {
      echo "<div class=\"juste\">RECTE !</div>"; 
      // mettre status à jour
      $ch{$i} = '1';
   } else echo "<div class=\"faux\"> Errauisti. Respondisti : $resp</div>";
}
// debog
//echo "ch(".strlen($ch).") : *$ch*$alin";
include "session.php.html";    

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

if ($niveau < 5) {
   $phl = trans($l, 'q');
   // $phla est destiné à un affichage plus propre.
   preg_match("/^.*-(.*)-.*$/", $l, $eclats);
   $phla = preg_replace("/(\s\.\.\.)/", "&nbsp;...", $phl); 
} else {
   // niveau 5 : lacune aléatoire.
   $phl = trans($l, 'o');
   $ecl = explode(' ', $phl);
   $lacune = $ecl[mt_rand(0, count($ecl)-1)]; 
   $lacune = preg_replace('/[,\.]/', '', $lacune); 
   $phl = preg_replace("/$lacune/", '...', $phl, 1);
   $phla = $phl;
}

// auxilium eligere 
if ($niveau == 1) $aide = $aides[1].', '.$aides[2]; 
elseif ($niveau == 2) $aide = $aides[1];
elseif ($niveau == 3) $aide = '';
elseif (niveau == 4){
   $aide = '';
   $g = '';
}        
else $aide = '';

?>
<p class="questmin">
<?php
    echo "$phla</p>$aide$alin$g$alin";
?>
</p>
<form method="post">
<p class="question">
<input class="question" type="text" name="resp">&nbsp;
<input type="submit" value="Num recte dixi ?">
<input type="hidden" value="<?php echo $phl ?>" name="priorQ">
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
