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
// Flaui Capri imitatio, De Orthographia.
$alin = "<br>\n";
$quaestiones = array(
  "Haec via quo ducit?|Haec via ubi ducit ?|Où va cette route ?",
  "Intro imus.|Intus imus.|Nous entrons", 
  "Intus sumus.|Intro sumus|Nous sommes à l'intérieur",
  "Vado ad grammaticum.|Vado apud grammaticum.|Je vais chez le maître",
  "Vado ad medicum.|Vado apud medicum.|Je vais chez le médecin",
  "disco apud grammaticum.|disco ad grammaticum.|J'apprends chez le maître.",
  "incidit in manus meas inimicus|incidit in manus inimicus|l'ennemi me tombe entre les mains",
  "in mentem uenit|in mente uenit|Il me vient à l'esprit",
  "Oblitus ne sis nostri|Oblitus ne sis nos|Ne nous oublie pas.",
  "inuideo tibi divitiis|inuideo tibi diuitias|Je t'envie tes richesses.",
  "Seui messem|Serui messem|J'ai semé.", 
  "Pulchrum|Pulcrum|Beau",
  "Thesaurum|Thensaurum|Trésor",
  "Dico me victurum|Dico me vinciturum|Je dis que je gagnerai", 
  "Alter e duobus|Vnus e duobus|L'un des deux",
  "modo scripsi|modo scribo|je viens d'écrire",
  "Fidus amicus|Fidelis amicus|Un ami fidèle",
  "Fidelis famulus|Fidus famulus|Un serviteur fidèle",
  "Olea arbor est|oliva arbor est|l'olivier est un arbre.", 
  "oliva fetus|oleum fetus|L'olive est un fruit",
  "oleum liquor est|Olea liquor est|l'huile est un liquide", 
  "cum dabimus, dicendum 'accipe'|cum dabimus, dicendum 'sume'|Quand nous donnerons, il faudra dire 'prends'",
  "Vbera pecudis|Mammae pecudis|Les mammelles d'un animal",
  "Vultus|facies|l'expression du visage", 
  "facies|uultus|le visage",
  "Maestus est|Tristis est|Il est triste",
  "Tristis est|Maestus est|Il a l'air triste",
  "Vir ducit|Vir nubit|Un homme se marie",
  "mulier nubit|mulier ducit|une femme se marie",
  "calidum|caldum|chaud, vif, ardent"
  );

function sorsColl($c) {
    if (count($c) == 1) return $c[0];
    $red = $c[array_rand($c)]; 
    return $red;
}

function sol($q) {
    global $quaestiones;
    foreach ($quaestiones as $lin) {
        $partes = explode('|', $lin);
	if ($partes[2] == $q) return $partes[0];
    }
}

if(isset($_POST["priorQ"])) {
    $priorQ = $_POST["priorQ"];
    $priorQ = stripslashes($priorQ);
    $resp = $_POST["resp"];
    $resp = stripslashes($resp);
    $sol = sol($priorQ);
    $recte = $resp == $sol;
}    
$lineaQ = sorsColl($quaestiones);
$partes = explode('|', $lineaQ);
$quaestio = $partes[2];
$optiones = array($partes[0], $partes[1]);
shuffle($optiones);
session_start();
?>
<html>
<head>
<title>CRVSTVLA - DE ORTHOGRAPHIA</title>
<?php 
   include "css.inc";
   include "meta.inc.php";   
?>
<body>
</body>
<p class="titre">
CRVSTVLA - DE ORTHOGRAPHIA 
</p>
<?php
if (!empty($priorQ)) {
   echo "prior quaestio : $priorQ$alin";
   echo "Solutio : $sol $alin ";
   if ($recte)
	   echo "<div class=\"juste\">RECTE !</div>"; 
   else 
	   echo "<div class=\"faux\"> Errauisti. Respondisti $resp.</div>";
   include "session.php.html";
} else {
   $_SESSION['prius'] = 0;
   $_SESSION['consec'] = 0;
}
?>
</p>
<p class="question">
   <?php 
   echo $quaestio;
   ?> 
</p>
<form method="post">
<p class="question">
<input type="submit" class="question" name="resp" 
   value="<?php echo $optiones[0]?>">
<input type="submit" class="question" name="resp" 
   value="<?php echo $optiones[1]?>">
<form method="post">
<?php
echo "<input type=\"hidden\" name=\"priorQ\" value=\"$quaestio\">";
?>
</p>
</form>
<p class="redi"><a href='./'>reditus</a> <a href="gpl.html" target="gpl">Licentia GPL</a></p>
</body>
</html>
