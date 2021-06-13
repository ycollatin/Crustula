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

Bogues : 
  - les tirets - -que apparaissent
  - affichages indésirables

*/
$incl = $_POST['incl'];
if (!isset($incl)) $incl = $_GET['incl'];
if (!isset($incl)) die('Victus sum, abeo.');
include "txt/$incl.php";
$alin = "<br>\n";

$lescas = array('nominatif','vocatif','accusatif','génitif','datif','ablatif');
$abbr = array('N','V','Ac','G','D','Ab'); 

function sorsColl($c) {
    if (count($c) == 1) return $c[0];
    return $c[mt_rand(0, count($c)-1)];   
}

function absTT($ch) {
 // supprime les deux tirets et l'espace qui les sépare
 return preg_replace("/(\-\s+)/",'', $ch);
}        

function sinepunct($ch) {
 // supprime les ponctuations
 return preg_replace("/([,;.:])/",'',$ch);
}        

function absT($ch) {
 // supprime les tirets
 return str_replace('-','', $ch);
}        

function ql($ph, $n) { 
   // retourne la phrase $ph avec le segment $n sous forme de lacune 
   $ph[$n] = '...';
   //echo "*".implode(' ', $ph)."*";
   return absT(implode(' ', $ph));
}        

function qg($ph, $n) {
   // retourne la phrase française $ph avec le segment $n en rouge
   if (substr($ph[$n], -1) == '-') {
       $ph[$n] = preg_replace("/(-)$/", '', $ph[$n]);
       $ph[$n] = '<span class="conseil">'.$ph[$n].'</span>';
       $ph[$n] .= $ph[$n+1];
       unset($ph[$n+1]);
   } else $ph[$n] = '<span class="conseil">'.$ph[$n].'</span>';
   return absTT(implode(' ', $ph));
}        

function sol($ph, $nsynt) {
    return $ph[$nsynt]; 
}        

session_start();


echo "<html>\n<head>\n";
echo "<title>CRVSTVLA - $titre </title>\n";
include "css.inc";
include "meta.inc.php";
echo "</head>\n<body>";
echo '<p class="titre">'."\n$titre</p>";

// initialisations
if(isset($_POST['niveau']))
    $niveau = $_POST['niveau'];
else $niveau = 0; 
// if (!isset($niveau)) $niveau = 0; 
// debog !  //$niveau = 1;

/******************************
          NIVEAU 0
******************************/
if ($niveau == 0) {
   // parcours simple
   // initialisation
   //echo var_dump($_POST);
   if (isset($_POST['uia']))
       $uia = $_POST['uia'];
   if (!isset($uia)) {
       $nph = 0;
       $langl = True;
   } else {
       $langl = $_POST['langl'];
       $nph = $_POST['nph'];
       if($nph > 0 || $uia{0} == 'P' || !$langl)
           $langl = !$langl;
       if ($uia{0} == 'P') {
         if ($langl) $nph++;
         if ($nph >= count($data)) //&& !$langl) 
             $niveau = 1;
       } else {
         if (!$langl && $nph > 0) $nph--;
       }
   }
}

// solution
if(isset($_POST['resp'])) { 
    $resp = $_POST['resp'];
    $resp = stripslashes($resp);
} 
/******************************
          NIVEAU I
correspondance des syntagmes
******************************/
if ($niveau == 1) {
    if (!isset($resp)) {
        $ngr = 0;
        $ch = str_repeat('0',count($data[0]['lat']));
    } else {
        $ngr = $_POST['ngr'];
        $nq  = $_POST['nq'];
        $status = $_POST['status'];
        $ch = decbin($status);
        $ch = substr($ch, 1);
        //echo "$alin ch : *$ch*$alin";
        echo "Prior quaestio : ".$data[$ngr]['lat'][$nq].$alin;
        $nfr = $data[$ngr]['ord'][$nq];
        $sol = $data[$ngr]['fr'][$nfr];
        $sol = sinepunct($sol);
        echo "Solutio : $sol $alin";
        $recte = $resp == $sol;
        include "session.php.html";
        echo $alin;
        //echo "*nq : $nq*"; // debog
        if ($recte) {
            echo "<div class=\"juste\">RECTE !</div>"; 
            $ch{$nq} = '1';
            //echo "$alin ch : *$ch*$alin";
        } else {
            echo "<div class=\"faux\"> Errauisti. Respondisti : $resp</div>";
        }
    }
    echo sprintf("niveau %s ; phrase %s/%s", $niveau, $ngr + 1, count($data));
    $infecta = array();
    for ($i = 0; $i < strlen($ch); $i++)
        if ($ch{$i} == '0') $infecta[] = $i;
    if (count($infecta) == 0) {
        $ngr++;
        if ($ngr >= count($data)) {
            $niveau = 2;
            $ngr = 0;
            $lq = $data[$ngr]['cas']; 
            $ch = str_repeat('1',count($data[0]['lat']));
            foreach(array_keys($lq) as $k)
                $ch{$k} = '0'; 
            $nq = array_rand($lq); 
        } else {
            $ch = str_repeat('0',count($data[$ngr]['lat']));
            for ($i = 0; $i < count($data[$ngr]['lat']); $i++)
                 $infecta[] = $i;
        }
    }            
}

/******************************
          NIVEAU II
         morphologie
******************************/
elseif ($niveau == 2) {
    if (empty($resp)) {
       $ngr = 0;
       $lq = $data[$ngr]['cas']; 
       $ch = str_repeat('1',count($data[0]['lat']));
       foreach(array_keys($lq) as $k)
           $ch{$k} = '0'; 
       $nq = array_rand($lq); 
    } else {
       $status = $_POST['status'];
       $ngr    = $_POST['ngr'];
       $nq     = $_POST['nq'];
       $sol = $data[$ngr]['cas'][$nq];
       $sol = array_search($sol, $abbr);
       $sol = $lescas[$sol]; 
       $ch = decbin($status);
       $ch = substr($ch, 1);
       $recte = $resp == $sol;
       include "session.php.html";
       if ($recte) {
           echo "<div class=\"juste\">RECTE !</div>"; 
           $ch{$nq} = '1';
           $cles = array_keys($data[$ngr]['cas']);
	   $lq = array();
           for ($i = 0;$i < strlen($ch);$i++)
               if ($ch{$i} == '0') 
                   $lq[] = $i;
           if (count($lq) == 0){
               $ngr++;
               if ($ngr >= count($data)) {
                   $niveau = 3;
                   $ngr = 0;
                   $ch = str_repeat('0',count($data[0]['lat']));
                   $nsynt = mt_rand(0, count($data[$ngr]['lat'])-1);
               }
               else {
                   $lq = $data[$ngr]['cas']; 
                   $ch = str_repeat('1',count($data[$ngr]['lat']));
                   foreach(array_keys($lq) as $k)
                       $ch{$k} = '0'; 
                   $nq = array_rand($lq); 
               }
           }
           else $nq = sorsColl($lq);
       } else {
           echo "<div class=\"faux\"> Errauisti. Respondisti : $resp</div>";
       }
       echo "Solutio : $sol $alin";
       //echo "niveau 2 $alin";
       echo sprintf("niveau 2 ; phrase %s/%s", $ngr + 1, count($data));
    }

}

/******************************
          NIVEAU III
    retrouver les syntagmes
       avec la traduction
******************************/
elseif ($niveau == 3) {
   if (empty($resp)) {
       $ngr = 0;
       $ch = str_repeat('0',count($data[0]['lat']));
       $nsynt = mt_rand(0, count($data[$ngr]['lat'])-1);
   } else {
       $ngr = $_POST['ngr'];
       $nsynt = $_POST['nsynt'];
       $status = $_POST['status'];
       $ch = decbin($status);
       $ch = substr($ch, 1);
       $resp = trim($resp);
       $resp = str_replace('-','',$resp);
       $sol = $data[$ngr]['lat'][$nsynt]; 
       $sol = absT($sol);
       echo "Solutio : $sol$alin";
       $recte = $resp == sinepunct($sol);
       include "session.php.html";
       if ($recte) {
           echo "<div class=\"juste\">RECTE !</div>"; 
           $ch{$nsynt} = '1';
       } else {
           echo "<div class=\"faux\"> Errauisti. Respondisti : $resp</div>";
       }
   }
   //echo "niveau $niveau $alin";
   echo sprintf("niveau 3 ; phrase %s/%s", $ngr + 1, count($data));
   $infecta = array();
   for($i=0;$i<strlen($ch);$i++) {
       if ($ch{$i} == '0') $infecta[] = $i;
   }
   if (count($infecta) == 0) {
       $ngr++;
       if ($ngr == count($data)) {
           $niveau = 4;
           $ngr = 0;
           $ch = str_repeat('0',count($data[0]['lat']));
           $nsynt = mt_rand(0, count($data[$ngr]['lat'])-1);
       } else {
           $ch = str_repeat('0',count($data[$ngr]['lat']));
           $nsynt = mt_rand(0, count($data[$ngr]['lat'])-1);
       }
   } else $nsynt = sorsColl($infecta);
}

/***************************************
              NIVEAU IIII
    retrouver les syntagmes
       sans la traduction
***************************************/

elseif ($niveau == 4) {
   if (empty($resp)) {
       $ngr = 0;
       $ch = str_repeat('0',count($data[0]['lat']));
       $nsynt = mt_rand(0, count($data[$ngr]['lat'])-1);
   } else {
       $ngr = $_POST['ngr'];
       $nsynt = $_POST['nsynt'];
       $status = $_POST['status'];
       $ch = decbin($status);
       $ch = substr($ch, 1);
       $resp = trim($resp);
       $resp = str_replace('-','',$resp);
       $sol = $data[$ngr]['lat'][$nsynt]; 
       $sol = absT($sol);
       echo "Solutio : $sol$alin";
       $recte = $resp == sinepunct($sol);
       include "session.php.html";
       if ($recte) {
           echo "<div class=\"juste\">RECTE !</div>"; 
           $ch{$nsynt} = '1';
       } else {
           echo "<div class=\"faux\"> Errauisti. Respondisti : $resp</div>";
       }
   }
   //echo "niveau $niveau $alin";
   echo sprintf("niveau 4 ; phrase %s/%s", $ngr + 1, count($data));
   for($i=0;$i<strlen($ch);$i++) {
       if ($ch{$i} == '0') $infecta[] = $i;
   }
   if (count($infecta) == 0) {
       $ngr++;
       if ($ngr == count($data)) {
           $niveau = 5;
       } else {
           $ch = str_repeat('0',count($data[$ngr]['lat']));
           $nsynt = mt_rand(0, count($data[$ngr]['lat'])-1);
       }
   } else $nsynt = sorsColl($infecta);
}

/***************************************

         AFFICHAGE DU FORMULAIRE

***************************************/


if ($niveau == 0) {
   // données
   $d = $data[$nph];
   if ($langl) {
       $aff = $d['lat'];
       $aff = implode(' ', $aff);
       $aff = absTT($aff);
       $aff = '<span class="questlat">'.$aff.'</span>';
   } else {
       $aff = $d['fr'];
       $aff = implode(' ', $aff);
       $aff = '<span class="questmin">'.$aff.'</span>';
   }
   echo sprintf("phrase %d / %d %s", $nph + 1 , count($data), $alin);
   echo $aff;
   echo "<form method=\"post\">\n";
   echo '<p align="center">'."\n";
   echo "<input class=\"question\" type=\"submit\" value=\"< Retro\" name=\"uia\">&nbsp;\n";
   echo "<input class=\"question\" type=\"submit\" value=\"Porro >\" name=\"uia\">&nbsp;\n";
   echo "</p>\n";
   echo '<input type="hidden" name="nph" value="'.$nph.'">'."\n";
   echo '<input type="hidden" name="langl" value="'.$langl.'">'."\n";
   echo '<input type="hidden" name="niveau" value="'.$niveau.'">'."\n";
   echo '<input type="hidden" name="incl" value="'.$incl.'">'."\n";
   echo '</form>';
}        

elseif ($niveau == 1) {
    // correspondance syntagmes lat/fr
    $nq = sorsColl($infecta); 
    $l = qg($data[$ngr]['lat'], $nq);

    echo '<form method="post">'."\n";
    echo '<p class="qestmin">'."\n"; 
    echo "$l$alin";
    echo "</p>\n";
    foreach($data[$ngr]['fr'] as $sg)
        echo '<input class="questmin" type="submit" name="resp" value="'.sinepunct($sg).'">'."\n";
    echo '<input type="hidden" name="ngr" value="'.$ngr.'">'."\n";
    echo '<input type="hidden" name="nq" value="'.$nq.'">'."\n";
    $ch = '1'.$ch;
    $status = bindec($ch);
    echo '<input type="hidden" name="status" value="'.$status.'">'."\n";
    echo '<input type="hidden" name="niveau" value="'.$niveau.'">'."\n";
    echo '<input type="hidden" name="incl" value="'.$incl.'">'."\n";
    echo '</form>'."\n";
}

elseif ($niveau == 2) {
    //echo "ch : *$ch*$alin"; // debog
    $datum = $data[$ngr];
    $l = qg($datum['lat'], $nq);
    $l = absTT($l);
    $g = implode(' ',$datum['fr']);
    shuffle($lescas);
    echo '<p class="questmin">'."\n";
    echo "$l$alin$g";
    echo "</p>\n";
    echo '<form method="post">'."\n";
    for($i=0;$i<count($lescas);$i++) {
       echo '<input type="submit" class="questmin" name="resp" value="'.$lescas[$i].'">'."\n";
       if ($i == 2) echo $alin;
    }
    echo '<input type="hidden" name="ngr" value="'.$ngr.'">'."\n";
    echo '<input type="hidden" name="nq" value="'.$nq.'">'."\n";
    $ch = '1'.$ch;
    $status = bindec($ch);
    echo '<input type="hidden" name="status" value="'.$status.'">'."\n";
    echo '<input type="hidden" name="niveau" value="'.$niveau.'">'."\n";
    echo '<input type="hidden" name="incl" value="'.$incl.'">'."\n";
    echo "</form>\n";
    }

elseif ($niveau == 3) {
   //echo "$alin ngr : $ngr $alin";
   $l = ql($data[$ngr]['lat'], $nsynt);
   $nf = $data[$ngr]['ord'][$nsynt];
   $g = qg($data[$ngr]['fr'], $nf);
   $ch = '1'.$ch;
   $status = bindec($ch);

   echo '<p class="questmin">'.$l."</p>\n";
   echo '<p class="questmin">'.$g."</p>\n";
   echo '<form method="post">'."\n";
   echo '<input type="text" name="resp" size="20" class="question">&nbsp;'."\n";
   echo '<input type="submit" class="questmin" value=" Respondi. ">'."\n";
   echo '<input type="hidden" name="niveau" value="'.$niveau.'">'."\n";
   echo '<input type="hidden" name="ngr" value="'.$ngr.'">'."\n";
   echo '<input type="hidden" name="nsynt" value="'.$nsynt.'">'."\n";
   echo '<input type="hidden" name="status" value="'.$status.'">'."\n";
   echo '<input type="hidden" name="incl" value="'.$incl.'">'."\n";
   echo "</form>\n";
}



elseif ($niveau == 4) {
  // lacunes sans traduction
   $l = ql($data[$ngr]['lat'], $nsynt);
   $nf = $data[$ngr]['ord'][$nsynt];
   // $g = qg($data[$ngr]['fr'], $nf);
   $ch = '1'.$ch;
   $status = bindec($ch);

   echo '<p class="questmin">'.$l."</p>\n";
   // echo '<p class="questmin">'.$g."</p>\n";
   echo '<form method="post">'."\n";
   echo '<input type="text" name="resp" size="20" class="question">&nbsp;'."\n";
   echo '<input type="submit" class="questmin" value=" Respondi. ">'."\n";
   echo '<input type="hidden" name="niveau" value="'.$niveau.'">'."\n";
   echo '<input type="hidden" name="ngr" value="'.$ngr.'">'."\n";
   echo '<input type="hidden" name="nsynt" value="'.$nsynt.'">'."\n";
   echo '<input type="hidden" name="status" value="'.$status.'">'."\n";
   echo '<input type="hidden" name="incl" value="'.$incl.'">'."\n";
   echo "</form>\n";
}        

elseif ($niveau == 5) {
   echo '<p class="question">Tu summa laude dignus es qui omnia perfecisti.</p>'.$alin;
}        

?>

<p class="redi"><a href='./indextxt.php'>reditus</a> <a href="gpl.html" target="gpl">Licentia GPL</a></p>
</body>
</html>
