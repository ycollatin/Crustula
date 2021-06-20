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
// ad errores inueniendos. eradere ad productionem
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1); error_reporting(E_ALL);

$alin = "<br>\n";
$nomina = array(
   // dans l'ordre : le nom et sa déclinaison, le genre, la traduction, et 
   // éventuellement un tableau des possibilités comme CDN
   array('iuuen-is-em-is-es-es-um', 'm', 'jeune homme'), // 0
   array('puell-a-am-ae-ae-as-arum', 'f', 'jeune fille'),  // 1
   array('amic-us-um-i-i-os-orum', 'm', 'ami',
         array(0,1,3)),           // 2
   array('fili-us-um-i-i-os-orum', 'm', 'fils'),          // 3
   array('for-um-um-i-a-a-orum', 'n', 'marché',
         array(6)),          // 4
   array('fabul-a-am-ae-ae-as-arum', 'f', 'histoire'),     // 5
   array('urb-s-em-is-es-es-ium',  'f', 'ville'),         // 6
   array('bell-um-um-i-a-a-orum', 'nf', 'guerre'),        // 7
   array('statu-a-am-ae-ae-as-arum', 'f', 'statue',
        array(0,1,2)),       // 8
   array('pecuni-a-am-ae-ae-as-arum', 'f', 'argent',
        array(0,1,2,6))       // 9
);

$uerba = array(
   // dans l'ordre : le verbe, le tableau de ses sujets potentiels, et
   //    et celui de ses objets potentiels.
   array('narro, as, are : raconter',array(0,1,2,3),array(5,7)),
   array('circumeo, is, ire, iui, itum : parcourir',array(0,1,2,3,5,9),array(4,6)),
   array('diligo, is, ere, dilexi, dilectum : aimer',array(0,1,2,3),array(0,1,2,3)),
   array('saluto, as, are : saluer',array(0,1,2,3),array(0,1,2,3)),
   array('conspicio, is, ere, spexi, spectum : apercevoir',array(0,1,2,3,6),array(0,1,2,3,4,6,8,9))
);

$conjug = array(
   // solution acceptable à cause de la pauvreté du lexique : le présent de chaque verbe
   'raconter'=>array('raconte','racontes','raconte','racontons','racontez','racontent','racont'),
   'parcourir'=>array('parcours','parcours','parcourt','parcourons','parcourez','parcourent','parcour'),
   'aimer'=>array('aime','aimes','aime','aimons','aimez','aiment','aim'),
   'saluer'=>array('salue','salues','salue','saluons','saluez','saluent','salu'),
   'apercevoir'=>array('aperçois','aperçois','aperçoit','apercevons','apercevez','aperçoivent','apercev')
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
        return $radical.$eclats[4];
    }
    if ($k == 'ac')
    {
        if ($n == 's') return $radical.$eclats[2];
        return $radical.$eclats[5];
    }
    if ($n == 's') return $radical.$eclats[3];
    return $radical.$eclats[6];
}

function conj($u, $p, $n, $t='p')
{
   $eclats = explode(',', $u[0]);
   $pp = $eclats[0];
   if ($t == 'i')
   {
       $des = array(
           's'=>array('bam','bas','bat'),
           'p'=>array('bamus','batis','bant'));
       // ligationnis uocalis
       if($pp == 'narro' || $pp == 'saluto')
           $uoc = 'a';
       elseif ($pp == 'circumeo' ) $uoc = 'i';
       elseif ($pp == 'diligo') $uoc = 'e';
       else $uoc = 'ie';
       $rad = preg_replace("/[ie]?o$/","",$pp); 
       return $rad.$uoc.$des[$n][$p-1];
   }
   // canonica forma
   if ($n == 's' && $p == 1) return $pp;
   $des = array (
       's'=> array('o','s','t'),
       'p'=> array('mus','tis','nt'));
   // ligationis uocalis
   if ($n == 'p' && $p == 3)
   {
       if ($pp == 'diligo') return 'diligunt';
       if ($pp == 'circumeo') return 'circumeunt';
       if ($pp == 'conspicio') return 'conspiciunt'; 
       $uoc = 'u';
   }
   if (in_array($pp, array('narro','saluto'))) $uoc = 'a';
   else $uoc = 'i';
   // radix
   $radix = preg_replace("/[ei]?o$/", "", $pp);
   return $radix.$uoc.$des[$n][$p-1];
}

function conjG($v, $p, $n,$t='p')
{
    // calculer le rang de la personne
    global $conjug;
    $entree = $v[0];
    $eclats = explode(' : ', $entree);
    $inf = $eclats[count($eclats)-1];
    if ($n == 's') $pn = $p-1;
    else $pn = $p+2;
    if ($t=='i')
    {
        $radical = $conjug[$inf][6];
        $des = array('ais','ais','ait','ions','iez','aient');
        return $radical.$des[$pn];
    }
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
       && in_array($nomF, array('ami','histoire','argent'))) $det = "l'";
    if ($n == 's' or $nomF == 'fils') return "$det$nomF";
    // pluriel du nom
    return $det . preg_replace("/ /","s ", $nomF).'s';
}

function genitif($nom, $n)
{
}

function sAbstract() 
{
    /*
     * Tire une phrase abstraite, pouvant être
     * exprimée en français avec sGal(), ou en
     * latin avec sLat().
     */
     global $nomina, $uerba;
     // uerbum
     $nv = mt_rand(0, count($uerba)-1);
     $r['V'] = $uerba[$nv];
     $r['pV'] = mt_rand(1,3);
     $r['nV'] = sorsColl(array('s','p'));
     $r['tV'] = sorsColl(array('p','i'));
     // subiectum
     $tabula = $r['V'][1];
     $r['S'] = sorsColl($tabula);
     // subiecti genetiuus
     if (count($nomina[$r['S']]) > 3)
     {
         $r['gS'] = sorsColl($nomina[$r['S']][3]);
         $r['ngS'] = sorsColl(array('s','p'));
     }
     else
     {
          $r['gS'] = 99;   
          $r['ngS'] = 'x';
     }
     // obiectum 
     $tabula = $r['V'][2];
     $r['O'] = $r['S'];
     while ($r['O'] == $r['S']) $r['O'] = sorsColl($tabula);
     // 'argent' doit rester singulier
     if ($r['O'] == 9) $r['nO'] = 's';
     else $r['nO'] = sorsColl(array('s','p'));
     // obiecti genetiuus
     if (count($nomina[$r['O']]) > 3)
     {
         $r['gO'] = sorsColl($nomina[$r['O']][3]);
         $r['ngO'] = sorsColl(array('s','p'));
     }
     else
     {
          $r['gO'] = 99; 
          $r['ngO'] = 'x';
     }
     // définition numérique :
     $r['num'] = sprintf("%d-%d-%s-%s-%d-%d-%s-%d-%s-%d-%s", 
     //                   verbe------ sujet--  objet-----
                         $nv,$r['pV'],$r['nV'],$r['tV'], // 5
                         $r['S'],$r['gS'],$r['ngS'],
                         $r['O'],$r['nO'],$r['gO'],$r['ngO']);
     return $r;
}

function sLat($sAb)
{
   global $nomina;
   // uerbum 
   $uerbum = $sAb['V']; 
   $persona = $sAb['pV'];
   $numerus = $sAb['nV'];
   $tempus = $sAb['tV'];
   $fVerbum = conj($uerbum, $persona, $numerus, $tempus);
   // subiectum & obiectum
   if ($persona == 3)
   {
       $sub = decl($nomina[$sAb['S']], 'n', $numerus);
       if ($sAb['gS'] < 99)
       {
           $gsub = decl($nomina[$sAb['gS']], 'g', $sAb['ngS']); 
           // ordre aléatoire nom-génitif
           $tab = array($sub, $gsub);
           shuffle($tab);
           $sub = $tab[0].' '.$tab[1];
       }
   }
   else $sub = '';
   $obj = decl($nomina[$sAb['O']], 'ac', $sAb['nO']);
   if ($sAb['gO'] < 99)
   {
       $gobj = decl($nomina[$sAb['gO']], 'g', $sAb['ngO']);
       // ordre aléatoire nom-génitif
       $tab = array($obj, $gobj);
       shuffle($tab);
       $obj = $tab[0].' '.$tab[1];
   }
   // ordinem
   $tabula = array($sub, $obj, $fVerbum);
   shuffle($tabula);
   // finis
   $r = trim(implode(' ', $tabula)).'.';
   $r = str_replace ('-', ' ', $r);
   return $r;
}

function sGal($sAb)
{
   global $nomina;
   $uerbum = $sAb['V'];
   $persona = $sAb['pV'];
   $numerus = $sAb['nV'];
   $tempus = $sAb['tV'];
   $CDNs = "";
   // verbe
   $formeV = conjG($uerbum, $persona, $numerus,$tempus);
   // sujet
   $pr = array('je','tu','il','nous','vous','ils');
   // rang 1-6 de la personne + nombre
   if ($numerus == 's') $pn = $persona-1;
   else $pn = $persona+2;
   if ($persona < 3) $sujet = $pr[$pn];
   else 
   {
       $sujet = nombre($nomina[$sAb['S']], $numerus);
       if ($sAb['gS'] < 99)
           $CDNs = ' de '.nombre($nomina[$sAb['gS']], $sAb['ngS']);
       else $CDNs = "";
   }
   // objet
   $on = $sAb['O'];
   $numOb = $sAb['nO'];
   $objet = nombre($nomina[$on], $numOb);
   if ($sAb['gO'] < 99)
       $CDNo = ' de '.nombre($nomina[$sAb['gO']], $sAb['ngO']);
   else $CDNo = "";
   // retour
   $r = "$sujet$CDNs $formeV $objet$CDNo.";
   // contractions, élision
   $pro = array("/ de le /", "/ de les /", "/^je a/");
   $dic = array(" du ", " des ", "j'a");
   $r = preg_replace($pro, $dic, $r);
   $r = ucfirst($r);
   return $r;
}

$meta = sorsColl(array('latine','gallice'));
$sAb = sAbstract(); 
if ($meta == 'latine') $sententia = sGal($sAb);
else $sententia = sLat($sAb);

session_start();
?>
<html>
<head>
<title>CRVSTVLA - Praesens et imperfectvm tempvs - genetivvs casvs </title>
<?php 
   include "css.inc";
   include "meta.inc.php";   
?>
</head>
<body>
<p class="titre">
    PRAESENS ET IMPERFECTVM TEMPVS - GENETIVVS CASVS 
</p>
<?php
if (isset($_POST["numeri"])) 
    {
    $numeri = $_POST["numeri"];
    //echo "numeri:$numeri:$alin";
    $resp = $_POST['resp']; 
    $resp = trim($resp);
    $resp = stripslashes($resp);
    $priorSent = $_POST['priorSent'];
    $priorSent = stripslashes($priorSent);
    // solutionem ab sententia
    $tabula = explode ('-', $numeri);
    /*
     $nv,$r['pV'],$r['nV'],$r['tV'], // 5
     $r['S'],$r['gS'],$r['ngS'],
     $r['O'],$r['nO'],$r['gO'],$r['ngO']);
    */
    $pS['V'] = $uerba[$tabula[0]];
    $pS['pV'] = $tabula[1];
    $pS['nV'] = $tabula[2];
    $pS['tV'] = $tabula[3];

    $pS['S'] = $tabula[4];
    $pS['gS'] = $tabula[5];
    $pS['ngS'] = $tabula[6];

    $pS['O'] = $tabula[7];
    $pS['nO'] = $tabula[8];
    $pS['gO'] = $tabula[9];
    $pS['ngO'] = $tabula[10];

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
        $respC = preg_replace("/[\s]+/", ' ', $respC);
    }
    $solC = trim ($solC);
    $respC = trim ($respC);
    echo "Prior sententia : $priorSent $alin";
    echo "Solutio : &laquo;$sol&raquo;$alin";
    //echo "strcasecmp($solC,$respC):".strcasecmp($respC, $solC).":$alin";
    if (strcasecmp($respC, $solC) == 0) $recte = True;
    else $recte = False;
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
<?php echo $sententia; ?> 
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
<a href="sov4-auxilium.php" target="_top">aide</a>
</div>
<p class="redi"><a href='./'>reditus</a> <a href="gpl.html" target="gpl">Licentia GPL</a></p>
</body>
</html>
