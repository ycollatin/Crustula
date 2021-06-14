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
$nomina = array(
   array('pat-er-rem-res-res', 'm', 'père'), // 0
   array('mat-er-rem-res-res', 'f', 'mère'),  // 1
   array('soro-r-rem-res-res', 'f', 'sœur'),           // 2
   array('praecepto-r-rem-res-res', 'm', 'professeur'),          // 3
   array('discipul-us-um-i-os', 'm', 'élève'),          // 4
   array('matron-a-am-ae-as', 'f', 'dame'),     // 5
   array('mil-es-item-ites-ites',  'm', 'soldat'),         // 6
   array('nutri-x-cem-ces-ces', 'f', 'nourrice'),        // 7
   array('amit-a-am-ae-as', 'f', 'tante'),       // 8
   array('patron-us-um-i-os', 'm', 'avocat')       // 9
);

$uerba = array(
   array('audio, is, ire : entendre',array(0,1,2,3,4,5,6,7,8,9),array(1,2,3,4,5,6,7,8,9)),
   array('diligo, is, ere : aimer',array(0,1,2,3,4,5,6,7,8,9),array(1,2,3,4,5,6,7,8,9)),
   array('uoco, as, are : appeler',array(0,1,2,3,4,5,6,7,8,9),array(1,2,3,4,5,6,7,8,9)),
   array('uideo, es, ere : voir',array(0,1,2,3,4,5,6,7,8,9),array(1,2,3,4,5,6,7,8,9)),
   array('duco, is, ere : conduire',array(0,1,2,3,4,5,6,7,8,9),array(1,2,3,4,5,6,7,8,9))
);

$conjug = array(
   'entendre'=>array('entends','entends','entend','entendons','entendez','entendent'),
   'aimer'=>array('aime','aimes','aime','aimons','aimez','aiment'),
   'appeler'=>array('appelle','appelles','appelle','appelons','appelez','appellent'),
   'voir'=>array('vois','vois','voit','voyons','voyez','voient'),
   'conduire'=>array('conduis','conduis','conduit','conduisons','conduisez','conduisent')
);

function sorsColl($c) {
    if (count($c) == 1) return $c[0];
    return $c[mt_rand(0, count($c)-1)];   
}

function decl($nomen, $k, $n) 
{
    $eclats = explode ('-', $nomen[0]);
    $radical = $eclats[0];
    if ($k == 'n') 
    {
        if ($n == 's') return $radical.$eclats[1];
        return $radical.$eclats[3];
    }
    if ($n == 's') return $radical.$eclats[2];
    return $radical.$eclats[4];
}

function conj($u, $p, $n)
{
   $des = array (
       's'=> array('o','s','t'),
       'p'=> array('mus','tis','nt'));
   $eclats = explode(',', $u[0]);
   $pp = $eclats[0];
   // canonica forma
   if ($n == 's' && $p == 1) return $pp;
   // ligationis uocalis
   if ($n == 'p' && $p == 3)
   {
       if ($pp == 'diligo') return 'diligunt';
       if ($pp == 'audio') return 'audiunt';
       if ($pp == 'duco') return 'ducunt'; 
       $uoc = 'u';
   }
   if ($pp == 'uoco') $uoc = 'a';
   elseif ($pp == 'uideo') $uoc = 'e';
   else $uoc = 'i';
   // radix
   $radix = preg_replace("/[ei]?o$/", "", $pp);
   return $radix.$uoc.$des[$n][$p-1];
}

function conjG($v, $p, $n)
{
    // calculer le rang de la personne
    $entree = $v[0];
    $eclats = explode(' : ', $entree);
    $inf = $eclats[count($eclats)-1];
    if ($n == 's') $pn = $p-1;
    else $pn = $p+2;
    global $conjug;
    return $conjug[$inf][$pn];
}

function nombre($nom, $n)
{
    // met éventuellement au pluriel
    $nomF = $nom[2];
    // déterminant
    if ($n == 's')
    {
       if ($nom[1] == 'f') 
       $det = 'la ';
       else $det = 'le ';
       if ($nomF == 'guerre') return 'la guerre';
    }
    else $det = 'les ';
    // élision
    if (($det == 'la ' || $det == 'le ')
       && in_array($nomF, array('avocat','élève'))) $det = "l'";
    if ($n == 's' or $nomF == 'fils') return "$det$nomF";
    // pluriel du nom
    return $det . preg_replace("/ /","s ", $nomF).'s';
}

function sAbstract() 
{
     // tire les numéros des éléments S, O et V;
     // S et O sont accompagnés de leur nombre.
     global $nomina, $uerba;
     // uerbum
     $nv = mt_rand(0, count($uerba)-1);
     $r['V'] = $uerba[$nv];
     $r['pV'] = mt_rand(1,3);
     $r['nV'] = sorsColl(array('s','p'));
     // subiectum
     $tabula = $r['V'][1];
     $r['S'] = sorsColl($tabula);
     // obiectum 
     $tabula = $r['V'][2];
     $r['O'] = $r['S'];
     while ($r['O'] == $r['S']) $r['O'] = sorsColl($tabula);
     // 'argent' doit rester singulier
     if ($r['O'] == 9) $r['nO'] = 's';
     else $r['nO'] = sorsColl(array('s','p'));
     // définition numérique :
     $r['num'] = sprintf("%d-%d-%s-%d-%d-%s", $nv,$r['pV'],$r['nV'],$r['S'],$r['O'],$r['nO']);
     return $r;
}

function sLat($sAb)
{
   global $nomina;
   // uerbum 
   $uerbum = $sAb['V']; 
   $persona = $sAb['pV'];
   $numerus = $sAb['nV'];
   $fVerbum = conj($uerbum, $persona, $numerus);
   // subiectum & obiectum
   if ($persona == 3)
   $sub = decl($nomina[$sAb['S']], 'n', $numerus);
   else $sub = '';
   $obj = decl($nomina[$sAb['O']], 'ac', $sAb['nO']);
   // ordinem
   $tabula = array($sub, $obj, $fVerbum);
   shuffle($tabula);
   // finis
   return trim(implode(' ', $tabula)).'.';
}

function sGal($sAb)
{
   global $nomina;
   // uerbum sortitur
   $uerbum = $sAb['V'];
   $persona = $sAb['pV'];
   $numerus = $sAb['nV'];
   // verbe
   $formeV = conjG($uerbum, $persona, $numerus);
   // sujet
   $pr = array('je','tu','il','nous','vous','ils');
   // rang 1-6 de la personne + nombre
   if ($numerus == 's') $pn = $persona-1;
   else $pn = $persona+2;
   if ($persona < 3) $sujet = $pr[$pn];
   else $sujet = nombre($nomina[$sAb['S']], $numerus);
   // objet
   $on = $sAb['O'];
   $numOb = $sAb['nO'];
   $objet = nombre($nomina[$on], $numOb);
   // élision du pronom je
   if ($sujet == 'je' && in_array($formeV, array('entends','aime', 'appelle')))
       $sujet = "j'"; 
   else $sujet = "$sujet ";
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
    SENTENTIAE SOV DICTAE
</p>
<?php
if (isset($_POST["numeri"])) 
   $numeri = $_POST["numeri"]; 
if (isset($numeri)) {
    $resp = $_POST['resp']; 
    $resp = trim($resp);
    $resp = stripslashes($resp);
    $priorSent = $_POST['priorSent'];
    $priorSent = stripslashes($priorSent);
    // solutionem ab sententia
    $tabula = explode ('-', $numeri);
    //$r['pV'],$r['nV'],$r['S'],$r['O'],$r['nO']);
    $pS['V'] = $uerba[$tabula[0]];
    $pS['pV'] = $tabula[1];
    $pS['nV'] = $tabula[2];
    $pS['S'] = $tabula[3];
    $pS['O'] = $tabula[4];
    $pS['nO'] = $tabula[5];
    $pMeta = $_POST['meta'];
    if ($pMeta == 'latine') 
    {
        // alphabeticum ordinem ut comparatio pertinens fiat.
        $sol = sLat($pS);
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
        $sol = sGal($pS);
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
echo "<input type=\"hidden\" name=\"priorSent\" value=\"$sententia\">\n";
echo "<input type=\"hidden\" name=\"meta\" value=\"$meta\">\n";
echo "<input type=\"hidden\" name=\"numeri\" value=\"".$sAb['num']."\">\n";
?>
</p>
</form>
<div class="conseil">Tous les déterminants sont des articles définis !
<a href="sov6-auxilium.php" target="_top">aide</a>
<p class="redi"><a href='./'>reditus</a> <a href="gpl.html" target="gpl">Licentia GPL</a></p>
</body>
</html>
