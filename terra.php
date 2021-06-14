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
$titre = "De casibus - Declinatio Prima";
$alin = "<br>\n";
$doc = 
     "Ce crustulum a pour but de t'apprendre à tenir compte des cas en "
    ."lisant et en écrivant du latin.<br>"
    ."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
    ."Tu dois savoir que"
    ."<ul>\n"
    ."<li>Le sujet de la phrase, l'attribut du sujet et l'apposition du sujet sont au NOMINATIF ;</li>\n"
    ."<li>Si on nomme ou désigne celui à qui on s'adresse, si on l'appelle, on emploie le VOCATIF ;</li>\n"
    ."<li>Le COD du verbe, le lieu où l'on va, la durée sont à l'ACCUSATIF ;</li>\n"
    ."<li>Le CDN (complément du nom) se met au GÉNITIF</li>\n"
    ."<li>Le destinataire d'une action (surtout d'un don, d'une parole, d'un coup) est au DATIF.</li>\n"
    ."<li>Cause, moyen, manière, lieu où l'on est, lieu d'où l'on vient sont à l'ABLATIF.</li>\n"
    ."</ul>\n"
    ."<hr>\n";

$bini = array(
   // nominatif
   array('-terra- tenera est',
         '-La terre- est tendre.',
         'nominatif','singulier',
         'Cato, agr, 45, 1'),
   array('-terra- sitit',
         '-La terre- a soif.',
         'nominatif','singulier',
         'Plin. NH, 31, 39'),
   array('uere tument -terrae-.',
         'Au printemps -les terres- sont gonflées.',
         'nominatif', 'pluriel',
         'Virg. Georg. 2, 324'),
   // vocatif
   array('o caelum, o -terra-, o maria Neptuni !',
         'Ô ciel, ô -terre-, ô mers de Neptune !',
         'vocatif','singulier',
         'Ter., Ad., 790'),
   // accusatif
   array('uenti -terras- uerrunt.',
         'Les vents balaient -les terres-',
         'accusatif', 'pluriel',
         'Lucr. 1, 277'),
   array('Hannibal -terram- Italiam lacerabat.',
         'Hannibal déchirait -la terre- d\'Italie.',
         'accusatif','singulier',
         'Cato, Or., 187'),
   array('recidunt omnia in -terras-.',
         'Toutes les choses reviennent dans -les terres-.',
         'accusatif', 'pluriel',
         'Cic., Nat., 2, 66'),
   // génitif 
   array('nuntiatur -terrae- motus horribilis.',
         'Un horrible tremblement -de terre- est annoncé.',
         'génitif', 'singulier',
         'Cic., Har., 62, 9'),
   array('de mundi ac -terrarum- magnitudine disputant',
         'Ils débattent de la grandeur du monde et -des terres-.',
         'génitif', 'pluriel',
         'Caes. Gall., 6, 14, 6'),
   // datif 
   array('Reddenda -terrae- est terra.',
         'La terre doit être rendue -à la terre-.',
         'datif','singulier',
         'Cic., Tusc., 3, 59'),
   array('hi tanti ignes nihil nocent -terris-.',
         'Ces si grands feux ne sont aucunement nocifs -pour les terres-.',
         'datif','pluriel',
         'Cic. Nat., 2, 92'),
   // ablatif
   array('Caelo et -terra- fruor.',
         'Je profite du ciel et de -la terre-.',
         'ablatif','singulier',
         'Cic. Fam. 7. 16'),
   array('in -terra- dimicant',
         'Ils combattent sur -terre-',
         'ablatif','singulier'),
   array('omnia oriuntur e -terris-.',
         'Toutes les choses naissent des -terres-.',
         'ablatif', 'pluriel',
         'Cic., Nat., 2, 66'),
   array('Cn. Pompeius in extremis -terris- bellum gerebat',
         'Cnéius Pompée faisait la guerre sur -les terres- les plus éloignées.',
         'ablatif', 'pluriel',
         'Sall., Cat., 16, 5')
);

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

// niveau
if (isset($_POST["niveau"])) {
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
   $resp = trim($_POST["resp"]);
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
if (empty ($resp)) echo $doc;
else
{
   $priorphl = trim($_POST["priorQ"]);
   // extraire la solution
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
}
// debog
//echo "ch(".strlen($ch).") : *$ch*$alin";
if (isset($recte))
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
   $aide = ""; 
}
else {
   // 3ème        : plus de traduction. 
   $g = "";
   $phla = $l;
   $l = trans($l, 'q');
   $q = "Hic scribe uerbum latinum quod deest. ";
   $aide = "$dataM"; 
}        

echo '<p class="questmin">';
echo "$l</p>$aide$alin$g";
echo "<p class=\"questmin\">$q</p>";
echo "<form method=\"post\">\n";
echo "<p class=\"question\">\n";
if ($niveau > 1) {
   echo "<input class=\"question\" type=\"text\" name=\"resp\">&nbsp;";
   echo "<input type=\"submit\" value=\"Num recte dixi ?\">";
} else {
  $lescas = array('nominatif','vocatif','accusatif',
                  'génitif','datif','ablatif');
  shuffle($lescas);
  For ($i=0;$i<6;$i++) {
     echo "<input type=\"submit\" class=\"questmin\" value=\"$lescas[$i]\" name=\"resp\">&nbsp;";
     if ($i == 2) echo $alin;
  }
}        
echo "<input type=\"hidden\" value=\"$phla\" name=\"priorQ\">\n";
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
<p class="redi"><a href='./'>reditus</a> <a href="gpl.html" target="gpl">Licentia GPL</a>
</p>
<a name="agedum"></a>
</body>
</html>
