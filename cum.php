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
$titre = "CVM";
include "lexica/datacum.php";

$alin = "<br>\n";
$ln = "\n";

function sorsColl($c) {
    if (count($c) == 1) return $c[0];
    return $c[mt_rand(0, count($c)-1)];   
}

function solutio($q) {
    global $niveau;
    global $data;
    global $lsens;
    global $i;
    // chercher la phrase.
    for($i=0;$i<count($data);$i++)
       if ($data[$i][1] == $q) break;
    if ($niveau == 1 || $niveau == 3) {
    // niveau 1 ou 3 : préposition ou conjonction ?
        //echo '*'.substr($d['sens'], 0, 4).'*';
        if (substr($lsens[$data[$i][0]], 0, 4) == 'prép') return 'Préposition';
        return 'Conjonction';
    }
    // niveau 2 ou 4 : sens ?
    return $lsens[$data[$i][0]];
}        

// niveau
if(isset($_POST["niveau"])) {
    $niveau = $_POST["niveau"];
    $status = $_POST["status"];
}
if (!isset($status)) {
   $ch = str_repeat('0', count($data));
   $niveau = 1;
} else { 
   // décryptage du status
   $ch = decbin(hexdec($status)); 
   $ch = substr($ch, 1);
   $resp = $_POST["resp"];
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
if (isset($resp)) {
   $priorphl = trim($_POST["priorQ"]);
   echo "Prior quaestio : $priorphl$alin";
   // extraire la solution
   $resp = trim($resp);
   if ($niveau == 2 || $niveau >= 4)
      $resp = $lsens[$resp];
   $sol = solutio($priorphl);
   echo "Solutio : $sol$alin";
   $recte = $resp == $sol;
   if ($recte) {
      echo "<div class=\"juste\">RECTE !</div>"; 
      // mettre status à jour
      $ch{$i} = '1';
   } 
   else echo "<div class=\"faux\"> Errauisti. Respondisti : $resp</div>";
   include "session.php.html";
}

// maj de la liste de questionnement;
$col = array();
for ($p=0;$p<strlen($ch);$p++)
    if ($ch{$p} == '0')
       $col[] = $data[$p];
// liste vide : hausser le niveau
if (count($col) == 0) {
   $niveau++;
   $ch = str_repeat('0', count($data)); 
   $col = $data;
}
// debog
//echo "ch(".strlen($ch).") : *$ch*$alin";
$totalq = count($data);
$sus = $totalq-count($col);
echo "$alin niveau $niveau, ". $sus."/".$totalq.$alin;   

// sententiam sortiri 
$ph = sorsColl($col);
echo '<p class="questmin">'.$ph[1]."</p>\n";
if ($niveau < 3)
    echo "<p>".$ph[2]."</p>\n"; 
echo '</p>'."\n".'<form method="post">'.$ln;
if ($niveau == 1 || $niveau == 3) {
   echo '<input type="submit" name="resp" class="questmin" value=" Préposition ">&nbsp;'.$ln;
   echo '<input type="submit" name="resp" class="questmin" value=" Conjonction ">&nbsp;'.$ln;
} else {
   echo '<select name="resp">'.$ln;
   //$prim = 1;
   echo '<option>Préposition</option>'*$ln; 
   for ($ns=0;$ns<count($lsens);$ns++)
       echo "<option value=\"$ns\">".$lsens[$ns]."\"</option>$ln";
    echo "</select>\n";
    echo '<input type="submit" class="questmin" name="subc" value=" valeur de CVM ">'.$ln;
}
// cryptage du status
$chstatus = '1'.$ch;
$status = dechex(bindec($chstatus));
?>
<input type="hidden" value="<?php echo $ph[1] ?>" name="priorQ">
<input type="hidden" value="<?php echo $status ?>" name="status">
<input type="hidden" value="<?php echo $niveau ?>" name="niveau">
</p>
</form>
<p class="redi"><a href='./'>reditus</a> <a href="gpl.html" target="gpl">Licentia GPL</a></p>
</body>
</html>
