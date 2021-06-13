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
include "lexica/ranae.php";
$titre = "RANAE, et ablatiuus";


$alin = "<br>\n";
$ln = "\n";

// niveau
if (isset($_POST['status']))
    $status = $_POST["status"];
if (!isset($status)) {
   $niveau = 1;
} else { 
   $niveau = $_POST["niveau"];
   $nbq = $_POST['nbq'];
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
// $nbq = $_POST['nbq'];
// echo "*$nbq*";
if (isset($status) && $nbq > 0) {
    // affichage de la phrase prÃ©cÃ©dente et des solutions
    $ppl = $data[$status][0];
    $ppg = $data[$status][1];
    echo 'Prior quaestio : '.notes($ppl).$alin.notes($ppg).$alin;
    //echo "*$ppl*$alin";
    // calcul et affichage de la solution
    $sol = array();
    $expr = str_repeat('([\d]).*', $nbq);
    if ($niveau == 1) $pp = $ppg;
    else $pp = $ppl;
    preg_match("/$expr/", $pp, $eclats);
    //echo '*'.implode('.',$eclats).'*'.$alin;
    for($i = 1;$i<=$nbq;$i++) {
        $sol[] = $eclats[$i]; 
        $affsol[] = $i+1 .' : '.$valeurs[$eclats[$i]];
    }
    echo implode($alin, $affsol).$alin;
    // rÃ©cupÃ©ration et mise en tableau de la rÃ©ponse
    for ($i=1;$i<=$nbq;$i++) {
       $resp[] = $_POST["r$i"];
    }
    // calcul et affichage de la sanction
    $recte = $resp == $sol;
    if ($recte) {
        echo "<div class=\"juste\">RECTE !</div>"; 
        // mettre status Ã  jour
        $status++;
    } else {
        echo "<div class=\"faux\"> Errauisti. Respondisti :$alin";
	foreach ($resp as $re)
	   echo $valeurs[$re].$alin;
	echo "</div>";
   }
} 
else if (empty($nbq)) $status = 0; // debog : status = 21; sinon status = 0;
else $status++;
if ($status >= count($data)) {
    $niveau++;
    $status = 0;
}
 
// affichage du niveau
echo "Niveau $niveau $alin";
// affichage de la progression
echo "$status/".count($data).$alin;

if (isset($recte)) include "session.php.html";    

function sinenum($p) {
   return preg_replace('/([\wÃ©Ã¨Ã ]+)(\d)/',"$1",$p);
}

function notes($p) {
  global $r;
  $eclats = preg_split("/[0-6]/", $p);
  //echo '*'.count($eclats).'*';
  if (count($eclats) == 1){
     $r = 0;
     return $p;
  }
  $r = 1;
  for ($i=0;$i+1<count($eclats);$i++) {
     $eclats[$i] .= '('.$r++.')';
  }
  return implode('',$eclats);
}

function relief($p) {
  $p = preg_replace("/([\wÃ©Ã¨Ã ]+)(\d)/"," <b>\$1</b>", $p);
  return $p;
}

function sel_val($r) {
global $ln, $valeurs;
$ret = $r.'&nbsp<select name="r'.$r.'">'.$ln;
for ($i=0;$i<count($valeurs);$i++) 
  $ret .= '<option value="'.$i.'">'.$valeurs[$i].'</option>'.$ln;
$ret .='</select>'.$ln;
return $ret;
}

// calcul des variables de la question en fonction du niveau
$bouton = " RECTE ? ";

if ($niveau == 1) {
   // 1er niveau : 
   $ph = $data[$status];
   $phl = relief($ph[0]);
   $phg = notes($ph[1]);
   if ($r == 0) {
       $consigne = 'Le niveau est terminÃ©. Lis la fin du texte';
       $bouton = ' Porro ';
   } else $consigne = "Ces mots sont-ils Ã  l'ablatif ? Pourquoi ?<br>"
                    . "Attention ! Il n'y a peut-Ãªtre aucun ablatif !";
}
elseif ($niveau == 2) {
   // 2Ã¨me niveau : 
   $ph = $data[$status];
   $phl = notes($ph[0]);
   $phg = relief($ph[1]);
}
elseif ($niveau == 3) {
   // 3Ã¨me niveau : 
   $ph = $data[$status];
   $phl = notes($ph[0]);
   $phg = sinenum($ph[1]);
}        
elseif ($niveau == 4) {
   // 4Ã¨me niveau : 
   $ph = $data[$status];
   $phl = notes($ph[0]);
   $phg = '';
}        
else {
   $phl = 'Ad finem peruenisti. Optime fecisti !';
   $phg = '';
}        
if ($r == 0) {
   $consigne = 'Le niveau est terminÃ©. Lis la fin du texte';
   $bouton = ' Porro ';
   } else $consigne = "Ces mots sont-ils Ã  l'ablatif ? Pourquoi ?<br>"
       . "Attention ! Il n'y a peut-Ãªtre aucun ablatif !";

// affichage du latin et du franÃ§ais;
echo '<form method="post">'.$ln;
echo '<p class="questlat">'.$ln;
echo "$phl$alin";
echo '</p><p class="questmin">'.$ln;
echo "$phg</p>";
// formulaire
for ($i=1;$i<$r;$i++)
  echo sel_val($i).'<br>';
echo '<input type="submit" class="questmin" value="'. $bouton .'">'.$ln;

// champs cachÃ©s
echo '<input type="hidden" name="status" value="'.$status.'">'.$ln;
$r--;
echo '<input type="hidden" name="nbq" value="'.$r.'">'.$ln;
echo '<input type="hidden" name="niveau" value="'.$niveau.'">'.$ln;
echo "</form>$ln";
echo '<div class="conseil">'.$consigne."</div>$alin";
//liens de bas de page
?>
<p class="redi"><a href='./'>reditus</a> <a href="gpl.html" target="gpl">Licentia GPL</a></p>
</body>
</html>
