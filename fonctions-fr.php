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
$titre = "INITIATION AUX CAS : LES VALEURS";
$data = array(
   array('La terre est -tendre-.',
         'attribut du sujet : nominatif'),
   array('-La terre- est tendre.',
         'sujet du verbe : nominatif'),
   array('-La terre- a soif.',
         'sujet du verbe : nominatif'),
   array('Au printemps -les terres- sont gonflées.',
         'sujet du verbe : nominatif'),
   // vocatif
   array('O ciel, ô -terre-, ô mers de neptune !',
         "on nomme celui à qui on s'adresse : vocatif"),
   // accusatif
   array('Les vents balaient -les terres-',
          "complément d'objet direct du verbe : accusatif"),
   array('Hannibal déchirait -la terre- d\'Italie.',
          "complément d'objet direct du verbe : accusatif"),
   array('Toutes les choses reviennent dans -les terres-.',
          "lieu où l'on entre : accusatif"),
   // génitif 
   array('Un horrible tremblement -de terre- est annoncé.',
          "complément du nom : génitif"),
   array('Ils débattent de la grandeur du monde et -des terres-.',
          "complément du nom : génitif"),
   // datif 
   array('La terre doit être rendue -à la terre-.',
          "le nom qui désigne l'être ou la chose POUR qui est faite l'action : datif"),
   array('Ces si grands feux ne sont aucunement nocifs -pour les terres-.',
          "le nom qui désigne l'être ou la chose POUR qui est faite l'action : datif"),
   // ablatif
   array('Je profite du ciel et -de la terre-.',
          "nom qui indique une cause, un moyen, une manière : ablatif"),
   array('Ils combattent sur -terre-',
          "nom qui désigne le lieu où l'on est : ablatif"),
   array('Toutes les choses naissent des -terres-.',
          "nom qui désigne le lieu d'où l'on vient : ablatif"),
   array('Cnéius Pompée faisait la guerre sur -les terres- les plus éloignées.',
          "nom qui désigne le lieu où l'on est : ablatif")
);
$valeurs = array();
foreach ($data as $d)
   if (!in_array($d[1], $valeurs))
       $valeurs[] = $d[1];
$alin = "<br>\n";

$totalS = count($data);

function numP($p) {
   global $data;
   for ($i=0;$i<count($data);$i++)
       if ($data[$i][0] == $p) 
           return $i;
}        

function noti($ch) {
    $r = 0;
    for ($i = 0; $i < strlen($ch); $i++) {
         $r += (integer)$ch{$i};    
    }
    return $r;
}        

function sorsColl($c) {
    if (count($c) == 1) return $c[0];
    return $c[mt_rand(0, count($c)-1)];   
}

function graisse($sententia) {
   preg_match('/^(.*)-(.*)-(.*)$/', $sententia, $eclats);
   $u = $eclats[2];
   return $eclats[1].'<span class="conseil">'.$u.'</span>'.$eclats[3];
}        

if (isset($_POST['niveau']))
    $niveau = $_POST['niveau'];
if (!isset($niveau)) {                   // initialisation
    $status = str_repeat('0', count($data));
    $niveau = 1;
} else {                               // traitement de la réponse
    $status = $_POST['status'];
    if ($niveau == 1) {
        $priorS = $_POST['priorS'];
        $priorS = stripslashes($priorS);
        $resp = $_POST['resp'];
        $resp = stripslashes($resp);
        foreach($data as $d)
           if ($d[0] == $priorS) {
               $sol = $d[1];
               $pos = array_search($d, $data);
               break;
           }
        $recte = $resp == $sol;
        if ($recte) {
            $n = (integer)$status{$pos};
            $n++;
        } else {
            echo "<div class=\"faux\"> Errauisti. Respondisti : $resp</div>";
            if (isset($n) && $n > 0) $n--; 
        }
        if (isset($n)) $status{$pos} = (string)$n;
    } elseif ($niveau == 2) {
        $priorV = $_POST['priorV'];
        $priorV = stripslashes($priorV);
        for ($i=0;$i<count($data);$i++) {
           $r = $_POST['resp'.$i];
           if (!empty($r)) $resp[] = stripslashes($r);
        }
        foreach($data as $d) {
            if ($d[1] == $priorV) $sol[] = $d[0]; 
        }
        sort($resp);
        sort($sol);
        $recte = $resp == $sol;
        for($i=0;$i<count($sol);$i++) $sol[$i] = graisse($sol[$i]);
        if ($recte) {
            for($p=0;$p<count($valeurs);$p++) {
                if ($valeurs[$p] == $priorV) {
                    $n = (integer)$status{$p};
                    $n++;
                    $status{$p} = (string)$n;
                }
            }
        } else {
            for($p=0;$p<count($valeurs);$p++) {
                if ($valeurs[$p] == $priorV) {
                    $n = (integer)$status{$p};
                    $n++;
                    $status{$p} = (string)$n;
                }
            }
        }        
    }
}        
                                      // Tirage de la question
for($i = 0;$i<strlen($status);$i++)
   if ($status{$i} < '3') $nonsus[] = $i;
if (count($nonsus) == 0) {
    $niveau++;
    $message = "Tu viens de passer au niveau $niveau";
    if ($niveau == 2)
        $status = str_repeat('0', count($valeurs));
        for ($i=0;$i<count($valeurs);$i++) $nonsus[] = $i;
}
if ($niveau == 1) {                   // niveau 1
    $paire = $data[sorsColl($nonsus)];// trouver la fonction d'un mot
    $p = $paire[0];                   
} elseif ($niveau == 2) {             // niveau 2
    shuffle($nonsus);                 // trouver les phrases illustrant une valeur
    $v = $valeurs[$nonsus[0]];
    foreach ($data as $d)
       $ph[] = $data[0];
} else {                              // fin de l'exercice, suggestion pour avancer
    $suivants = array("valeurk","terra");
}        
?>
<html>
<head>
<title>CRVSTVLA - <?php echo $titre ?></title>
<?php 
   include "css.inc";
   include "meta.inc.php";
?>
</head>
<body>
<p class="titre">
<?php
echo "$titre</p>";
//echo "*$status*";// debog
if (isset($suivants)) {
    include $incl.'suivants.php';
} else {
// Affichage de la sanction et correction
if (!empty($priorS)) {                // niveau I 
    echo "\n".graisse($priorS).$alin;
    echo $sol;
    $n = (integer)$status{$pos};
    if ($recte) {
        echo "<div class=\"juste\">RECTE !</div>"; 
    } else {
        echo "<div class=\"faux\"> Errauisti. Respondisti : $resp</div>";
    }
} elseif(!empty($priorV)) {           // niveau II
    echo "prior quaestio : $priorV$alin";
    echo implode(', ', $sol);
    if ($recte) {
        echo "<div class=\"juste\">RECTE !</div>"; 
   } else {
        echo "<div class=\"faux\"> Errauisti. Respondisti : ".implode(', ', $resp)."</div>\n";
    }        
}
echo "niveau $niveau, ". noti($status) ."/".$totalS * 3;
echo '<form method="post">'."\n";
if ($niveau == 1) {                   // niveau I
   echo '<p class="question">'.graisse($p)."$alin Quelle est la valeur du mot en gras ?$alin";
   echo "</p>\n";
   shuffle($valeurs);
   foreach ($valeurs as $v) {
      echo '<input type="radio" name="resp" value="'.$v.'">'.$v.$alin;
   }
   echo '<input type="hidden" name="priorS" value="'.$p.'">'."\n";
} else {                              // niveau II        
   echo '<p class="questmin">'.$v."\n</p>Coche les phrases qui illustrent cette valeur.$alin";
   $i = 0;
   shuffle($data);
   foreach ($data as $d) {
       echo '<input type="checkbox" name="resp'.$i.'" value="'.$d[0].'">'.graisse($d[0]).$alin;
       $i++;
   }
   echo '<input type="hidden" name="priorV" value="'.$v.'">'."\n";
}
echo '<input type="hidden" name="niveau" value="'.$niveau.'">'."\n";
echo '<input type="hidden" name="status" value="'.$status.'">'."\n";
echo '<input type="submit" value="Respondi">'."\n";
echo "</form>\n";
echo "<span class=\"conseil\">$message</span>$alin";
//echo $alin.$status; // debog
}
?>
<p class="redi"><a href='./'>reditus</a> <a href="gpl.html" target="gpl">Licentia GPL</a></p>
</body></html>
