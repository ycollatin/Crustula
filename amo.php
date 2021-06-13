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
$cVerbum = array(
   'amo',
   'amas',
   'amat',
   'amamus',
   'amatis',
   'amant');

$mares = array (
   'Gaius',
   'Marcus',
   'Publius',
   'Sempronius',
   'Titus');

$feminae = array (
   'Arria',
   'Caecilia',
   'Cornelia',
   'Lepida',
   'Seuera');

$omnes = array_merge($feminae, $mares);   
natsort($omnes);

function sorsColl($c) {
    if (count($c) == 1) return $c[0];
    $red = $c[array_rand($c)]; 
    return $red;
}

function acc($n) {
    $pro[0] = "/(us)$/"; $dic[0] = "um";
    $pro[1] = "/(a)$/"; $dic[1] = "am";
    $red = preg_replace($pro, $dic, $n);
    return $red;
}

function sententia() {
   global $cVerbum, $feminae, $mares, $omnes;
   $uerbum = sorsColl($cVerbum);
   $obiect = sorsColl($omnes);
   $obiect = acc($obiect);
   $collRed = array($obiect, $uerbum);
   if ($uerbum == 'amat' && sorsColl(array('s', 'c')) == 'c') {
         if (substr($obiect, -2) == 'am')
	     $subiect = sorsColl($mares);
	 else $subiect = sorsColl($feminae);
   }
   if ($uerbum == 'amant' && sorsColl(array('s', 'c')) == 'c') {
         if ($obiect{strlen($obiect)-2} == 'a') {
	     $cs = array_rand($mares, 2);
	     $subiect = $mares[$cs[0]].' '.$mares[$cs[1]].'que';
	     $obiect = sorsColl($feminae);
	     $obiect = acc($obiect);
	 } else {
	     $cs = array_rand($feminae, 2);
	     $subiect = $feminae[$cs[0]].' '.$feminae[$cs[1]].'que';
	     $obiect = sorsColl($mares);
	     $obiect = acc($obiect);
	 }
   }
   if (isset($subiect))
       $collRed = array($subiect, $obiect, $uerbum);
   shuffle($collRed);
   return implode(' ', $collRed).'.';
}

$sententia = sententia();

function galV($u) {
    $pro[1] = "/\b(\w*o)$/"; $dic[1] = "J'aime";
    $pro[2] = "/\b(\w*as)$/"; $dic[2] = "Tu aimes";
    $pro[3] = "/\b(\w*at)$/"; $dic[3] = "aime";
    $pro[4] = "/\b(\w*amus)$/"; $dic[4] = "Nous aimons";
    $pro[5] = "/\b(\w*atis)$/"; $dic[5] = "Vous aimez";
    $pro[6] = "/\b(\w*ant)$/"; $dic[6] = "aiment";
    $red = preg_replace($pro, $dic, $u);
    return $red;
}

function galQue($c) {
    $coll = explode(' ', $c);
    $coll[1] = preg_replace("/que$/", "", $coll[1]);
    return $coll[0]." et ".$coll[1];
}

function gallice($sent) {
    // extraire le verbe
    $sent = preg_replace("/(\.)$/", "", $sent);
    preg_match("/\b(am\w*)\b/", $sent, $partes);
    $verbe = $partes[1];
    $uerbum = $verbe;
    $verbe = galV($verbe);
    $sent = preg_replace("/$uerbum/", "", $sent);
    // extraire le cod
    preg_match("/\b(\w*[ua]m)\b/", $sent, $partes);
    $cod = $partes[1];
    // extraire sujet
    $sujet = preg_replace("/$cod/", "", $sent);
    $sujet = trim($sujet);
    if (preg_match("/(que)\s?$/", $sujet)) $sujet = galQue($sujet);
    // remettre cod au nominatif
    $cod = preg_replace("/(um)$/", "us", $cod);
    $cod = preg_replace("/(am)$/", "a", $cod);
      
    // crÃ©er pronom-sujet 3e personne
    if (strlen($sujet) < 2) {
        if (trim($verbe) == "aime") {
             if (substr($verbe, -1) == 'e') {
                 if (substr($cod, -1) == 'a') $sujet = "Il ";
	         else $sujet = "Elle ";
             }
        } elseif (trim($verbe) == "aiment") {
             if (substr($cod, -1) == 'a') $sujet = "Ils ";
	     else $sujet = "Elles ";
        }
    }
    return "$sujet $verbe $cod.";
}

function egalise($c) {
   $c = stripslashes($c);
   $c = strtolower($c);
   $c = trim($c);
   //echo "-$c-";
   $c = preg_replace("/(\s\s*)/", " ", $c);
   $c = preg_replace("/(\.)$/", "", $c);
   $c = preg_replace("/il/", "elle", $c);
   return $c;
}
session_start();
?>
<html>
<head>
<title>CRVSTVLA - AMO, AMAS...</title>
<?php 
   include "css.inc";
   include "meta.inc.php";
?>
</head>
<body>
<p class="titre">
QVIS QVEM AMAT (II) 
</p>
<?php
if (isset($_REQUEST['priorsent']))
    $priorsent = $_POST["priorsent"];
if (isset($priorsent)){
   $resp = $_POST["resp"];
   $gallice = gallice($priorsent);
   echo "prior sententia : ".$priorsent.$alin;
   echo "gallice : ".gallice($priorsent).$alin;
   $recte = egalise($resp) == egalise($gallice);
   if ($recte)
	   echo "<div class=\"juste\">RECTE !</div>"; 
   else 
	   echo "<div class=\"faux\"> Errauisti. Respondisti : $resp</div>";
   include "session.php.html";
} else {
   $_SESSION['prius'] = 0;
   $_SESSION['consec'] = 0;
}
?>
<p class="question">
<?php
    echo $sententia.$alin;
    //echo gallice($sententia);
?>
</p>
<form method="post">
<p class="question">
Traduction : <input type="text" class="question" name="resp">&nbsp;
<input type="submit" value="Num recte dixi ?">
<input type="hidden" value="<?php echo $sententia ?>" name="priorsent">
</p>
</form>
<p class="redi"><a href='./'>reditus</a> <a href="gpl.html" target="gpl">Licentia GPL</a></p>
</body>
</html>
