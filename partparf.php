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
// Étude des participes parfaits.
$alin = "<br>\n";
$data = array(
"moueo, es, ere, moui, motum : émouvoir",
"accipio, is, ere, accepi, acceptum : recevoir",
"frango, is, ere, fregi, fractum : briser",
"augeo, es, ere, auxi, auctum : augmenter",
"sentio, is, ire, sensi, sensum : percevoir",
"uinco, is, ere, uici, uictum : vaincre",
"uoco, as, are : appeler",
"tango, is, ere, tetigi, tactum : toucher",
"diuido, is, ere, diuisi, diuisum : diviser",
"conloco, as, are : placer",
"maneo, es, ere, mansi, mansum : rester",
"specto, as, are : regarder",
"incipio, is, ere, incepi, inceptum : commencer",
"aspicio, is, ere, aspexi, aspectum : regarder",
"sumo, is, ere, sumpsi, sumptum : prendre",
"depello, is, ere, depuli, depulsum : chasser",
"constituo, is, ere, tui, tutum : organiser",
"deleo, es, ere, evi, etum : détruire",
"audio, is, ire, audiui, auditum : venir",
"trado, is, ere, didi, ditum : transmettre",
"adduco, is, ere, duxi, ductum : conduire",
"defendo, is, ere, fendi, fensum : défendre",
"soluo, is, ere, solui, solutum : payer",
"reddo, is, ere, reddidi, redditum : rendre",
"inuenio, is, ire, ueni, uentum : trouver",
"uideo, es, ere, uidi, uisum : voir",
"rogo, as, are : interroger",
"cupio, is, ere, cupi(u)i, cupitum : désirer",
"sustineo, es, ere, tinui, tentum : soutenir",
"deicio, is, ere, ieci, iectum : chasser",
"muto, as, are : changer",
"traho, is, ere, traxi, tractum : tirer",
"relinquo, is, ere, reliqui, relictum : abandonner");

$gal = array(
"moueo,motum,ému",
"accipio,acceptum,reçu",
"frango,fractum,brisé",
"augeo,auctum,augmenté",
"sentio,sensum,perçu",
"uinco,uictum,vaincu",
"uoco,uocatum,appelé",
"tango,tactum,touché",
"diuido,diuisum,divisé",
"conloco,conlocatum,placé",
"maneo,mansum,resté",
"specto,spectatum,regardé",
"incipio,inceptum,commencé",
"aspicio,aspectum,regardé",
"sumo,sumptum,pris",
"depello,depulsum,chassé",
"constituo,tutum,organisé",
"deleo,deletum,détruit",
"audio,auditum,entendu",
"trado,traditum,transmis",
"adduco,adductum,conduit",
"defendo,defensum,défendu",
"soluo,solutum,payé",
"reddo,redditum,rendu",
"inuenio,inuentum,trouvé",
"uideo,uisum,vu",
"rogo,rogatum,interrogé",
"cupio,cupitum,désiré",
"sustineo,sustentum,soutenu",
"deicio,deiectum,chassé",
"muto,mutatum,changé",
"traho,tractum,tiré",
"relinquo,relictum,abandonné");

function sorsColl($c) {
    if (count($c) == 1) return $c[0];
    $red = $c[array_rand($c)]; 
    return $red;
}

$linea = sorsColl($data);
$lingua = sorsColl(array('l','g'));
$genus = sorsColl(array('m','f','n'));

function lineag($l) {
   global $gal;
   $eclats = explode(",", $l); 
   $lemme = $eclats[0];
   foreach($gal as $g){
      $eclats = explode(",", $g);
      if ($eclats[0] == $lemme) 
         return $eclats; 
   }
   return "quaerendo inueneris";
}

if ($lingua == "l"){
   $lineag = lineag($linea);
   $quaestio = $lineag[1]; 
   if ($genus == 'f') 
      $quaestio = preg_replace('/um$/','a',$quaestio);
   elseif ($genus == 'm')
      $quaestio = preg_replace('/m$/','s', $quaestio);
} else { // $lingua == "g"
   $quaestio = "$linea<br>participe parfait ";
   if ($genus == "f") $quaestio .= "féminin ?"; 
   elseif ($genus == "m") $quaestio .= "masculin ?";
   else $quaestio .= "neutre ?";
}

function forme($pp, $genre) {
   if ($genre == 'f') return $pp.'e';
   return $pp;
}

function solutio($q) {
   global $gal;
   if (preg_match("/(<br>)/", $q)) {
           // latinum responsum 
	   // genus ?
	   preg_match("/([é\w]*)\s\?$/", $q, $genus);
	   $genus = $genus[1];
	   $eclats = explode(',', $q);
	   $lemme = $eclats[0];
	   $lineag = lineag($lemme);
	   $supin = $lineag[1];
	   if ($genus == 'féminin') 
		   return preg_replace("/um$/","a",$supin);
	   if ($genus == 'masculin')
		   return preg_replace("/um$/","us",$supin);
	   return $supin;
   } else {
      // français demandé
      if (preg_match("/(a)$/", $q)) {
         $genus = 'f';
	 $supin = preg_replace("/a$/","um",$q);
      } elseif (preg_match("/(us)$/", $q)) {
         $genus = 'm';
	 $supin = preg_replace("/us$/","um",$q);
      } else {
         $genus = 'n';
	 $supin = $q;
      }
      // chercher le supin dans la liste
      foreach ($gal as $linea) {
         $eclats = explode(',',$linea);
	 if ($eclats[1] == $supin)
	    return forme($eclats[2], $genus);
      }
   }
   return "quaerendo inueneris";
}

if (isset($_POST["priorQ"])) {
    $priorQ = stripslashes($_POST["priorQ"]);
    $resp = stripslashes($_POST["resp"]);
    $resp = trim($resp);
}
session_start();
?>
<html>
<head>
<title>CRVSTVLA - PARTICIPIA</title>
<?php 
   include "css.inc";
   include "meta.inc.php";   
?>
</head>
<body>
<p class="titre">
PARTICIPIA
</p>
<?php
if (!empty($priorQ)){
   echo "prior sententia,$priorQ $alin";
   $solutio = solutio($priorQ);
   echo $solutio.$alin;
   $recte = ($resp == $solutio || $resp == "ayant été $solutio");
   if ($recte)
	   echo "<div class=\"juste\">RECTE !</div>"; 
   else 
	   echo "<div class=\"faux\"> Errauisti. Respondisti $resp.</div>\n";
   include "session.php.html";
} else {
   $_SESSION['prius'] = 0;
   $_SESSION['consec'] = 0;
}
?>
<p class="question">
   <?php 
   if ($lingua == "l") echo "$linea $alin";
   echo $quaestio; ?> 
</p>
<form method="post" class="forma">
<p class="question">
<?php
if ($lingua == "l") echo "traduction : ";
echo "<input type=\"text\" class=\"question\" name=\"resp\">";
echo "&nbsp;<input type=\"submit\" value=\" Num recte dixi ? \">\n";
echo "<input type=\"hidden\" name=\"priorQ\" value=\"$quaestio\">";
?>
</p>
</form>
<p class="redi"><a href='./'>reditus</a> <a href="gpl.html" target="gpl">Licentia GPL</a></p>
</body>
</html>
