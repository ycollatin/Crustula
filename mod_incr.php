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

function sorsColl($c) {
    if (count($c) == 1) return $c[0];
    return $c[mt_rand(0, count($c)-1)];   
}

function initbilan($lex) {
    return str_repeat('0', count($lex));
}        

function binaire($bilan) {
    $totalbin = '';
    // mise en binaire
    foreach ($bilan as $i) {
            $binaire = decbin($i);
            // supprimer le 1er bit
            $binaire = substr($binaire, 1);
            $totalbin .= $binaire;
    }
    return $totalbin;
}        

function decimal($binaire) {
    $chtemp = '';
    $retour = array();
    for ($i = 0;$i<strlen($binaire);$i++) {
       $chtemp .= $binaire{$i};
       if (strlen($chtemp) == 30) {
           $chtemp = '1'.$chtemp;
           $retour[] = bindec($chtemp);
           $chtemp = '';
       }
    }            
    if ($chtemp > '') {
       $chtemp = '1'.$chtemp;
       $retour[] = bindec($chtemp);
    }
    return implode('-', $retour);
}        


function facta($bilan) {
    return substr_count($bilan, '1');
}        

function sorsbilan($lex, $bilan, $prop=20) {
    // tire une question avec $prop % de chances
    // pour un mot déjà appris.
    global $bini, $hocnouisti;
    // debog de uis
    // return $bini[180];
    $sus = array(); $nonsus = array();
    for ($i = 0; $i < count($lex); $i++) {
        if ($bilan{$i} == '0') $nonsus[] = $lex[$i];
        elseif ($bilan{$i} == '1') $sus[] = $lex[$i];
    }
    $s = mt_rand(0,100);
    //echo "*$s*";
    if (count($sus) > 7 && $s < $prop) {
        $hocnouisti = " (id nouisti)";
        return sorsColl($sus);
    }
    elseif (count($nonsus) > 0) return sorsColl($nonsus);
    else return sorsColl($bini);
    
}        

function facQ($gallice) {
    global $hocnouisti;
    return "Quomodo latine dicitur : $gallice ? $hocnouisti";
}

function solutio($gal) {
  global $bini;
  global $pos_sol;
  for($n = 0; $n < count($bini); $n++) {
     $l = $bini[$n]; 
     if ($l[3] == $gal) {
         $pos_sol = $n;
         return array($l[0],$l[1],$l[2]);
         break;
     }
  }
}        

// récupérer l'état des connaissances
if(isset($_POST["cognita"]))
    $cog = $_POST["cognita"];
if (!isset($cog)) 
   $cognita = initbilan($bini); 
else {
   $e = explode('-', $cog);
   $cognita = binaire($e); 
}


?>
<html>
<head>
<title>CRVSTVLA - VOCES III</title>
<?php 
   include "css.inc";
   include "meta.inc.php";   
?>
</head>
<body>
<p class="titre">
VOCES III
</p>
<?php
if(isset($_POST["priorQ"])) {
    $gal = $_POST["priorQ"];
    $gal = stripslashes($gal);
    $priorQ = facQ($gal);
    $r = $_POST["r"];
}
if (isset($r)) {
    $resp = $r;
    $r = stripslashes($r);
    $r = strtolower(trim($r));
    #$ecl = explode(" ",$r); 
    $ecl = preg_split("/[\s,\.]+/", $r);
    while (count($ecl) < 3) $ecl[] = '-';
    $s = solutio($gal);
    echo "prior quaestio : $priorQ$alin";
    echo "solutio : " . implode(', ', $s) . $alin;
    $recte = ($s[0] == $ecl[0] && $s[1] == $ecl[1] && $s[2] == $ecl[2]); 
    if ($s[0] == 'uis') {
      $recte = ($s[0] == $ecl[0] && $s[2] == $ecl[2]);
      $conseil = "VIS N'A PAS DE GÉNITIF SINGULIER !$alin$conseil";
    }
    if ($recte) {
            //echo "pos_sol : $pos_sol $alin";
            $cognita{$pos_sol} = '1';
	    echo "<div class=\"juste\">RECTE !</div>"; 
    } else {
	    echo "<div class=\"faux\"> Errauisti. Respondisti $resp</div>$alin"; 
            $cognita{$pos_sol} = '0';
    }
    $facta = facta($cognita);
    $discenda = count($bini)-$facta;
    echo "$facta cognita, $discenda discenda.";
    if ($discenda == 0) echo " Omnia uerba nouisti.";
}
$linea = sorsbilan($bini, $cognita);
$gallice = $linea[3];
$quaestio = facQ($gallice);
?>
<p class="questmin">
<?php echo $quaestio ?>
</p>
<form method="post">
<p class="questmin">
<?php
echo "<input class=\"questmin\" type=\"text\" size=\"30\" name=\"r\">&nbsp;";
echo "<input type=\"submit\" value=\" Num recte dixi ? \">\n";
echo "<input type=\"hidden\" name=\"priorQ\" value=\"$gallice\"\n>";
$cog = decimal($cognita); 
echo "<input type=\"hidden\" name=\"cognita\" value=\"$cog\">";
echo "</p>\n</form>";
echo "<p class=\"conseil\">$conseil</p>";
?> 
<p class="redi"><a href='./'>reditus</a> <a href="gpl.html" target="gpl">Licentia GPL</a></p>
<?php
/*
// debog
echo $alin."------------------".$alin;
   echo $cognita;
*/   
?>
</body>
