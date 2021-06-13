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
$titre = "De casibus - Declinatio secunda";
$alin = "<br>\n";

$bini = array(
 //nominatif
 array('Meus -amicus- est.', 
       'Il est -mon ami-.',
       'nominatif','singulier',
       'Cic, Phil, 5.6.3'),
 array('-amicus- certus in re incerta cernitur.', 
       '-L\'ami- certain se reconnaît dans une situation incertaine',
       'nominatif','singulier',
       'Cic., Amic. 64.8'),
 // vocatif
 array( 'sed, -amice- magne, noli hanc epistulam Attico ostendere.',
        'Mais, grand -ami-, ne montre pas cette lettre à  Atticus.',
        'vocatif','singulier',
        'Cic. Fam. 29'),
 array('cur ferrum illud, quod pectori meo infigere parabam, detraxistis, o inprouidi -amici- ?',
       'Pourquoi avez-vous retenu ce fer, que je m\'apprêtais à  m\'enfoncer dans la poitrine, '
      .'ô inconscients -amis- ?',
       'vocatif','pluriel',
       'Tac. Ann. 1.43'),
 // accusatif
 array('-amicum- cum uides, obliscere miserias.',
       'Quand tu vois -un ami-, oublie tes malheurs.',
       'accusatif', 'singulier',
       'Prisc. GL 2.384K.2'),
 array('-amicum- a piratis redemi.', 
       'J\'ai racheté -mon ami- aux pirates',
       'accusatif','singulier',
       'Sen. Ben 1.5.4.1'),
 array('decima hora -amicos- plures quam prima inuenit.', 
       'La dixième heure trouve plus -d\'amis- que la première.',
       'accusatif','pluriel',
       'Syr, Sent D.28'),
 array('Obsequium -amicos-, ueritas odium parit.', 
       'La complaisance produit -des amis-, la vérité produit la haine.',
       'accusatif','pluriel',
       'Ter, An 68'),
 // génitif
 array('uulgare -amici- nomen, sed rara est fides.', 
       'Répandu est le nom -d\'ami- mais rare est la fidélité',
       'génitif','singulier',
       'Phaedrus Fab 3.9.1'),
 array('is longe omnium -amicorum- carissimus erat', 
       'Il était de loin le plus cher de tous -mes amis-.',
       'génitif','pluriel',
       'Curt. Alex 3.12.16'),
 //datif
 array('epistulas ad me perferendas tradidisti -amico-', 
       'Tu as donné -à  un ami- une lettre pour qu\'il me la remette.',
       'datif','singulier',
       'Sen. Ep. 3.1'),
 array('mitis ac munificus -amicis- fuit.', 
       'Il fut doux et généreux -pour ses amis-.',
       'datif','pluriel',
       'Liv. AUC 33.21'),
 //ablatif
 array('diues cum -amico- paupere et filia nauigabat.', 
       'Un riche naviguait avec sa fille et avec -un ami- pauvre.',
       'ablatif','singulier',
       'Quint., Decl. 259.pr.'),
 array('utinam ueris domum -amicis- impleam !', 
       'Puissé-je emplir ma maison de vrais -amis- !', 
       'ablatif','pluriel',
       'Phaed Fab. 3.9.6'),
 array('cum -amicis- deliberaui.', 
       'J\'ai réfléchi avec -mes amis-',
       'ablatif','pluriel',
       'Plaut St 580') 
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
if (!empty($resp)){
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
      // mettre status à  jour
      $ch{$i} = '1';
   } else echo "<div class=\"faux\"> Errauisti. Respondisti : $resp</div>";
}
// debog
//echo "ch(".strlen($ch).") : *$ch*$alin";
if (isset($recte)include "session.php.html";    

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
   // 1er niveau : les mots latin et franà§ais en gras ; cas demandé. 
   $phla = $l;
   $g = graisse($g);
   $l = graisse($l);
   $q = "À quel cas est \"$u\" ?";
}
elseif ($niveau == 2) {
   // 2ème niveau : mise en gras du franà§ais ; données morpho ; lacune à  combler.
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
<p class="redi"><a href='./'>reditus</a> <a href="gpl.html" target="gpl">Licentia GPL</a></p>
</body>
</html>
