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
$diclat = array(
   array("habeo, es, ere, habui, habitum : avoir", "habu", "habit"), 
   array("dimitto, is, ere, dimisi, dimissum : renvoyer", "dimis", "dimiss"),
   array("accipio, is, ere, accepi, acceptum : recevoir", "accep", "accept"),
   array("frango, is, ere, fregi, fractum : briser", "freg", "fract"),
   array("augeo, es, ere, auxi, auctum : augmenter", "aux", "auct"),
   array("uiuo, is, ere, uixi, uictum : vivre", "uix", "uict"),
   array("tango, is, ere, tetigi, tactum : toucher", "tetig", "tact"), 
   array("maneo, es, ere, mansi, mansum : rester", "mans", "mans"), 
   array("incipio, is, ere, incepi, inceptum : commencer", "incep", "incept"),
   array("aspicio, is, ere, aspexi, aspectum : regarder", "aspex", "aspect"),
   array("deleo, es, ere, deleui, deletum : détruire", "deleu", "delet"),
   array("uenio, is, ire, ueni, uentum : venir", "uen", "uent"),
   array("trado, is, ere, didi, ditum : transmettre", "tradid", "tradit"),
   array("reddo, is, ere, reddidi, redditum : rendre", "reddid", "reddit"),
   array("inuenio, is, ire, ueni, uentum : trouver", "inuen", "inuent"),
   array("ago, is, ere, egi, actum : agir", "eg", "act"),
   array("cupio, is, ere, cupiui, cupitum : désirer", "cupiu", "cupit"),
   array("traho, is, ere, traxi, tractum : tirer", "trax", "tract"),
   array("iungo, is, ere, iunxi, iunctum : joindre", "iunx", "iunct"),
   array("cerno, is, ere, creui, cretum : distinguer", "creu", "cret"),
   array("iubeo, es, ere, iussi, iussum : ordonner", "iuss", "iuss"),
   array("uideo, es, ere, uidi, uisum : voir", "uid", "uis"),
   array("respondeo, es, ere, respondi, responsum : répondre", "respond", "respons"),
   array("do, das, dare, dedi, datum : donner", "ded", "dat"),
   array("doceo, es, ere, docui, doctum : enseigner", "docu", "doct"),
   array("opto, as, are : souhaiter", "optau", "optat"),
   array("colo, is, ere, colui, cultum : cultiver", "colu", "cult"),
   array("perdo, is, ere, perdidi, perditum : ruiner", "perdid", "perdit"),
   array("praebeo, es, ere, praebui, praebitum : offrir", "praebu", "praebit"),
   array("diligo, is, ere, dilexi, dilectum : aimer", "dilex", "dilect"),
   array("debeo, es, ere, debui, debitum : devoir", "debu", "debit"),
   array("pugno, as, are : combattre", "pugnau", "pugnat"),
   array("tollo, is, ere, sustuli, sublatum : emporter", "sustul", "sublat"),
   array("torqueo, es, ere, torsi, tortum : tourmenter", "tors", "tort"),
   array("contingo, is, ere, contigi, contactum : atteindre", "contig", "contact"),
   array("cresco, is, ere, creui, cretum : augmenter", "creu", "cret"),
   array("spero, as, are : espérer", "sperau", "sperat"),
   array("contemno, is, ere, contempsi, contentum : mépriser", "contemps", "contempt"),
   array("timeo, es, ere, timui : craindre", "timu", "nihil"),
   array("amitto, is, ere, misi, missum : perdre", "amis", "amiss"),
   array("probo, as, are : prouver", "probau", "probat"),
   array("peto, is, ere, petiui, petitum : rechercher", "petiu", "petit"),
   array("credo, is, ere, credidi, creditum : confier", "credid", "credit"),
   array("interficio, is, ere, feci, fectum : tuer", "interfec", "interfect"),
   array("fallo, is, ere, fefelli, falsum : tromper", "fefell", "fals"),
   array("cano, is, ere, cecini, cantum : chanter", "cecin", "cant"),
   array("curro, is, ere, cucurri, cursum : courir", "cucurr", "curs"),
   array("pono, is, ere, posui, positum : placer", "posu", "posit")
);

function sorsColl($c) {
    if (count($c) == 1) return $c[0];
   return $c[mt_rand(0, count($c)-1)];   
}

function DicQuaest($th, $ve) {
 global $alin;
 return "Quel est le radical du $th du verbe $alin $ve ?$alin";
}

function rad_infectum($u) {
   $partes = explode (',', $u);
   if ($partes[1] == " as")
      return preg_replace ("/o$/", "a", $partes[0]);
   $avant[0] = "/eo$/";
   $avant[1] = "/io$/";
   $avant[2] = "/o$/";
   $apres[0] = "e";
   $apres[1] = "i";
   $apres[2] = "";
   return preg_replace($avant, $apres, $partes[0]);
}

$verbe = sorsColl($diclat);
$themata = array("présent", "parfait", "supin");
$thema = sorsColl($themata); 
// debog 
$thema = 'présent';
$quaestio = DicQuaest($thema, $verbe[0]);
session_start();
?>

<html>
<head>
  <title>CRVSTVLA - DE THEMATIBVS</title>
<?php 
   include "css.inc";
   include "meta.inc.php";   
?>
</head>
<body>
<p class="titre">
 DE THEMATIBVS
</p>
<?php
if(isset($_POST["r"]))
    $r = $_POST["r"];
if (isset($r)) {
    //$priorQ = $_POST["priorQ"];
    //$priorQ = stripslashes($priorQ);
    $priorV = $_POST["priorV"];
    $priorT = $_POST["priorT"];
    $r = stripslashes($r);
    $resp = $r;
    $r = strtolower(trim($r));
    echo "prior quaestio : ". DicQuaest($priorT, $priorV);
    foreach ($diclat as $linea)
       if ($linea[0] == $priorV) {
          if ($priorT == "présent")
             $s = rad_infectum($priorV); 
	  elseif ($priorT == "parfait")
	     $s = $linea[1];
	  else $s = $linea[2];
	  break;
       }
    $recte = ($s == $r); 
    echo "solutio : $s";
    if ($recte) echo "<div class=\"juste\">RECTE !</div>"; 
    else echo "<div class=\"faux\"> Errauisti. Respondisti $resp$alin"; 
    include "session.php.html";
} else {
   $_SESSION['prius'] = 0;
   $_SESSION['consec'] = 0;
}
?>
<p class="question">
<?php echo $quaestio
?>
</p>
<form method="post">
<p class="question">
<?php
if (!isset($pers)) $pers = '';
echo "&nbsp;<input type=\"text\" class=\"rep\" name=\"r\" value=\"$pers\">&nbsp;";
echo "<input type=\"submit\" value=\" Num recte dixi ? \">\n";
echo "<input type=\"hidden\" name=\"priorV\" value=\"$verbe[0]\">";
echo "<input type=\"hidden\" name=\"priorT\" value=\"$thema\">";
/* // débog 
  echo "$alin solution : ";
  if ($sens == 'theme')
     echo coniug($verbe[0], $verbe[1], $verbe[2], $verbe[3],$verbe[4], $tempus, $modus, $persona);
   else echo conjF($verbe[5], $tempus, $modus, $persona);
*/
?> 
</p>
<p class="conseil">
  Si le radical demandé n'existe pas, réponds nihil.</p>
</form>
<p class="redi"><a href='./'>reditus</a> <a href="gpl.html" target="gpl">Licentia GPL</a></p>
</body>
