<?php
/*
###############################################################################
#
#    This file is part of CASVS
#
#    CASVS is free software; you can redistribute it and/or modify
#    it under the terms of the GNU General Public License as published by
#    the Free Software Foundation; either version 2 of the License, or
#    (at your option) any later version.
#
#    CASVS is distributed in the hope that it will be useful,
#    but WITHOUT ANY WARRANTY; without even the implied warranty of
#    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#    GNU General Public License for more details.
#
#    You should have received a copy of the GNU General Public License
#    along with CASVS; if not, write to the Free Software
#    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
#
###############################################################################
   bogae : irregulares : filius voc fili; bos ; domus ;
*/
?>
<html>
<head>
<link rel="STYLESHEET" href="casus.css" type='text/css'>
<title>CASVS</title>
</head>
<body>
<p class="titre">CASVS</p>
<form method="post">
<?php
$debog = 0;
$nl = "<br />\n";

function iiult ($n)
{
    return substr ($n, -2);
}

function e_ciuis ($n)
// uera si nomen $n declinatur secundum 'ciuis'
{
// haec nomina, quanquam uidentur e 'ciuis', e miles !
$emiles =  array ("absis","cinis","cuspis","canis","iuuenis","lapis","puluis",
    "pyramis","pyxis","sanguis");
// haec autem, e ciuis certe sunt :
$eciuis = array ("dos","imber","lis","nix","proles","sedes","trabs");
// duas ultimas litteras extrahimus :
$ii = array ('is','bs','ns','nx','rs');
$iiult = iiult ($n); 
if ((array_search ($iiult, $ii)
   || array_search ($n, $eciuis))
  && !(array_search ($n, $emiles)))
  return true;
return false;
}

function dic ($sent)
{
   echo $sent."\n";
}

function brn ($sent)
{
   echo $sent."<br />\n";
}

function paradigma ($nom, $gen, $mfn)
{
    $iiult = iiult ($gen);
    $iult = substr ($gen, -1);
    $iiultn = iiult ($nom);
    if ($iiult == 'ae') return "terra";
    if ($iiult == 'es' && iiult ($gen) == 'ei') return 'res'; 
    if ($iult == 'i')
    {
        if ($mfn == 'neutrum') return 'templum';
        if (substr ($gen, -3) == 'eri') return 'puer';
        if ($iiult == 'ri' && $iiultn == 'er') return 'ager';
        return 'amicus';
    }
    if ($iiult == 'is')
    {
        if ($mfn == 'neutrum')
        {
            if ($iiultn == 'ar' || $iult == 'e') return 'mare';
            else return 'corpus';
        } 
        elseif ($iiultn == 'is' || e_ciuis ($nom))
                return 'ciuis';
        else return 'miles'; 
    }
    if ($iiult == 'us') return 'manus';
    return 'nescio !';
}

function radix ($gen, $p)
{
    if (array_search ($p, array('amicus','templum','puer','ager')))
       return substr ($gen, 0, -1);
    return substr ($gen, 0, -2);
}

function habet ($incl, $k)
{
    include $incl;
    if (isset ($nomina[$k])) return $nomina[$k];
    return false;
}

function quaest_gen ($k)
{
   $capsae = array ( 'ager', 'amicus', 'ciuis', 'corpus', 'manus', 
                     'mare', 'miles', 'puer', 'res', 'templum', 'terra');
   foreach ($capsae as $c)
   {   
       $h = habet ("$c.php", $k);
       if ($h)
           switch ($c)
           {
              case 'ager': return substr ($k, 0, -2).'ri'; break;
              case 'amicus':; case 'res':; case 'templum': return substr ($k, 0, -1).'i'; break;
              case 'ciuis':; case 'corpus':; case 'mare':; case 'miles': return $h[1].'is'; break;
              case 'manus': return $k; break;
              case 'puer': return $k.'i'; break;
              case 'terra': return $k.'e';
           }
   }
   return false;
}

function quod_scimus ()
{
   global $nomen, $genetiuus, $genus, $casus, $numerus,
          $paradigma, $radix, $desinentia;

   $r = "$nomen, $genetiuus, $genus";
   if (!empty ($casus))
      $r .= ", $casus $numerus";
   if (!empty ($paradigma))
      $r .= ", paradigmate $paradigma";
   if (!empty ($radix))
      $r .= ", radice $radix";
   if (!empty ($desinentia))
      $r .= " et desinentia $desinentia";
   return $r;
}

function desinentia($nomen, $radix, $paradigma, $casus, $numerus)
{
      $tr = array (
         'nominatiuus' => 'N',
         'uocatiuus' => 'V',
         'accusatiuus' => 'Ac',
         'genetiuus' => 'G',
         'datiuus' => 'D',
         'ablatiuus' => 'Ab');
       $k = $tr[$casus];
       $tr = array (
         'singularis' => 's',
         'pluralis' => 'p');
       $n = $tr[$numerus];
       
   if ($paradigma == 'terra')      
      $d = array (
         's' => array ( 
           'N' => 'a',
           'V' => 'a',
           'Ac' => 'am',
           'G' => 'ae',
           'D' => 'ae',
           'Ab' => 'a'),
         'p' => array (
           'N' => 'ae',
           'V' => 'ae',
           'Ac' => 'as',
           'G' => 'arum',
           'D' => 'is',
           'Ab' => 'is')
        );
   elseif ($paradigma == 'amicus')
      $d = array (
         's' => array ( 
           'N' => 'us',
           'V' => 'e',
           'Ac' => 'um',
           'G' => 'i',
           'D' => 'o',
           'Ab' => 'o'
           ),
         'p' => array (
           'N' => 'i',
           'V' => 'i',
           'Ac' => 'os',
           'G' => 'orum',
           'D' => 'is',
           'Ab' => 'is')
           );
   elseif ($paradigma == 'puer' || $paradigma == 'ager')
      $d = array (
         's' => array ( 
           'N' => '',
           'V' => '',
           'Ac' => 'um',
           'G' => 'i',
           'D' => 'o',
           'Ab' => 'o'
           ),
         'p' => array (
           'N' => 'i',
           'V' => 'i',
           'Ac' => 'os',
           'G' => 'orum',
           'D' => 'is',
           'Ab' => 'is')
           );
   elseif ($paradigma == 'templum')
      $d = array (
         's' => array ( 
           'N' => 'um',
           'V' => 'um',
           'Ac' => 'um',
           'G' => 'i',
           'D' => 'o',
           'Ab' => 'o'
           ),
         'p' => array (
           'N' => 'a',
           'V' => 'a',
           'Ac' => 'a',
           'G' => 'orum',
           'D' => 'is',
           'Ab' => 'is')
           );
   elseif ($paradigma == 'miles')
      $d = array (
         's' => array ( 
           'N' => '',
           'V' => '',
           'Ac' => 'em',
           'G' => 'is',
           'D' => 'i',
           'Ab' => 'e'
           ),
         'p' => array (
           'N' => 'es',
           'V' => 'es',
           'Ac' => 'es',
           'G' => 'um',
           'D' => 'ibus',
           'Ab' => 'ibus')
           );
   elseif ($paradigma == 'ciuis')
      $d = array (
         's' => array ( 
           'N' => '',
           'V' => '',
           'Ac' => 'em',
           'G' => 'is',
           'D' => 'i',
           'Ab' => 'e'
           ),
         'p' => array (
           'N' => 'es',
           'V' => 'es',
           'Ac' => 'es',
           'G' => 'ium',
           'D' => 'ibus',
           'Ab' => 'ibus')
           );
   elseif ($paradigma == 'corpus')
      $d = array (
         's' => array ( 
           'N' => '',
           'V' => '',
           'Ac' => '',
           'G' => 'is',
           'D' => 'i',
           'Ab' => 'e'
           ),
         'p' => array (
           'N' => 'a',
           'V' => 'a',
           'Ac' => 'a',
           'G' => 'um',
           'D' => 'ibus',
           'Ab' => 'ibus')
           );
   elseif ($paradigma == 'mare')
      $d = array (
         's' => array ( 
           'N' => '',
           'V' => '',
           'Ac' => '',
           'G' => 'is',
           'D' => 'i',
           'Ab' => 'i'
           ),
         'p' => array (
           'N' => 'ia',
           'V' => 'ia',
           'Ac' => 'ia',
           'G' => 'ium',
           'D' => 'ibus',
           'Ab' => 'ibus')
           );
   elseif ($paradigma == 'manus')
      $d = array (
         's' => array ( 
           'N' => 'us',
           'V' => 'us',
           'Ac' => 'um',
           'G' => 'us',
           'D' => 'ui',
           'Ab' => 'u'
           ),
         'p' => array (
           'N' => 'us',
           'V' => 'us',
           'Ac' => 'us',
           'G' => 'uum',
           'D' => 'ibus',
           'Ab' => 'ibus')
           );
   elseif ($paradigma == 'res')
      $d = array (
         's' => array ( 
           'N' => 'es',
           'V' => 'es',
           'Ac' => 'em',
           'G' => 'ei',
           'D' => 'ei',
           'Ab' => 'e'
           ),
         'p' => array (
           'N' => 'es',
           'V' => 'es',
           'Ac' => 'es',
           'G' => 'erum',
           'D' => 'ebus',
           'Ab' => 'ebus')
           );
   return $d[$n][$k];
}

$cursus = array('nomen','paradigma','radix',
    'desinentia','forma','solutio');

$quaestus = $_POST['quaestus'];
if (empty($quaestus)) $statio = "nomen";
else 
{
   $nomen = $_POST['nomen'];
   $genus = $_POST['genus'];
   $casus = $_POST['casus'];
   $numerus = $_POST['numerus'];
   $genetiuus = $_POST['genetiuus'];
   $statio = $_POST['statio'];
   $clauis = array_search ($statio, $cursus);
   if ($quaestus == 'PORRO') $clauis++; 
   elseif ($quaestus == 'RETRO') $clauis--;
   $statio = $cursus[$clauis];
   // si nomen neutrum, casus accusatiuus, numerus singularis, a paradigmate ad ultimam stationem eundum !
   if ($statio != 'solutio' && $genus == 'neutrum' && $casus == 'accusatiuus' && $numerus == 'singularis')
       {
          $acc_sing_neut = 1;
          $statio = 'forma';
       }
   // si nominatiuus singularis quaeritur, itur ad ultimam stationem !
   if ($statio != 'solutio' && $casus == 'nominatiuus' && $numerus == 'singularis')
       {
          $nom_sing = 1;
          $statio = 'forma';
       }
   if ($quaestus == 'DENUO') $statio = 'nomen';
}

// STATIONES

if ($statio == 'nomen') 
{
    echo "<table>\n";
    $prior = "";
    dic ('<tr><td>Quod nomen declinare uis ?</td>');
    dic ('<td><input type="text" name="nomen"></td></tr>');
    dic ('<td>Genetiuum da mihi istius nominis, quaeso.</td>');
    brn ('<td><input type="text" name="genetiuus"></td></tr>');
    dic ('<td>Quid est genus eius ?</td>');
    echo '<td><input type="radio" name="genus" value="masculinum">masculinum';
    echo '&nbsp;<input type="radio" name="genus" value="femininum">femininum';
    dic ('<input type="radio" name="genus" value="neutrum">neutrum</td></tr>');
    dic ('<tr><td>&nbsp;</td></tr>');
    dic ('<tr><td>quem casum ? <br />');
    brn ('<input type="radio" name="casus" value="nominatiuus">nominatiuum');
    brn ('<input type="radio" name="casus" value="uocatiuus">uocatiuum');
    brn ('<input type="radio" name="casus" value="accusatiuus">accusatiuum');
    brn ('<input type="radio" name="casus" value="genetiuus">genetiuum');
    brn ('<input type="radio" name="casus" value="datiuus">datiuum');
    dic ('<input type="radio" name="casus" value="ablatiuus">ablatiuum</td>');
    brn ('<td valign="top">quem numerum ? ');
    brn ('<input type="radio" name="numerus" value="singularis">singularem');
    dic ('<input type="radio" name="numerus" value="pluralis">pluralem</td></tr>');
    echo "</table>\n";
}

// paradigma
elseif ($statio == 'paradigma')
{
    /*
    $nomen = $_POST['nomen'];
    $genus = $_POST['genus'];
    $casus = $_POST['casus'];
    $numerus = $_POST['numerus'];
    */
    if (empty ($genetiuus))
    {
        $genetiuus = quaest_gen ($nomen);
        brn ("genetiuum non dedisti, $genetiuus");
    }
    brn ("<h2>". quod_scimus () . "</h2>");
    brn ('Nunc istius nominis declinationem paradigmaque scire potes ');
    dic ('<input type="radio" name="paradigma" value="terra">prima : terra <br />');
    dic ('<input type="radio" name="paradigma" value="amicus">secunda : amicus <br />');
    dic ('<input type="radio" name="paradigma" value="puer">secunda : puer <br />');
    dic ('<input type="radio" name="paradigma" value="ager">secunda : ager <br />');
    dic ('<input type="radio" name="paradigma" value="templum">secunda (neutrum) : templum <br />');
    dic ('<input type="radio" name="paradigma" value="miles">tertia : miles <br />');
    dic ('<input type="radio" name="paradigma" value="ciuis">tertia : ciuis <br />');
    dic ('<input type="radio" name="paradigma" value="corpus">tertia (neutrum) : corpus <br />');
    dic ('<input type="radio" name="paradigma" value="mare">tertia (neutrum) : mare <br />');
    dic ('<input type="radio" name="paradigma" value="manus">quarta : manus <br />');
    dic ('<input type="radio" name="paradigma" value="res">quinta : res <br />');
    dic ('<input type="hidden" name="nomen" value="'.$nomen.'">');
    dic ('<input type="hidden" name="genetiuus" value="'.$genetiuus.'">');
    dic ('<input type="hidden" name="genus" value="'.$genus.'">');
    dic ('<input type="hidden" name="casus" value="'.$casus.'">');
    dic ('<input type="hidden" name="numerus" value="'.$numerus.'">');
    dic ('<input type="hidden" name="ndecl" value="'.$ndecl.'">');

    $auxilium=
     'Si genetiuum habet in -ae, prima declinatio, TERRA<br />'
    .'Si genetiuum habet in -i, secunda. Sed tres paradigmata sunt :<br />'
    .'-us, i, m. aut f. : AMICVS<br />'
    .'-er, eri, m. : PVER<br />'
    .'-er, ri, m. : AGER<br />'
    .'Si genetiuum habet in -is, tertia. Sed quattuor sunt paradigmata :<br />'
    .'?, is, m. aut f. : saepe MILES, aliquando CIVIS<br />'
    .'?, is, n. : saepe CORPVS, rarissime MARE<br />'
    .'us, us, m. aut f. : MANVS<br />'
    .'es, ei, m. aut f. : RES"';
}
/*
    dic ('<div class="question" onMouseOver="javascript:auxilium.style.visibility=\'visible\';" '
      .  'onMouseOut="javascript:auxilium.style.visibility=\'hidden\';">Auxilium</div>');
    dic ('<div id="auxilium"style="visibility:hidden">'
    .'Si genetiuum habet in -ae, prima declinatio, TERRA<br />'
    .'Si genetiuum habet in -i, secunda. Sed tres paradigmata sunt :<br />'
    .'-us, i, m. aut f. : AMICVS<br />'
    .'-er, eri, m. : PVER<br />'
    .'-er, ri, m. : AGER<br />'
    .'Si genetiuum habet in -is, tertia. Sed quattuor sunt paradigmata :<br />'
    .'?, is, m. aut f. : saepe MILES, aliquando CIVIS<br />'
    .'?, is, n. : saepe CORPVS, rarissime MARE<br />'
    .'us, us, m. aut f. : MANVS<br />'
    .'es, ei, m. aut f. : RES"</div>');
*/    

// radix 

elseif ($statio == 'radix')
{
    /*
    $nomen = $_POST['nomen'];
    $genus = $_POST['genus'];
    $casus = $_POST['casus'];
    $numerus = $_POST['numerus'];
    */
    $paradigma = $_POST['paradigma'];
    brn ("<h2>". quod_scimus () . "</h2>");
    $solutio = paradigma ($nomen, $genetiuus, $genus);
    if ($paradigma == $solutio) dic ("<p class=\"juste\">RECTE : $paradigma</p>");
    else 
    {
        dic ("<p class=\"faux\">ERRAVISTI ! paradigma est $solutio.</p>");
        $paradigma = $solutio;
    }
    include "$paradigma.php"; 
    $linea = $nomina[$nomen];
    if ($linea) 
        brn ("id nomen cognoui :  $nomen, ". $linea[3]);
    else brn ("$nomen : id non est in lexico meo !");
    printf ("Nunc radix scire debes istius nominis.$nl");
    brn ("Gallice dictum : pour trouver le radical, prends le génitif ($genetiuus) ;"
        ."enlève-lui sa désinence (-ae, -i, -is, -us, -ei)");
    dic ('Radix : ');
    dic ('<input type="text" name="radix"><br />');
    dic ('<input type="hidden" name="nomen" value="'.$nomen.'">');
    dic ('<input type="hidden" name="genetiuus" value="'.$genetiuus.'">');
    dic ('<input type="hidden" name="genus" value="'.$genus.'">');
    dic ('<input type="hidden" name="casus" value="'.$casus.'">');
    dic ('<input type="hidden" name="numerus" value="'.$numerus.'">');
    dic ('<input type="hidden" name="casus" value="'.$casus.'">');
    dic ('<input type="hidden" name="numerus" value="'.$numerus.'">');
    dic ('<input type="hidden" name="paradigma" value="'.$paradigma.'">');
}

// desinentia

elseif ($statio == 'desinentia')
{
    /*
    $nomen = $_POST['nomen'];
    $genus = $_POST['genus'];
    $casus = $_POST['casus'];
    $numerus = $_POST['numerus'];
    */
    $paradigma = $_POST['paradigma'];
    $radix = $_POST['radix'];

    $solutio = radix ($genetiuus, $paradigma);
    if ($radix == $solutio) dic ("RECTE !$nl");
    else 
    {
        printf ("ERRAVISTI : dicendum erat %s, non %s !<br />\n", 
           $solutio, $radix);
        $radix = $solutio;
    }
    brn ("<h2>". quod_scimus () . "</h2>");

    brn ('Nunc desinentiam scire debes :');
    dic ('<input type="text" name="desinentia">');

    dic ('<input type="hidden" name="nomen" value="'.$nomen.'">');
    dic ('<input type="hidden" name="genetiuus" value="'.$genetiuus.'">');
    dic ('<input type="hidden" name="genus" value="'.$genus.'">');
    dic ('<input type="hidden" name="casus" value="'.$casus.'">');
    dic ('<input type="hidden" name="numerus" value="'.$numerus.'">');
    dic ('<input type="hidden" name="ndecl" value="'.$ndecl.'">');
    dic ('<input type="hidden" name="casus" value="'.$casus.'">');
    dic ('<input type="hidden" name="numerus" value="'.$numerus.'">');
    dic ('<input type="hidden" name="paradigma" value="'.$paradigma.'">');
    dic ('<input type="hidden" name="radix" value="'.$radix.'">');

}

// forma

elseif ($statio == 'forma')
{
   /*
    $nomen = $_POST['nomen'];
    $genus = $_POST['genus'];
    $casus = $_POST['casus'];
    $numerus = $_POST['numerus'];
    */
    if ($nom_sing || $acc_sing_neut) 
    {
       brn ("<h2>". quod_scimus () . "</h2>");
       dic ("Frustra laborem tibi das ! Forma eadem est ac nominatiuo casu ! quam hic scribe : ");
    }
    else
    { $paradigma = $_POST['paradigma'];
        $radix = $_POST['radix'];
        $desinentia = $_POST['desinentia'];

        $solutio = desinentia ($nomen, $radix, $paradigma, $casus, $numerus);
        if ($desinentia == $solutio) dic ("RECTE !$nl");
        else
        {
            printf ("ERRAVISTI ! Non est %s sed %s !<br />\n", $desinentia, $solutio);
            $desinentia = $solutio;
        }
        brn ("<h2>". quod_scimus () . "</h2>");
        dic ("Nunc solutionem tenes : radicem + desinentiam !");
    }

    dic ('<input type="text" name="forma">');
    dic ('<input type="hidden" name="nomen" value="'.$nomen.'">');
    dic ('<input type="hidden" name="genetiuus" value="'.$genetiuus.'">');
    dic ('<input type="hidden" name="genus" value="'.$genus.'">');
    dic ('<input type="hidden" name="casus" value="'.$casus.'">');
    dic ('<input type="hidden" name="numerus" value="'.$numerus.'">');
    dic ('<input type="hidden" name="ndecl" value="'.$ndecl.'">');
    dic ('<input type="hidden" name="casus" value="'.$casus.'">');
    dic ('<input type="hidden" name="numerus" value="'.$numerus.'">');
    dic ('<input type="hidden" name="paradigma" value="'.$paradigma.'">');
    dic ('<input type="hidden" name="radix" value="'.$radix.'">');
    dic ('<input type="hidden" name="desinentia" value="'.$desinentia.'">');

}           

// solutio
elseif ($statio == 'solutio')
{
    /*
    $nomen = $_POST['nomen'];
    $genus = $_POST['genus'];
    $casus = $_POST['casus'];
    $numerus = $_POST['numerus'];
    */
    $paradigma = $_POST['paradigma'];
    $radix = $_POST['radix'];
    $desinentia = $_POST['desinentia'];
    $forma = $_POST['forma'];
    brn ("<h2>". quod_scimus () . "</h2>");
    if (
           ($casus == 'nominatiuus' && $numerus == 'singularis')
        || ($casus == 'accusatiuus' && $genus == 'neutrum' && $numerus == 'singularis'))
        $solutio = $nomen;
    else $solutio = $radix.$desinentia;
    if ($forma == $solutio)  dic ("<h2>RECTE : $solutio !$nl</h2>");
    else
    {
        printf ("<h2>ERRAVISTI ! Non est %s sed %s !</h2>\n", $forma, $solutio);
        $forma = $solutio;
    }
    dic ('<input type="hidden" name="nomen" value="'.$nomen.'">');
    dic ('<input type="hidden" name="genetiuus" value="'.$genetiuus.'">');
    dic ('<input type="hidden" name="genus" value="'.$genus.'">');
    dic ('<input type="hidden" name="casus" value="'.$casus.'">');
    dic ('<input type="hidden" name="numerus" value="'.$numerus.'">');
    dic ('<input type="hidden" name="ndecl" value="'.$ndecl.'">');
    dic ('<input type="hidden" name="casus" value="'.$casus.'">');
    dic ('<input type="hidden" name="numerus" value="'.$numerus.'">');
    dic ('<input type="hidden" name="paradigma" value="'.$paradigma.'">');
    dic ('<input type="hidden" name="radix" value="'.$radix.'">');
    dic ('<input type="hidden" name="desinentia" value="'.$desinentia.'">');
}

// CAVDA
dic ('<input type="hidden" name="statio" value="'.$statio.'">');
if ($statio != 'solutio')
   echo '<input type="submit" name="quaestus" value="PORRO">&nbsp;';
else
   echo '<input type="submit" name="quaestus" value="DENUO">&nbsp;';
if ($statio != 'nomen')
   echo '<input type="submit" name="quaestus" value="RETRO">&nbsp;';
if (!empty ($auxilium)) 
{
   dic ('<div class="question" onMouseOver="javascript:auxilium.style.visibility=\'visible\';" '
       .'onMouseOut="javascript:auxilium.style.visibility=\'hidden\';">Auxilium</div>');
   dic ('<div id="auxilium"style="visibility:hidden">'. $auxilium .'</div>');
}
if ($debog)
{
  dic ("\n$nl quaestus :$quaestus:");
  dic ("$nl statio :$statio:");
  dic ("$nl nomen :$nomen:");
  dic ("$nl genetiuus :$genetiuus:");
  dic ("$nl ndecl :$ndecl:");
  dic ("$nl solutio :$solutio:");
}
?>
</form>
</body>
</html>
