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
$sum = array(
   'Je' =>'suis',
   'Tu' =>'es',
   'Elle' =>'est',
   'Nous' =>'sommes',
   'Vous' =>'êtes',
   'Elles' =>'sont');

$homines = array(
      'une amie'=>'amica',
      'un dieu'=>'deus',
      'une fille'=>'puella',
      'un esclave'=>'seruus');

$alia = array(
    'un cheval'=>'equus',
    'une forêt'=>'silua',
    'une route'=>'uia',
    'une île'=>'insula');

$omnia = array_merge($homines, $alia);    
$ainmo = array_flip($omnia); 

function plur($n) {
    if ($n == 'un dieu') return 'des dieux';
    if ($n == 'un cheval') return 'des chevaux';
    $pro[0] = '/^(un)\s/'; $dic[0] = 'des ';
    $pro[1] = '/^(une)\s/'; $dic[1] = 'des ';
    $red = preg_replace($pro, $dic, $n);
    return $red.'s';
}

function plurL($n) {
    $pro[0] = '/(a)$/'; $dic[0] = 'ae';
    $pro[1] = '/(us)$/'; $dic[1] = 'i';
    $red = preg_replace($pro, $dic, $n);
    return $red;
}

function sing($n) {
    global $ainmo;
    $n = preg_replace("/^(des|une?\s)/", "", $n);
    $n = trim($n);
    if ($n == 'chevaux') return 'un cheval';
    if ($n == 'dieux') return 'un dieu';
    $n = preg_replace("/(s)$/", "", $n);
    foreach($ainmo as $item) {
       if (preg_match("/($n)$/", $item)) return $item;
    }
}

function sorsColl($c) {
    if (count($c) == 1) return $c[0];
   return $c[mt_rand(0, count($c)-1)];   
}

function sententia() {
    global $sum, $homines, $omnia;
    $pron = sorsColl(array_keys($sum));
    $uerb = $sum[$pron];
    switch($pron) {
        case "Je":
        case "Tu":
            $attr = array_rand($homines);
            $subiect = $pron." ";
            break;
        case "Elle":
            $attr = array_rand($omnia); 
            $subiect = "C'";
            break;
        case "Nous":
        case "Vous":
            $attr = plur(array_rand($homines));
            $subiect = $pron." ";
            break;
        case "Elles":
            $attr = plur(array_rand($omnia)); 
            $subiect = "Ce ";
            break;
    }
    return "$subiect$uerb $attr."; 
}

$sententia = sententia();

function latine($sent) {
    global $omnia, $attr;
    $pro[0] = '/^(Je suis)\s/'; $dic[0] = 'sum ';
    $pro[1] = '/^(Tu es)\s/'; $dic[1] = 'es ';
    $pro[2] = "/^(C'est)\s/"; $dic[2] = 'est ';
    $pro[3] = "/^(Nous sommes)\s/"; $dic[3] = 'sumus ';
    $pro[4] = "/^(Vous êtes)\s/"; $dic[4] = 'estis ';
    $pro[5] = "/^(Ce sont)\s/"; $dic[5] = 'sunt ';
    $red = preg_replace($pro, $dic, $sent);
    $red = preg_replace("/(\.)$/", "", $red);

    preg_match("/\s(.*)$/", $red, $partes);
    $red = preg_replace("/(\s.*)$/", "", $red);
    $refAttr = $attr;
    $attr = sing($partes[1]);
    $attrl = $omnia[$attr];
    if ($attr != $partes[1]) 
       $attrl = plurL($attrl);
    $red = "$attrl $red.";

    return $red;
}
if (isset($_REQUEST['priorsent'])) {
     $priorsent = $_POST["priorsent"]; 
     $priorsent = stripslashes($priorsent);
     $r = $_POST["r"];
}
function recte($resp, $solut) {
    $resp = trim($resp);
    $resp = strtolower($resp);
    $resp = preg_replace("/(\.)$/", "", $resp);
    //echo "-$resp-$solut-";
    $resp = preg_split("/\s+/", $resp);
    sort($resp);
    $resp = implode(" ", $resp);
    //print_r($resp);

    $solut = substr($solut, 0, -1);
    $solut = strtolower($solut);
    //echo "-$solut-";
    $solut = explode(" ", $solut);
    //print_r($solut);
    sort($solut);
    $solut = implode(" ", $solut);
    //print_r($solut);
    if ($resp == $solut) return true;
    return false;
}
session_start();  
  ?>
<html>
<head>
<title>CRVSTVLA - SVM</title>
<?php 
   include "css.inc";
   include "meta.inc.php";
?>
</head>
<body>
<p class="titre">
QVIS, QVID EST ?
</p>
<?php
if (isset($priorsent)){
   echo "prior sententia : $priorsent $alin";
   //echo "recte -".recte($rs, $ra, $priorsent)."-$alin";
   $s = latine($priorsent);
   $recte = (recte($r, $s));
   if ($recte)
	   echo "<div class=\"juste\">RECTE !</div>"; 
   else {
	   echo "latine : $s$alin";
	   echo "<div class=\"faux\"> Errauisti. Respondisti $r"; 
   }
   include "session.php.html";
} else {
   $_SESSION['prius'] = 0;
   $_SESSION['consec'] = 0;
}
?>
<p class="question">
<?php echo $sententia; ?>
</p>
<form method="post">
<p class="question">
<?php
echo "<input type=\"text\" name=\"r\">&nbsp;";
echo "<input type=\"submit\" value=\" Num recte dixi ? \">\n";
echo "<input type=\"hidden\" name=\"priorsent\" value=\"$sententia\">";
?> 
</p>
</form>
<p class="redi"><a href='./'>reditus</a> <a href="gpl.html" target="gpl">Licentia GPL</a></p>
</body>
</html>
