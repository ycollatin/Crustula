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
  Subjonctif, exercices par niveau :

I    : latin, français, identification du mode ;
II   : latin, français, mode donné, choix de la forme ;
III  : latin, français, choix de la forme ;
III  : latin, français, temps primitifs, mode donné, forme à saisir ;
IV   : latin, français, mode donné, forme à saisir ;
V    : latin, français, forme à saisir ;
VI   : latin, forme à saisir
*/
$titre = "Subjonctif";
include "lexica/data-subj.php";

$alin = "<br>\n";
$ln = "\n";

function sorsColl($c) {
    if (count($c) == 1) return $c[0];
    return $c[mt_rand(0, count($c)-1)];   
}

function crassum($p) {
  return preg_replace("/([\w]+)(\d)/"," <b>\$1</b>", $p);
}        

function selection($p) {
   global $data;
   global $pos_ph;
   global $ln;
   $choix = $data[$pos_ph][2];
   shuffle($choix); 
   $combo = '<select name="resp" class="questlat">'.$ln
            .'<option value="'.$choix[0].'">'.$choix[0].'</option>'.$ln
            .'<option value="'.$choix[1].'">'.$choix[1].'</option>'.$ln
            .'</select>'.$ln;
   return preg_replace("/([\w]+)(\d)/",$combo, $p);
}        

function saisie($p) {
   global $data;
   global $pos_ph;
   global $ln;
   $ligne = '<input type="text" class="questlat" name="resp" size="12">';
   return preg_replace("/([\w]+)(\d)/",$ligne, $p);
}        


function modele () {
   global $data;
   global $verbes;
   global $pos_ph;
   $choix = $data[$pos_ph][2][0];
   if(preg_match("/^(si|su|es)/", $choix))
      $cle = 'sum';
   elseif(preg_match("/^(eo|ea|eu|i)/", $choix))
      $cle = 'eo';
   elseif(preg_match("/^(ab)/", $choix))
      $cle = 'abeo';
   elseif(preg_match("/^(ex)/", $choix))
      $cle = 'exeo';
   elseif(preg_match("/^(red)/", $choix))
      $cle = 'redeo';
   elseif(preg_match("/^(rog)/",$choix))
      $cle = 'rogo';
   elseif(preg_match("/^(hab)/",$choix))
      $cle = 'habeo';
   elseif(preg_match("/^(di)/",$choix))
      $cle = 'dico';
   elseif(preg_match("/^(f)/",$choix))
      $cle = 'facio';
   else $cle = 'uenio';
   return "$cle ".$verbes[$cle];
}        

function modus($p) {
   if (preg_match("/(0)/",$p))
      return "à l'indicatif";
   return "au subjonctif";
}        

// solution, en fonction du niveau

function solutio($q) {
   global $data;
   global $niveau;
   global $prior_pos;
   if ($niveau == 1) {
     preg_match("/.*(\d+).*/i", $q, $e);
     if ($e[1] == "0") return "Indicatif";
     return "Subjonctif";
   }
   else return $data[$prior_pos][2][0];
}        

// fonctions de mémorisation des résultats

function chhex($ch) {
  $tableau = array();
  while (strlen($ch) >= 30) {
     $chtmp = '1'.substr($ch, 0, 29);
     $ch = substr($ch, 29);
     //echo "*$chtmp*";
     $tableau[] = dechex(bindec($chtmp));
  }
  if ($ch > '') {
     $chtmp = '1'.$ch;
     $tableau[] = dechex(bindec($chtmp));
  }          
  return implode ('-', $tableau);
}        

function hexch($status) {
     $tableau = explode('-', $status);
     $ch = '';
     foreach ($tableau as $eclat) {
        $chtmp = decbin(hexdec($eclat));
        $chtmp = substr($chtmp, 1);
        $ch .= $chtmp;
     }
     return $ch;
}        

// niveau
if(isset($_POST["niveau"]))
   $niveau = $_POST["niveau"];
if (!isset($niveau)) {
   $ch = str_repeat('0', count($data));
   $niveau = 1;
} else { 
   $status = $_POST["status"];
   // décryptage du status
   $ch = hexch($status);
   $resp = $_POST["resp"];
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
if (isset($resp)) {
   $prior_pos = trim($_POST["priorQ"]);
   $priorphl = $data[$prior_pos][0];
   $priorphg = $data[$prior_pos][1];
   echo "<b>Prior quaestio : </b>$alin&nbsp;&nbsp;&nbsp;".crassum($priorphl).$alin;
   echo "&nbsp;&nbsp;&nbsp;$priorphg $alin";
   // extraire la solution
   $resp = trim($resp);
   $sol = solutio($priorphl);
   echo "<b>Solutio : $sol </b>$alin";
   $recte = $resp == $sol;
   if ($recte) {
      echo "<div class=\"juste\">RECTE !</div>"; 
      // mettre status à jour
      //echo "*$ch*$alin";
      $ch{$prior_pos} = '1';
      //echo "*$ch*$alin";
   } 
   else echo "<div class=\"faux\"> Errauisti. Respondisti : $resp</div>";
   include "session.php.html";
}

// maj de la liste de questionnement;
$col = array();
for ($p=0;$p<strlen($ch);$p++)
    if ($ch{$p} == '0')
       $col[] = $data[$p];
// liste vide : hausser le niveau
if (count($col) == 0) {
   $niveau++;
   $ch = str_repeat('0', count($data)); 
   $col = $data;
}
$totalq = count($data);
//echo $alin . strlen($ch) . " - $totalq$alin";
$sus = substr_count($ch, '1'); 
echo "$alin niveau $niveau, ". $sus."/".$totalq.$alin;   

// sententiam sortiri 
$ph = sorsColl($col);
$phl = $ph[0];
$phg = $ph[1];
$pos_ph = array_search($ph, $data);
// affichage de la phrase latine en fonction du niveau
if ($niveau == 1) {
    $phl = crassum($phl);
    $conseil = "d'après toi, le verbe en gras est-il à l'indicatif, ou au subjonctif ?";
}
elseif ($niveau == 2) {
    $phl = selection($phl);
    $conseil = "Choisis la forme de ". modele() . ', ' . modus($ph[0]);
    $bouton = $ln.'<input type="submit" class="questmin" value=" RECTE ? ">'.$ln; 
}        
elseif ($niveau == 3) {
    $phl = selection($phl);
    $conseil = "Choisis la forme de ". modele();
    $bouton = $ln.'<input type="submit" class="questmin" value=" RECTE ? ">'.$ln; 
}        
elseif ($niveau == 4) {
    $phl = saisie($ph[0]);
    $conseil = "Conjugue ".modus($ph[0]).' '.modele();
    $bouton = $ln.'<input type="submit" class="questmin" value=" RECTE ? ">'.$ln; 
}        
elseif ($niveau == 5) {
    $phl = saisie($ph[0]);
    $conseil = "Trouve la forme verbale qui manque.";
    $bouton = $ln.'<input type="submit" class="questmin" value=" RECTE ? ">'.$ln; 
}        
elseif ($niveau == 6) {
    $phl = saisie($ph[0]);
    $conseil = "Trouve la forme verbale qui manque. verbe ".modele();
    $bouton = $ln.'<input type="submit" class="questmin" value=" RECTE ? ">'.$ln; 
    $phg = '';
}        
else {
    $phl = saisie($ph[0]);
    $conseil = "Trouve la forme verbale qui manque.";
    $bouton = $ln.'<input type="submit" class="questmin" value=" RECTE ? ">'.$ln; 
    $phg = '';
}        

echo '</p>'."\n".'<form method="post">'.$ln;
echo '<p class="questlat">'.$phl."</p>\n";
echo '<p class="questmin">'.$phg."</p>\n";
if ($niveau == 1) {
   echo '<input type="submit" name="resp" class="questmin" value=" Indicatif ">&nbsp;'.$ln;
   echo '<input type="submit" name="resp" class="questmin" value=" Subjonctif ">&nbsp;'.$ln;
} else {
   echo $bouton;
}
echo '<p class="conseil">'.$conseil."</p>$ln";
// cryptage du status
//echo "$alin*$ch*$alin";
//echo $alin.strlen($ch).'-'.count($data).$alin;
$status = chhex($ch);
// echo "*$status*"; // debog
?>
<input type="hidden" value="<?php echo $pos_ph ?>" name="priorQ">
<input type="hidden" value="<?php echo $status ?>" name="status">
<input type="hidden" value="<?php echo $niveau ?>" name="niveau">
</p>
</form>
<p class="redi"><a href='./'>reditus</a> <a href="gpl.html" target="gpl">Licentia GPL</a></p>
<?php // echo "$alin$ch"; // debog ?>
</body>
</html>
