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

              TABLEAU PRÉVISIONNEL DES cRUSTULA POUR LES QUESTIONS DE TEMPS

INDICATIF  
   Ut    «Quand, lorsque». Il n'introduit normalement que des verbes au passé,
      et n'exprime la répétition que quand il est suivi de quisque.     Ubi
      «Quand, lorsque»        
   Ut primum
   Ubi primum
   Simul atque     «Dès que, aussitôt que»         
   Quamdiu         «Aussi longtemps que»   
   Postquam        «Après que». Il est le plus souvent suivi de temps du passé. On
      le trouve parfois avec l'imparfait au sens de «comme». Il est remplacé par quam
      après un complément de temps.   Posteaquam      «Après que»
   Dum : pendant que

INDICATIF ou SUBJONCTIF
   Quoties(cumque)         «Chaque fois que»       
   Cum     1-  «Au moment où, lorsque» (fait unique).
           2- «Toutes les fois que, quand» (répétition).
   Cum indique un simple rapport de temps.         Avec un temps du passé :
     «comme, alors que». Enchaînement des faits dans un récit au passé, suivant
     la concordance des temps.  
   Antequam, Priusquam       «Avant le moment où», «avant que». Il s'agit d'un simple
      rapport de temps.      «En attendant que», «sans attendre que».  
   Dum, Donec, Quoad   À tous les temps de l'indicatif, deux sens.
      1- «Jusqu'au moment où»
      2- «Tant que».  «Jusqu'à ce que», «En attendant que».
*/

include 'lexica/dum.php';

$alin = "<br>\n";

function sorsColl($c) {
    if (count($c) == 1) return $c[0];
   return $c[mt_rand(0, count($c)-1)];   
   $status = 0;
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
if(isset($_POST["niveau"])) {
    $niveau = $_POST["niveau"];
    $status = $_POST["status"];
}
if (!isset($status)) {
   $status = 1;
   $niveau = 1;
}  
// formatage de la chaîne binaire de status
$ch = decbin($status);      
$ch .= str_repeat('0', 1 + count($bini) - strlen($ch));

/*
// maj de la liste de questionnement;
$biniq = array();
for ($i=1;$i<strlen($ch);$i++) 
   if ($ch{$i} == '0') $biniq[] = $bini[$i-1];

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
*/

session_start();
?>
<html>
<head>
<title>CRVSTVLA - DVM</title>
<?php 
   include "css.inc"; 
   include "meta.inc.php";   
?>
</head>
<body>
<p class="titre">
DVM
</p>
<?php
//if (!empty($resp)){
if (isset($_POST['resp'])){
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
      $recte = $resp == $sol;
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
      $recte = $resp == $sol;
   }
   if ($recte) {
      echo "<div class=\"juste\">RECTE !</div>"; 
      // mettre status à jour
      $ch{$i+1} = '1';
      $status = bindec($ch);
      // debog
      //echo "ch : *$ch*$alin";
      //echo "status : $status$alin";
   } else echo "<div class=\"faux\"> Errauisti. Respondisti : $resp</div>";
   include "session.php.html";
}


// maj de la liste de questionnement;
$biniq = array();
for ($i=1;$i<strlen($ch);$i++) 
   if ($ch{$i} == '0') $biniq[] = $bini[$i-1];
if (count($biniq) == 0) {
   // liste vide : hausser le niveau
   $niveau++;
   $status = 1;
   $biniq = $bini;
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
<p class="question">
<?php
    echo "$phla</p>$aide$alin$g$alin";
?>
</p>
<form method="post">
<p class="question">
<input class="question" type="text" name="resp">&nbsp;
<input type="submit" value="Num recte dixi ?">
<input type="hidden" value="<?php echo $phl ?>" name="priorQ">
<input type="hidden" value="<?php echo $status ?>" name="status">
<input type="hidden" value="<?php echo $niveau ?>" name="niveau">
</p>
</form>
<p class="redi"><a href='./'>reditus</a> <a href="gpl.html" target="gpl">Licentia GPL</a></p>
</body>
</html>
