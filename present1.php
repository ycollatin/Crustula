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
   array("habeo","moneo","hab","habu","habit","avoir"), 
   array("dimitto","lego","dimitt","dimis","dimiss","renvoyer"),
   array("accipio","capio","accip","accep","accept","recevoir"),
   array("frango","lego","frang","freg","fract","briser"),
   array("augeo","moneo","aug","aux","auct","augmenter"),
   array("uiuo","lego","uiu","uix","uict","vivre"), 
   array("tango","lego","tang","tetig","tact","toucher"), 
   array("maneo","moneo","man","mans","mans","rester"), 
   array("incipio","capio","incip","incep","incept","commencer"),
   array("aspicio","capio","aspic","aspex","aspect","regarder"),
   array("deleo","moneo","del","deleu","delet","détruire"),
   array("uenio","audio","uen","uen","uent","venir"),
   array("trado","lego","trad","tradid","tradit","transmettre"),
   array("reddo","lego","redd","reddid","reddit","rendre"),
   array("inuenio","audio","inuen","inuen","inuent","trouver"),
   array("ago","lego","ag","eg","act","agir"),
   array("cupio","capio","cup","cupiu","cupit","désirer"),
   array("traho","lego","trah","trax","tract","tirer"),
   array("iungo","lego","iung","iunx","iunct","joindre"),
   array("cerno","lego","cern","creu","cret","distinguer"),
   array("iubeo","moneo","iub","iuss","iuss","ordonner"),
   array("uideo","moneo","uid","uid", "uis","voir"),
   array("respondeo","moneo","respond","respond", "respons","répondre"),
   array("do","amo","d","ded","dat","donner"),
   array("doceo","moneo","doc","docu","doct","enseigner"),
   array("opto","amo","opt","optau","optat","souhaiter"),
   array("colo","lego","col","colu","cult","cultiver"),
   array("perdo","lego","perd","perdid","perdit","ruiner"),
   array("praebeo","moneo","praeb","praebu","praebit","fournir"),
   array("diligo","lego","dilig","dilex","dilect","aimer"),
   array("debeo","moneo","deb","debu","debit","devoir"),
   array("pugno","amo","pugn","pugnau","pugnat","combattre"),
   array("tollo","lego","toll","sustul","sublat","emporter"),
   array("torqueo","moneo","torqu","tors","tort","tourmenter"),
   array("contingo","lego","conting","contig","contact","atteindre"),
   array("cresco","lego","cresc","creu","cret","augmenter"),
   array("spero","amo","sper","sperau","sperat","espérer"),
   array("contemno","lego","contemn","contemps","contempt","mépriser"),
   array("timeo","moneo","tim","timu","","craindre"),
   array("amitto","lego","amitt","amis","amiss","perdre"),
   array("probo","amo","prob","probau","probat","prouver"),
   array("peto","lego","pet","petiu","petit","rechercher"),
   array("credo","lego","cred","credid","credit","confier"),
   array("interficio","capio","interfic","interfec","interfect","tuer"),
   array("fallo","lego","fall","fefell","fals","tromper"),
   array("cano","lego","can","cecin","cant","chanter"),
   array("curro","lego","curr","cucurr","curs","courir"),
   array("pono","lego","pon","posu","posit","poser"),
   array('sum','sum','','fu','','être')
);

function sorsColl($c) {
    if (count($c) == 1) return $c[0];
   return $c[mt_rand(0, count($c)-1)];   
}

function primitifs($linea) 
{
    return  sprintf("%s, %s, %s, %s, %s : %s",
        $linea[0],
        coniug($linea[0], $linea[1], $linea[2], $linea[3], $linea[4], 
            'présent','indicatif','2'),
        coniug($linea[0], $linea[1], $linea[2], $linea[3], $linea[4], 
            'présent','infinitif',''),
        coniug($linea[0], $linea[1], $linea[2], $linea[3], $linea[4], 
            'parfait','indicatif','1'),
        $linea[4].'um',
        $linea[5]);
}

$sens = sorsColl(array('theme','version'));
$verbe = sorsColl($diclat);
//$humain = "$verbe[0], modèle $verbe[1], parfait $verbe[3]i : $verbe[5] ";
include "coniug.php";
//$tempus = sorsColl($tempora);
$tempus = 'présent';
$modus = 'indicatif';
$persona = sorsColl(array(1,2,3,4,5,6));
if ($sens == 'theme') {
    $forme = conjF($verbe[5], $tempus, $modus, $persona);
    $quaestio = elide($personne[$persona], $forme);
} else {
    $forme = coniug($verbe[0], $verbe[1], $verbe[2], $verbe[3],$verbe[4], $tempus, $modus, $persona);
    $quaestio = $forme;
}
$quaestio = $quaestio.$alin.primitifs($verbe);
session_start();
?>

<html>
<head>
  <title>CRVSTVLA - PRAESENS TEMPVS</title>
<?php 
   include "css.inc";
   include "meta.inc.php";   
?>
</head>
<body>
<p class="titre">
 O TEMPORA
</p>
<?php
if(isset($_POST["r"])) {
    $r = $_POST["r"];
    $priorQ = $_POST["priorQ"];
    $priorQ = stripslashes($priorQ);
    $priorV = $_POST["priorV"];
    $priorV = explode(',', $priorV);
    $priorT = $_POST["priorT"];
    $priorP = $_POST["priorP"];
    $priorS = $_POST["priorS"];
    $r = stripslashes($r);
    $resp = $r;
    $r = strtolower(trim($r));
    echo "prior quaestio : $priorQ";
    if ($priorS == 'version')
    $s =  elide($personne[$priorP], conjF($priorV[5], $priorT, 'indicatif', $priorP));
    else $s = coniug(
        $priorV[0], $priorV[1], $priorV[2], $priorV[3],$priorV[4], 
	$priorT, 'indicatif', $priorP);
    $recte = ($s == $r); 
    echo "$alin solutio : $s";
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
$pers = '';
if ($sens == 'version' && ($persona == 3 || $persona == 6))
  $pers = $personne[$persona];
echo "&nbsp;<input type=\"text\" class=\"rep\" name=\"r\" value=\"$pers\">&nbsp;";
echo "<input type=\"submit\" value=\" Num recte dixi ? \">\n";
echo "<input type=\"hidden\" name=\"priorQ\" value=\"$quaestio\">";
$pv = implode(',', $verbe);
echo "<input type=\"hidden\" name=\"priorV\" value=\"$pv\">";
echo "<input type=\"hidden\" name=\"priorT\" value=\"$tempus\">";
echo "<input type=\"hidden\" name=\"priorP\" value=\"$persona\">";
echo "<input type=\"hidden\" name=\"priorS\" value=\"$sens\">";

?> 
</p>
<p class="conseil">
  Toutes les questions sont au présent de l'indicatif.</p>
</form>
<p class="redi"><a href='./'>reditus</a> <a href="gpl.html" target="gpl">Licentia GPL</a></p>
</body>
