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
$titre = "QVEM CASVM ?";
$alin = "<br>\n";
$data = array(
   "nominatif"=>array("le sujet","l'attribut du sujet"),
   "vocatif"=>array("le nom qui interpelle un interlocuteur"),
   "accusatif"=>array("le complément d'objet direct","le nom qui désigne lieu où l'on entre"),
   "génitif"=>array("le complément du nom (de + nom)"),
   "datif"=>array("le nom qui désigne l'être ou la chose POUR qui est faite l'action (COI, COS)"),
   "ablatif"=>array("le nom qui indique une cause, un moyen, manière","le nom qui désigne le lieu où l'on est",
         "le nom qui désigne le lieu d'où l'on vient")
   );

// calcul du total des données
$omnesSensus = array();
foreach($data as $k)
   $omnesSensus = array_merge($omnesSensus, $k);
$totalS = count($omnesSensus);

function numSensus($s) {
    global $omnesSensus;
    return array_search($s, $omnesSensus);
}        

function graisse($ch) {
   global $eclats;
   return $eclats[1].'<span class="conseil">'.$ch.'</span>';
}        

function sorsColl($c) {
    if (count($c) == 1) return $c[0];
    return $c[mt_rand(0, count($c)-1)];   
}

function qSensusCasus($s) {
    return 'À quel cas doit-on mettre '.$s.' ?';
}

function qCasusSensus($k) {
    $q = "Coche toutes les fonctions que peut prendre le nom ";
    if ($k{0} == 'a') $q .= "à l'";
    else $q .= "au ";
    return $q.$k.'.';
}        

function solutio($ks, $k, $s) {
    global $data;
    if ($ks) {
       return $data[$k]; 
    } else {
         //echo "sensus : $s";
         foreach(array_keys($data) as $c)
            foreach($data[$c] as $sensus)
                if ($sensus == $s) return $c;
    }
}        

function noti($ch) {
    $r = 0;
    for ($i = 0; $i < strlen($ch); $i++) {
         $r += (integer)$ch{$i};    
    }
    return $r;
}        

// niveau
if (isset($_POST['status'])) {
    $status = $_POST["status"];
    $priorks = $_POST['priorks'];
    if (isset($_POST['priorK'])) $priorK = $_POST['priorK'];
    if (isset($_POST['priorS'])) {
        $priorS  = $_POST['priorS'];
        $priorS = stripslashes($priorS);
    }
}
if (!isset($status)) {
   $status = str_repeat('0', $totalS);
   $niveau = 1;
  // $niveau = 2; // debog
} 
session_start();
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
// echo "status : $status $alin"; // debog
if (isset($priorks) || isset($priorK) || isset($priorS)) {                           // il y a une question précédente
    // entourloupe pour faire accepter toutes les variables
    if (!isset($priorks)) $priorks = ''; 
    if (!isset($priorK)) $priorK = ''; 
    if (!isset($priorS)) $priorS = ''; 
    $sol = solutio($priorks, $priorK, $priorS);
    $niveau = $_POST['niveau'];
    if (isset($_POST['resp'])) $resp = $_POST['resp'];
    if ($priorS) {                                // la question précédente demande un cas
        $priorQ = qSensusCasus($priorS);
        $recte = strtolower($resp) == strtolower($sol);
    } else {
        $priorQ = qCasusSensus($priorK);
        // récupérer les réponses
        for($i = 0; $i < 8; $i++) {
            if (isset($_POST['sens'.$i])) {
                $coche = $_POST['sens'.$i];
                if ($coche > '') $reps[] = stripslashes($coche);
            }
        }            
        sort($reps);
        sort($sol);
        $recte =  $reps == $sol;
        $resp = implode(' ; ', $reps);
    }           
    echo "Prior quaestio : ".graisse(stripslashes($priorQ)).$alin;
    if (is_array($sol)) $sol= '<br>'.implode($alin, $sol);
    echo "Solutio : $sol\n";
    // mettre status à jour
    $iSensus = numSensus($priorS); 
    $quot = (integer)$status{$iSensus};
    //$pquot = $quot; // debog
    if ($priorS) {
        if ($recte) {
            echo "<div class=\"juste\">RECTE !</div>"; 
            // trouver l'indice du sens
            $quot++;
        } else {
            if ($quot > 0) $quot--;
            echo "<div class=\"faux\"> Errauisti. Respondisti : $resp</div>";
            //echo "quot ($iSensus) : $pquot -> $quot $alin"; // debog
        }
        $status{$iSensus} = (string)$quot;
    } else {
        if ($recte) {
            echo "<div class=\"juste\">RECTE !</div>"; 
            foreach ($reps as $resp) {
                $iSensus = numSensus($resp);
                $quot = (integer)$status[$iSensus];
                $quot++;
                $status{$iSensus} = (string)$quot;
            }
        } else {
            echo "<div class=\"faux\"> Errauisti. Respondisti : $resp</div>";
        }
    }
}

// maj de la liste de questionnement;
$dataq = array();
for ($i=0;$i<strlen($status);$i++) 
   if ($status{$i} < 3) $dataq[] = $omnesSensus[$i];
if (count($dataq) == 0) {
   // liste vide : hausser le niveau
   $niveau++;
   $dataq = $omnesSensus;
   $status = str_repeat('0', $totalS); 
   $message = "Tu viens de passer au niveau $niveau";
}
echo "$alin niveau $niveau, ". noti($status) ."/".$totalS * 3;

if ($niveau == 1)
    $casusSensus = 0;
elseif ($niveau == 2)
    $casusSensus = 1;
else unset($casusSensus); 
if ($niveau > 2) {
    $suivants = array('terra');
    include $incl.'suivants.php';
} else {
  if ($casusSensus > 0) {
    // a casu ad sensum 
    // supprimer les cas trouvés;
    $kasus = array();
    foreach (array_keys($data) as $k) {
       if ($status{numSensus($data[$k][0])} < 3) 
          $kasus[] = $k;
    }        
    $k = sorsColl($kasus);
    $collS = $data[$k];
    shuffle($omnesSensus);
    $p = 0;
    while (count($collS) < 8) {
        if (!in_array($omnesSensus[$p], $collS))
            $collS[] = $omnesSensus[$p];
        $p++;
    }
    shuffle($collS);
    $q = qCasusSensus($k);
} elseif($casusSensus == 0) {
    // a sensu ad casum 
    $sensus = sorsColl($dataq);
    $omnesCasus = array('nominatif','vocatif','accusatif',
                        'génitif','datif','ablatif');
    shuffle($omnesCasus);
    $q = qSensusCasus($sensus);
} 
?>
<form method="post">
<p class="questmin">
<?php
echo $q."</p><p>\n";
if ($casusSensus) {
    $i = 0;
    foreach($collS as $func) {
       echo '<input type="checkbox" name="sens'
       . $i .'" value="'.$func.'">'.$func.$alin;
       $i++;
    }
    echo '<input type="submit" class="questmin" value=" recte ? ">';
} else {
    foreach ($omnesCasus as $k)
       echo '<input type="submit" class="question" name="resp" value="'.$k.'">&nbsp;'."\n";
}        
?>
</p>
<input type="hidden" value="<?php echo $status ?>" name="status">
<input type="hidden" value="<?php echo $niveau ?>" name="niveau">
<input type="hidden" value="<?php echo $casusSensus ?>" name="priorks">
<?php
  // passage de la question
  if ($casusSensus) {
  echo '<input type="hidden" value="'.$k.'" name="priorK">';
  } else {
  echo '<input type="hidden" value="'.$sensus.'" name="priorS">';
  }
?>
</p>
</form>
<p class="redi"><a href='./'>reditus</a> <a href="gpl.html" target="gpl">Licentia GPL</a></p>
<?php
if (isset($message))
    echo "<span class=\"conseil\">$message</span>$alin";
//echo $totalS.$alin; // debog
// echo "status : *$status*"; // debog ?>
<?php } ?>
</body>
</html>
