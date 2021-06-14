<?php
/*
                     capsa sov1.php

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
$nomina = array(
   array('pat-er-rem', 'm', 'mon père'),     // 0
   array('mat-er-rem', 'f', 'ma mère'),      // 1
   array('frat-er-rem', 'm', 'mon frère'),   // 2
   array('sor-or-orem', 'm', 'ma soeur'),    // 3
   array('filiu-s-m', 'n', 'mon fils'),      // 4
   array('fili-a-am', 'f', 'ma fille'),      // 5
   array('ux-or-orem',  'f', 'ma femme'),    // 6
);

$uerbum = 'dilig-o-is-it-imus-itis-unt';

$verbe = array("j'aime",'tu aimes','aime','nous aimons', 'vous aimez','ils aiment');

function sors ($c) 
{
    if (count ($c) == 1) return 0;
    return mt_rand(0, count ($c)-1);
}

function sorsColl($c) {
    return $c[sors ($c)];   
}


function decl($nomen, $k) 
{
    $eclats = explode ('-', $nomen[0]);
    $radical = $eclats[0];
    if ($k == 'n') return $radical.$eclats[1];
    return $radical.$eclats[2];
}

function conj($u, $p, $n)
{
    global $uerbum;
    $eclats = explode ('-', $uerbum);
    $radical = $eclats[0];
    if ($n == 's') return $radical.$eclats[$p];
    return $radical.$eclats[$p+3];
}

function conjG($v, $p, $n)
{
    global $verbe;
    if ($n == 's') return $verbe[$p-1];
    return $verbe[$p + 2];
}

function sAbstract() 
{
     // tire les numéros des éléments S, O et V;
     // S et O sont accompagnés de leur nombre.
     global $nomina, $uerbum;
     // persona 
     $r['p'] = sorsColl (array (1, 2, 3, 3, 3, 3, 3));
     if ($r['p'] != 3) $r['n'] = sorsColl( array ('s', 'p'));
     else $r['n'] = sorsColl('s','s','s','s','s','s','p');
     // subiectum
     if ($r['p'] == 3 && $r['n'] == 's') $r['S'] = sors ($nomina);
     else $r['S'] = '';
     // obiectum
     do 
     {
         $r['O'] = sors ($nomina);
     }
     while ($r['O'] == $r['S']);
     $r['schema'] = implode (':', array($r['S'], $r['O'], $r['p'], $r['n']));
     return $r;
}

function schema_abs ($sch)
{
   $r['schema'] = $sch;
   $eclats = explode (':', $sch);
   return array (
       'S' => $eclats[0], 
       'O' => $eclats[1],
       'p' => $eclats[2],
       'n' => $eclats[3],
       'schema' => $sch);
}

function sLat($sAb)
{
   global $nomina;
   // uerbum 
   $fVerbum = conj ('diligo', $sAb['p'],  $sAb['n']);
   // subiectum
   if ($sAb['p'] == 3 && $sAb['n'] == 's')
       $sub = decl($nomina[$sAb['S']], 'n');
   else $sub = '';
   // obiectum
   $obj = decl($nomina[$sAb['O']], 'ac');
   // ordinem
   $tabula = array($sub, $obj, $fVerbum);
   shuffle($tabula);
   // finis
   return trim(implode(' ', $tabula)).'.';
}

function sGal($sAb)
{
   global $nomina, $verbe;
   // uerbum sortitur
   // verbe
   $formeV = conjG ('diligo', $sAb['p'], $sAb['n']);
   // sujet
   if ($sAb['n'] == 's') 
   {
       if ($sAb['p'] == 3) $sujet = $nomina[$sAb['S']][2].' ';
   }
   // objet 
   $objet = $nomina[$sAb['O']][2];
   // retour
   return ucfirst("$sujet$formeV $objet.");
}

$meta = sorsColl(array('latine','gallice'));
$sAb = sAbstract(); 
if ($meta == 'latine') $sententia = sGal($sAb);
else $sententia = sLat($sAb);

session_start();
?>
<html>
<head>
<title>CRVSTVLA - SOV</title>
<?php 
   include "css.inc";
   include "meta.inc.php";   
?>
</head>
<body>
<p class="titre">
    SENTENTIAE SOV DICTAE (bis)
</p>
<?php
if (isset($_POST["schema"])) 
   $schema = $_POST["schema"]; 
if (isset($schema)) {
    $resp = $_POST['resp']; 
    $resp = trim($resp);
    $resp = stripslashes($resp);
    // solutionem ab sententia
    $priorAbs = schema_abs ($schema); 

    $pMeta = $_POST['meta'];
    if ($pMeta == 'latine') 
    {
        // alphabeticum ordinem ut comparatio pertinens fiat.
        $sol = sLat($priorAbs);
        $solC = str_replace('.', '', $sol);
        $tabS = explode (' ', $solC);
        natcasesort($tabS);
        $solC = implode(' ', $tabS);

        $respC = str_replace('.', '', $resp);
        //$tabR = explode(' ', $respC);
        $tabR = preg_split("/[\s]+/", $respC);
        natcasesort($tabR);
        $respC = implode(' ', $tabR);
    }
    else 
    { 
        $sol = sGal($priorAbs);
        $solC = str_replace('.', '', $sol);
        $respC = str_replace('.', '', $resp);
        // éliminer les espace surnuméraires;
        $respC = preg_replace("/\s+/",' ',$respC); 
    }
    $solC = trim ($solC);
    $respC = trim ($respC);
    echo "Prior Sententia : $priorSent $alin";
    echo "Solutio : &laquo;$sol&raquo;$alin";
    // $recte = ($sol == $resp);
    $recte = strcasecmp($solC, $respC) == 0;
    if ($recte)
        echo "<div class=\"juste\">RECTE !</div>"; 
    else 
        echo "<div class=\"faux\"> Errauisti. Respondisti &laquo;$resp&raquo;</div>";
    include "session.php.html";
} else {
   $_SESSION['prius'] = 0;
   $_SESSION['consec'] = 0;
}
?>
</p>
<p class="question">
   <?php 
   echo $sententia;
   // echo "<br>\n".$sAb['num']; // debog
   ?> 
</p>
<form method="post">
<p class="question">
<input type="text" size="45" name="resp">
<?php
echo "<input type=\"submit\" value=\" Num recte dixi ? \">\n";
echo "<input type=\"hidden\" name=\"meta\" value=\"$meta\">\n";
echo "<input type=\"hidden\" name=\"schema\" value=\"".$sAb['schema']."\">\n";
?>
</p>
</form>
<div class="conseil">Tous les déterminants sont des déterminants possessifs !<br />
                     pour "aimer", utilise le verbe <em>diligo</em>.</div>
<p class="redi"><a href='./'>reditus</a> <a href="gpl.html" target="gpl">Licentia GPL</a></p>
</body>
</html>
