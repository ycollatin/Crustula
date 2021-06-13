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
$exempla = array(
  array("scuto uobis magis quam gladio opus est.", 
        "Vous avez plus besoin d'un glaive que d'un bouclier."),
  array("gladio eum percussit.","Il le frappa de son glaive."),
  array("inimicum fratris cum gladio cruento uidet.",
        "Il voit l'ennemi de son frère avec un glaive ensanglanté."),
  array("Rhosacis manum gladio amputauit.",
        "Il coupa la main de Rhosax avec son glaive."),
  array("arrípuit gladium","Il saisit son glaive."),
  array("cruentum gladium tenet.","Il tient un glaive ensanglanté."),
  array("gladium cruentum in vaginam recondidit.",
        "Il remet dans son fourreau son glaive ensanglanté."),
  array("in gladium incubuerat, ex uulnere est recreatus.",
           "Il s'était jeté sur son glaive, on l'a guéri de sa blessure."),
  array("confestim gladium destrinxit.","Aussitôt il tira son glaive."),
  array("A quo relictus gladius est ?",
        "Par qui le glaive a-t-il été laissé ?"),
  array("in lectulo gladius cruentatus inventus est.",
        "Un glaive ensanglanté a été trouvé sur le lit."),
  array("Pausanias in capulo gladii, quadrigam habuit caelatam.",
         "Pausanias avait un quadrige gravé sur le pommeau de son glaive."),
  array("Ubi est gladius tuus ?","Où est ton glaive ?"),
  array("Non est gladius meus, sed manus mea est", 
	"Ce n'est pas mon glaive, mais c'est ma main."),
  array("gladius micat.","Le glaive brille."),
  array("utrimque gladii destricti sunt.",
        "de chaque côté les glaives ont été tirés."),
  array("tum micent gladii !",
        "Alors, que les épées brillent !"),
  array("gladii praebet speciem.",
        "il offre l'apparence d'un glaive. (il ressemble à un glaive)"),
  array("Pausanias in capulo gladii quadrigam habuit caelatam.",
        "Pausanias avait un quadrige gravé sur le pommeau de son glaive."),
  array("ostendit gladii capulum.",
        "Il montre le pommeau de son glaive."),
  array("Ei data est ius gladii. ",
        "Le droit du glaive (de vie ou de mort) lui a été donné."),
  array("gladios strinxerunt.",
        "Ils tirèrent leurs glaives."),
  array("contempsi Catilinae gladios, non pertimescam tuos.",
        "J'ai méprisé les glaives de Catilina, je ne craindrai pas les tiens."),
  array("Gallus quidam nudus praeter scutum et gladios duos.",
        "Un Gaulois nu, à part un bouclier et deux glaives."),
  array("Copidas vocabant gladios leviter curvatos.",
        "Ils appelaient copidas leurs glaives légèrement recourbés."),
  array("barbari veneno tinxerant gladios.",
        "Les barbares avaient enduit leurs glaives de poison."),
  array("Magna gladiorum est impunitas.",
        "L'impunité des glaives (des meurtres) est grande."),
  array("gladiorum rubigo",
        "La rouille des glaives."),
  array("gladiorum ingens est numerus.",
        "Le nombre des glaives est immense."),
  array("in gladiorum mucronibus   ",
        "sur la pointe de leurs glaives "),
  array("comminus gladiis pugnatum est.",
        "on combattit corps à corps avec les glaives."),
  array("gladiis magnam partem eorum interfecerunt.   ",
        "Ils en tuèrent une grande partie avec leurs glaives."),
  array("nostri omissis pilis gladiis rem gerunt.   ",
        "les nôtres, laissant leurs pilums, accomplissent cela avec leurs glaives."),
  array("illis gladiis quos uidemus confides.",
        "Tu comptes sur ces glaives que j'ai vus."),
  array("milites cum gladiis sequuntur consulem.   ",
        "des soldats armés de (avec des) glaives suivent le consul."),
  array("ab neutra parte emissa sint tela. gladiis pugna coepit.",
        "Les javelots ne furent envoyés par aucun des deux camps. La bataille aux glaives (au glaive) commence.")
   );


function sorsColl($c) {
    if (count($c) == 1) return $c[0];
    $red = $c[array_rand($c)]; 
    return $red;
}

$q = sorsColl($exempla);
$gallice = $q[1];
$latine = $q[0];
$latine = preg_replace("/\b(gladi\w*)/",'<input class="question" type="text" name="resp">',
    $latine);

function sol($sent) {
    global $exempla, $linea;
    foreach ($exempla as $ex) {
        $g = $ex[1];
	if ($g == $sent) {
           $linea = $ex[0];
	   preg_match("/(glad\w*)\b/", $linea, $partes);
	   return $partes[1];
	}
    }
}
if (isset($_POST['resp'])) {
    $resp = $_POST['resp'];
    $resp = strtolower($resp); 
    $priorsent = $_POST['priorsent']; 
    $priorsent = stripslashes($priorsent);
    $recte = ($resp == sol($priorsent));
}
session_start();
?>
<html>
<head>
<title>CRVSTVLA - Gladius</title>
<?php 
   include "css.inc";
   include "meta.inc.php";   
?>
</head>
<body>
<p class="titre">
GLADIVS
</p>
<?php
if (isset($priorsent)){
   echo "prior sententia : $priorsent$alin$linea$alin";
   if ($recte)
	   echo "<div class=\"juste\">RECTE !</div>"; 
   else 
	   echo "<div class=\"faux\"> Errauisti. Respondisti $resp";
   include "session.php.html";
} else {
   $_SESSION['prius'] = 0;
   $_SESSION['consec'] = 0;
}
?>
</p>
<p class="question">
   <?php 
   echo $gallice;
   ?> 
</p>
<form method="post">
<p class="question">
<?php
echo $latine;
?>
&nbsp;<input type="submit" value="Num recte dixi ?">
<input type="hidden" name="priorsent" value="<?php echo $gallice; ?>">
</p>
</form>
<p class="redi"><a href='./'>reditus</a> <a href="gpl.html" target="gpl">Licentia GPL</a></p>
</html>
</body>


