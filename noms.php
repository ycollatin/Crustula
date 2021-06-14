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
include "lexica/$incl.php";

$alin = "<br>\n";
$lbr  = "\n";

function sorsColl($c) {
    if (count($c) == 1) return $c[0];
    return $c[mt_rand(0, count($c)-1)];   
}


/**************************************
              en-tête  
**************************************/
session_start();
echo "<html>\n<head>\n";
echo "<title>CRVSTVLA - $titre </title>\n";
include "css.inc";
include "meta.inc.php";
echo "</head>\n<body>";
//echo $alin.count($bini).$alin;
echo '<p class="titre">'."\n$titre</p>";


/**************************************
     dépouillement de la réponse
**************************************/
if(isset($_POST['quest']))
   $quest = $_POST['quest'];
if (!isset($quest)) {
    $ch = str_repeat('0', count($bini));
} else {
    $resp = $_POST['resp']; 
    $resp = stripslashes($resp);
    $quest = stripslashes($quest);
    // bilan des items sus
    $status = $_POST['status'];
    $chstatus = explode('-', $status);
    $ch = '';
    foreach ($chstatus as $n)
       $ch .= substr(decbin($n), 1);
    // examen de la réponse
    $ecl = preg_split("/[\s,\.]+/", $resp);
    while (count($ecl) < 2) $ecl[] = '-';
    $pos = 0;
    foreach ($bini as $l) {
        if ($l[3] == $quest) {
            $sol = $l;
            break;
        } 
        else $pos++;
    }
    // debog
    //echo "*".$ecl[0].'*'.$ecl[1].'*'.$alin;
    //echo "*".$sol[0].'*'.$sol[1].'*'.$alin;

    $recte = ($sol[0] == $ecl[0] && $sol[1] == $ecl[1]); 
    echo "prior quaestio : $quest$alin";
    echo "solutio : $sol[0], $sol[1] $alin";

    if ($recte) {
            echo "<div class=\"juste\">RECTE !</div>$alin"; 
            $ch{$pos} = '1'; 
    } else {
            echo "<div class=\"faux\"> Errauisti. Respondisti $resp </div>$alin"; 
    }
    echo substr_count($ch, '1').'/'.strlen($ch).$alin;
    include "session.php.html";    
}

/***************************************

         AFFICHAGE DU FORMULAIRE

***************************************/

function purgef() {
    // renvoie le tableau d'index des emplois non sus.
    global $ch;
    for ($i = 0; $i < strlen($ch); $i++)
       if ($ch{$i} == '0') $retour[] = $i;
    //debog
    /*
    global $bini;
    foreach ($retour as $l) echo $bini[$l][0].$alin;
    */
    return $retour;
}        

$coll = purgef();
if (count($coll) == 0) {
echo '<p class=quest>Ad omnes quaestiones respondisti. '
    .$alin.'Vale.';

} else {        
    $sors = sorsColl($coll);
    $f = $bini[$sors];
    $g = $f[3];
    echo '<form method="post" class="questmin">'.$lbr;
    echo '<p class="questmin">'.$lbr;
    echo '<input type="text" name="resp" class="questmin">&nbsp;';
    echo ", $g $lbr";
    echo '<input type="submit" class="questmin" value=" Mitto "></p>'.$lbr;
    echo '<p class="conseil">Donne le nominatif et le génitif !</p>'.$lbr;

    $chstatus = array();
    $chtmp = '';
    for ($ich = 0; $ich < strlen($ch); $ich++) {
            $chtmp .= $ch{$ich};
            if (strlen($chtmp) == 30) {
                    $chtmp = '1'.$chtmp;
                    $chstatus[] = bindec($chtmp);
                    $chtmp = '';
            }
    }   
    if ($chtmp > '') {
            $chtmp = '1'.$chtmp;
            $chstatus[] = bindec($chtmp);
    }        
    $status = implode('-', $chstatus);

    echo '<input type="hidden" name="quest" value="'.$g.'">'.$lbr;
    echo '<input type="hidden" name="status" value="'.$status.'">'.$lbr;
    echo '</form>'.$lbr;
}
// debog
// echo $alin.$ch;
?>
<p class="redi"><a href='./'>reditus</a> <a href="gpl.html" target="gpl">Licentia GPL</a></p>
</body>
</html>
