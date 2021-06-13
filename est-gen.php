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
// est-dat.php
// Deux types de phrases :
// Aliquis alicuius (amicus,inimicus...) est

$alin = "<br>\n";

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

$quis = array_merge($feminae, $mares);   

$mancipiaF = array (
    "amica, l'amie",
    "uicina, la voisine",
    "mater, la mère",
    "soror, la s&oelig;ur"
    );    

$mancipiaM = array (
    "amicus, l'ami",
    "auus, le grand-père",
    "discipulus, l'élève",
    "frater, le frère",
    "medicus, le médecin",
    "uicinus, le voisin"
    );    

$mancipia = array_merge($mancipiaF, $mancipiaM);    

function fr($l) {
    $r = preg_replace("/^.*\,/", "", $l);
    return $r;
}

function lat($l) {
    $r = preg_replace("/\,.*$/", "", $l);
    return $r;
}

// mancipia, gallice :
$mancipiaFr = array();
foreach($mancipia as $m)
    $mancipiaFr[] = fr($m); 
    
function sorsColl($c) {
    if (count($c) == 1) return $c[0];
    $red = $c[array_rand($c)]; 
    //return preg_replace("/\,.*$/", "", $red);
    return lat($red);
}

function decl($n, $casus) {
    $pro[0] = "/us$/";
    $pro[1] = "/a$/"; 
    if ($casus == "g") {
        $dic[0] = "i";
        $dic[1] = "ae";
    } elseif ($casus == "d") {
        $dic[0] = "o";
        $dic[1] = "ae";
    }
    $red = preg_replace($pro, $dic, $n);
    return $red;
}

function lemma($f) {
    $pro[0] = "/i$/"; $dic[0] = "us";
    $pro[1] = "/ae$/"; $dic[1] = "a";
    $red = preg_replace($pro, $dic, $f);
    return $red;
}

function sententia() {
  global $mares, $feminae, $quis, $mancipiaM, $mancipiaF;
  $fm = array('f','m');
  if (sorsColl($fm) == 'f') {
      $qui = $feminae; 
      $manc = $mancipiaF;
  } else {    
      $qui = $mares;
      $manc = $mancipiaM;
  }
  $s = sorsColl($qui);
  unset($quis[array_search($s, $quis)]);
  $att = sorsColl($manc);
  $g = decl(sorsColl($quis), 'g');
  //echo "g : $g";
  $coll = array($s, $att, 'est', $g);
  shuffle($coll);
  // rétablir $quis
  $quis = array_merge($feminae, $mares);   
  return implode(' ', $coll).'.'; 
}

function trad($l) {
    global $mancipia;
    $l = lemma($l);
    foreach ($mancipia as $el)
        if (preg_match("/^(.*)\,(.*)$/", $el, $eclats))
            //echo '-'.$eclats[1].'*'.$eclats[2].'-';
            return $eclats[2];
}

function in_mancipia($u) {
    global $mancipia;
    unset ($partes);
    foreach ($mancipia as $m) {
        if (preg_match("/^$u\,(.*)$/", $m, $partes)) {
            //echo "-".$partes[1]."-";
            return $partes[1];
            }
    }
}

function prep($n) {
    if (in_array($n[0], array('A','E','I','O','V')))
        return "d'";
    return "de ";
}

function gallice($s) {
    global $mancipiaFr, $quis, $gen;
    global $solS, $solG, $solAttr;
    $s = substr($s, 0, -1); // punctum remouere
    $coll = explode(' ', $s);
    foreach($coll as $el) {
       $a = in_mancipia($el); 
       if ($a) {
          $solAttr = $a;
          unset($a);
       }
       elseif (in_array($el, $quis)) $solS = $el;
       elseif (in_array(lemma($el), $quis)) $solG = lemma($el);
       //elseif ($el == 'est') $verbe = $el;
    }
    $prep = prep($gen);
    return "$solS est $solAttr $prep$solG."; 
}

$sententia = sententia();
session_start();
?>
<html>
<head>
<title>CRVSTVLA - EST-GEN</title>
<?php 
   include "css.inc"; 
   include "meta.inc.php";   
?>
</head>
<body>
<p class="titre">
QVIS QVID EST CVIVS ?
</p>
<?php
if (isset($_REQUEST['priorsent']))
    $priorsent = $_POST["priorsent"];
if (isset($priorsent)){
   echo "prior sententia : $priorsent$alin";
   echo "gallice : ".gallice($priorsent).$alin;
   $respS = $_POST['respS'];
   $respAttr = $_POST['respAttr'];
   $respG = $_POST['respG']; 
   $recte = ($solS == $respS && $solG == $respG && $solAttr = $respAttr);
   if ($recte)
	   echo "<div class=\"juste\">RECTE !</div>"; 
   else 
	   echo "<div class=\"faux\"> Errauisti. Respondisti " 
		   .stripslashes("$respS est $respAttr de $respG.</div>");
   include "session.php.html";
} else {
   $_SESSION['prius'] = 0;
   $_SESSION['consec'] = 0;
}

?>
<p class="question">
<?php echo $sententia;
echo "</p>\n";
echo "<form method=\"post\">\n";
echo "<p class=\"question\">\n";
echo "<select name=\"respS\">\n";
$prim = 1;
foreach ($quis as $el) {
   echo "<option value=\"$el\"";
   if ($prim) {
      echo " selected";
      $prim = 0;
   }
   echo ">$el</option>\n";
}
echo "</select>\n";

echo " est ";

echo "<select name=\"respAttr\">\n";
$prim = 1;
foreach ($mancipiaFr as $el) {
   echo "<option value=\"$el\"";
   if ($prim) {
      echo " selected";
      $prim = 0;
   }
   echo ">$el</option>\n";
}
echo "</select>\n";

echo " de/d'";

echo "<select name=\"respG\">\n";
$prim = 1;
foreach ($quis as $el) {
   echo "<option value=\"$el\"";
   if ($prim) {
      echo " selected";
      $prim = 0;
   }
   echo ">$el</option>\n";
}
echo "</select>.&nbsp;";
echo "<input type=\"submit\" value=\" Num recte dixi ? \">\n";
echo "<input type=\"hidden\" name=\"priorsent\" value=\"$sententia\">";
?>
</p></form>
<p class="redi"><a href='./'>reditus</a> <a href="gpl.html" target="gpl">Licence GPL</a></p>
</body>
</html>
