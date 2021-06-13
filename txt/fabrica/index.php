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
Fabrica : ut nouum textum facilius facias
*/
$alinea = "<br>\n";
function ouvre($titre) {
    return fopen("$titre.php", "ab");
}

$statio = $_POST['statio'];
if (empty($statio))
$statio = 0;
$Nouam = $_POST['Nouam'];
if ($Nouam == "Explicit") {
    $titre = $_POST['titre'];
    $capsa = ouvre($titre);
    fwrite ($capsa, "\n);\n?>");
    fclose($capsa);
    $statio = 0;
} elseif ($Nouam == "Nouam") {
    $statio = 1;
    $entete = True;
    $titre = $_POST['titre'];
    $capsa = ouvre($titre);
    fwrite ($capsa, ",\n");
    fclose($capsa);
}
?>
<html>
<head>
<title>CRVSTVLORVM FABRICA<?php echo $titre ?></title>
<?php 
include "../../css.inc";
include "../../meta.inc.php";
?>
</head>
<body>
<p class="titre">CRVSTVLORVM FABRICA</p>
<?php 
echo "<form method=\"post\">\n";
//*****************************************
if ($statio == 0) { // titre
    echo "titulum : <input type=\"text\" name=\"titre\">$alinea";
    echo "<input type=\"hidden\" name=\"statio\" value=\"1\">$alinea"; 
    echo "<input type=\"submit\" value=\" sit \">$alinea";
//*****************************************
} elseif ($statio == 1) { // phrases latine et française
    $capsa = $_POST['capsa'];
    if (empty($capsa) and !$entete) {
        $titre = $_POST['titre'];
        $capsa = ouvre($titre);
        fwrite($capsa, "<?php\n");
        fwrite($capsa, '$titre = "'.$titre.'";'."\n");
        fwrite($capsa, '$data = array('."\n");
        fclose($capsa);
    } 
    echo "sententiam, latine. Syntagmata a punctis disiungere necessest.$alinea";
    //echo "<input type=\"text\" size=\"90\" name=\"latine\">$alinea";
	echo "<textarea cols=\"80\" rows=\"5\" name=\"latine\"></textarea>";
    echo "sententiam, gallice (syntagmata, etc.)$alinea";
    //echo "<input type=\"text\" size=\"90\" name=\"gallice\">$alinea";
    echo "<textarea cols=\"80\" rows=\"5\" name=\"gallice\"></textarea>$alinea";
    echo "<input type=\"hidden\" name=\"statio\" value=\"2\">$alinea"; 
    echo "<input type=\"hidden\" name=\"titre\" value=\"$titre\">$alinea"; 
    echo "<input type=\"submit\" value=\" sit \">$alinea";
//*****************************************
} elseif ($statio == 2) { // ordinem
    $latine = $_POST['latine'];
    $gallice = $_POST['gallice'];
    // scribere in discum
    $clatine = explode('.', $latine);
    $cgallice = explode('.', $gallice);
    $titre = $_POST['titre'];
    $capsa = ouvre($titre);
    fwrite($capsa, "    array(\n");
    fwrite($capsa, "    'lat'=>array(");
    $primus = True;
    foreach ($clatine as $cl)
        if ($primus) {
            fwrite($capsa, "'$cl'");
            $primus = False;
        } else fwrite($capsa, ",'$cl'");
    fwrite($capsa, "),\n");
    fwrite($capsa, "    'fr'=>array(");
    $primus = True;
    foreach ($cgallice as $cg)
        if ($primus) {
            fwrite($capsa, "'$cg'");
            $primus = False;
        } else fwrite($capsa, ",'$cg'");
    fwrite($capsa, "),\n");
    fclose($capsa);
    echo "Sub latino syntagmate numerum scribe gallici"; 
    // tabula
    echo "<table>\n<tr>\n";
    // linea latinorum syntagmatum
    foreach ($clatine as $cl)
        echo "   <td>$cl</td>\n";
    echo "</tr>\n<tr>\n";
    // linea ubi scribas ordines
    $i = 0;
    foreach ($clatine as $cl) {
        echo "   <td><input type=\"text\" size=\"3\" name=\"cl$i\"></td>\n";
        $i++;
    }
    echo "</tr>\n<tr>\n";
    // linea gallicorum syntagmatum
    $i = 0;
    foreach ($cgallice as $cg) {
        echo "   <td>$i. $cg</td>\n";
        $i++;
    }
    echo "</tr>\n</table>\n";
    echo "<input type=\"hidden\" name=\"statio\" value=\"3\">$alinea"; 
    echo "<input type=\"hidden\" name=\"titre\" value=\"$titre\">$alinea"; 
    echo "<input type=\"hidden\" name=\"quot\" value=\"".count($clatine)."\">$alinea"; 
    echo "<input type=\"hidden\" name=\"latine\" value=\"$latine\">$alinea"; 
    echo "<input type=\"submit\" value=\" sit \">$alinea";
//*****************************************
} elseif ($statio == 3) { // casus
    $quot = $_POST['quot'];
    $titre = $_POST['titre'];
    // in discum
    $capsa = ouvre($titre);
    fwrite($capsa, "    'ord'=>array(");
    for ($i=0;$i<=$quot;$i++) 
        $ordo[] = $_POST["cl$i"];
    $primus = True;
    foreach ($ordo as $o) 
        if ($primus) {
            fwrite ($capsa, $o);
            $primus = False;
        } else fwrite($capsa, ",$o");
    fwrite($capsa, "),\n");
    // casus dicere
    $latine = $_POST['latine'];
    $clatine = explode('.', $latine);
    echo "si casus est syntagmati, eum subscribe.$alinea";
    echo "Sic scribes : N,V,Ac,G,D,Ab.$alinea";
    echo "<table>\n<tr>\n   ";
    foreach ($clatine as $cl)
        echo "<td>$cl</td>\n";
    echo "</tr>\n<tr>\n    ";
    $i = 0;
    foreach ($clatine as $cl) {
        echo "<td><input type=\"text\" size=\"2\" name=\"f$i\"></td>\n    ";
        $i++;
    }
    echo "</tr>\n</table>";
    echo "<input type=\"hidden\" name=\"titre\" value=\"$titre\">$alinea"; 
    echo "<input type=\"hidden\" name=\"quot\" value=\"$quot\">$alinea"; 
    echo "<input type=\"hidden\" name=\"statio\" value=\"4\">$alinea"; 
    echo "<input type=\"submit\" value=\" sit \">$alinea";
//*****************************************
} elseif ($statio == 4) { // nouam ? 
    $quot = $_POST['quot']; 
    for ($i = 0;$i<$quot;$i++)
        $k[] = $_POST["f$i"];
    // in discum
    $titre = $_POST['titre'];
    $capsa = ouvre($titre);
    fwrite($capsa, "    'cas'=>array(");
    $i = 0;
    $primus = True;
    foreach($k as $casus) {
        if (!empty($casus)) {
            if (!$primus) fwrite($capsa,',');
            fwrite($capsa, "$i=>'$casus'");
            $primus = False;
            }
            $i++;
        }
    fwrite($capsa, ")\n    )");
    echo "Nunc potes nouam sententiam addere, aut abire.";
    echo "<input type=\"hidden\" name=\"titre\" value=\"$titre\">$alinea"; 
    echo '<input type="submit" name="Nouam" value="Nouam">&nbsp;';
    echo '<input type="submit" name="Nouam" value="Explicit">'.$alinea;
}
//*****************************************
echo "</form>\n";
echo "</body>\n";
echo "</html>";
