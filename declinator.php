<html>
<head>
<title>DECLINATOR</title>
</head>
<body>
<h1>DECLINATOR</h1>
<form method="post">
<?php
$debog = 0;
$nl = "<br />\n";

$cursus = array('nomen','num_decl','paradigma','radix',
    'desinentia','forma','solutio');
$doc_num_decl =
  "-ae : prima declinatio. e. g. terra, ae, f. $nl
   -i  : secunda declinatio. e. g. amicus, i, m. $nl
   -is : tertia declinatio. e. g. miles, itis, m. $nl
   -us : quarta declinatio. e. g. manus, us, f. $nl
   -ei : quinta declinatio. e. g. res, rei, f. $nl";

function dic ($sent)
{
   echo $sent."\n";
}

function brn ($sent)
{
   echo $sent."<br />\n";
}


function num_decl ($gen)
{
   preg_match ("/(ae$|[^e]i|is|us|ei)$/", $gen, $inv);
   if ($inv[1] == 'ae') return 'prima';
   if ($inv[1] == 'ei') return 'quinta';
   if ($inv[1] == 'is') return 'tertia';
   if ($inv[1] == 'us') return 'quarta';
   if (preg_match ("/i$/", $inv[1])) return 'secunda';
   return "nil !";
}

function paradigma ($n, $nd, $g)
{
    // nomen inusitatum adhuc
    if ($nd == 'prima') return 'terra';
    if ($nd == 'secunda')
    {
       if ($g == 'neutrum') return 'templum';
       return 'amicus';
    }
    if ($nd == 'tertia')
    {
       if ($g == 'neutrum') return 'corpus';
       return 'miles';
    }
    if ($nd == 'quarta') return 'manus';
    if ($nd == 'quinta') return 'res';
}

function radix ($gen, $n)
{
    if ($n == 'secunda' || $n == 'quinta')
       return substr ($gen, 0, -1);
    return substr ($gen, 0, -2);
}

function quod_scimus ()
{
   global $nomen, $genetiuus, $genus, $casus, $numerus,
          $ndecl, $paradigma, $radix, $desinentia;

   $r = "$nomen, $genetiuus, $genus";
   if (!empty ($casus))
      $r .= ", $casus $numerus";
   if (!empty ($ndecl))
      $r .= ", declination $ndecl";
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

$quaestus = $_POST['quaestus'];
if (empty($quaestus)) $statio = "nomen";
else 
{
   $statio = $_POST['statio'];
   $clauis = array_search ($statio, $cursus);
   if ($quaestus == 'PORRO') $clauis++; 
   elseif ($quaestus == 'RETRO') $clauis--;
   else $clauis = 0;
   $statio = $cursus[$clauis];
}

// STATIONES

if ($statio == 'nomen') 
{
    $prior = "";
    dic ('Quid nomen declinare uis ?');
    brn ('<input type="text" name="nomen">');
    dic ('Genetium da mihi istius nominis, quaeso.');
    brn ('<input type="text" name="genetiuus">');
    dic ('Quid est genus eius ?');
    echo '<input type="radio" name="genus" value="masculinum">masculinum';
    echo '&nbsp;<input type="radio" name="genus" value="femininum">femininum';
    brn ('<input type="radio" name="genus" value="neutrum">neutrum');
    brn ('<p>quem casum ? ');
    brn ('<input type="radio" name="casus" value="nominatiuus">nominatiuus');
    brn ('<input type="radio" name="casus" value="uocatiuus">uocatiuus');
    brn ('<input type="radio" name="casus" value="accusatiuus">accusatiuus');
    brn ('<input type="radio" name="casus" value="genetiuus">genetiuus');
    brn ('<input type="radio" name="casus" value="datiuus">datiuus');
    dic ('<input type="radio" name="casus" value="ablatiuus">ablatiuus</p>');
    brn ('<p>quem numerum ? ');
    brn ('<input type="radio" name="numerus" value="singularis">singularis');
    dic ('<input type="radio" name="numerus" value="pluralis">pluralis</p>');
}

// declinationis numerus

elseif ($statio == 'num_decl')
{
    $nomen = $_POST['nomen'];
    $genetiuus = $_POST['genetiuus'];
    $genus = $_POST['genus'];
    $casus = $_POST['casus'];
    $numerus = $_POST['numerus'];
    brn ("<h2>". quod_scimus () . "</h2>");
    dic ($doc_num_decl); 
    //$ndecl = num_decl ($genetiuus);
    brn ('<p><input type="radio" name="ndecl" value="prima">prima declinatio');
    brn ('<input type="radio" name="ndecl" value="secunda">secunda declinatio');
    brn ('<input type="radio" name="ndecl" value="tertia">tertia declinatio');
    brn ('<input type="radio" name="ndecl" value="quarta">quarta declinatio');
    echo '<input type="radio" name="ndecl" value="quinta">quinta declinatio</p>';
    
    //printf ('<p>%s, %s : %s declinatio</p>', $nomen, $genetiuus, $ndecl);
    dic ('<input type="hidden" name="nomen" value="'.$nomen.'">');
    dic ('<input type="hidden" name="genetiuus" value="'.$genetiuus.'">');
    dic ('<input type="hidden" name="genus" value="'.$genus.'">');
    dic ('<input type="hidden" name="casus" value="'.$casus.'">');
    dic ('<input type="hidden" name="numerus" value="'.$numerus.'">');
}


// paradigma

elseif ($statio == 'paradigma')
{
    $genetiuus = $_POST['genetiuus'];
    $nomen = $_POST['nomen'];
    $genus = $_POST['genus'];
    $casus = $_POST['casus'];
    $numerus = $_POST['numerus'];
    $genetiuus = $_POST['genetiuus'];
    $ndecl = $_POST['ndecl'];
    brn ("<h2>". quod_scimus () . "</h2>");
    printf ('Nunc istius nominis paradigma scire potes :<br />',
            $nomen, $genetiuus, $genus, $ndecl);
    dic ('<input type="radio" name="paradigma" value="terra">prima : terra <br />');
    dic ('<input type="radio" name="paradigma" value="amicus">secunda : amicus <br />');
    dic ('<input type="radio" name="paradigma" value="templum">secunda (neutrum) : templum <br />');
    dic ('<input type="radio" name="paradigma" value="miles">tertia : miles <br />');
    dic ('<input type="radio" name="paradigma" value="corpus">tertia (neutrum) : corpus <br />');
    dic ('<input type="radio" name="paradigma" value="manus">quarta : manus <br />');
    dic ('<input type="radio" name="paradigma" value="res">quinta : res <br />');
    dic ('<input type="hidden" name="nomen" value="'.$nomen.'">');
    dic ('<input type="hidden" name="genetiuus" value="'.$genetiuus.'">');
    dic ('<input type="hidden" name="genus" value="'.$genus.'">');
    dic ('<input type="hidden" name="casus" value="'.$casus.'">');
    dic ('<input type="hidden" name="numerus" value="'.$numerus.'">');
    dic ('<input type="hidden" name="ndecl" value="'.$ndecl.'">');
}

// radix et 

elseif ($statio == 'radix')
{
    $genetiuus = $_POST['genetiuus'];
    $nomen = $_POST['nomen'];
    $ndecl = $_POST['ndecl'];
    $genus = $_POST['genus'];
    $paradigma = $_POST['paradigma'];
    $casus = $_POST['casus'];
    $numerus = $_POST['numerus'];
    brn ("<h2>". quod_scimus () . "</h2>");
    printf ("Nunc radix scire debes istius nominis");
    dic ("gallice : pour trouver le radical, prends le génitif ; enlève-lui sa désinence (-ae, -i, -is, "
        ."-us, -ei");
    dic ('Radix : ');
    dic ('<input type="text" name="radix"><br />');
    dic ('<input type="hidden" name="nomen" value="'.$nomen.'">');
    dic ('<input type="hidden" name="genetiuus" value="'.$genetiuus.'">');
    dic ('<input type="hidden" name="genus" value="'.$genus.'">');
    dic ('<input type="hidden" name="casus" value="'.$casus.'">');
    dic ('<input type="hidden" name="numerus" value="'.$numerus.'">');
    dic ('<input type="hidden" name="ndecl" value="'.$ndecl.'">');
    dic ('<input type="hidden" name="casus" value="'.$casus.'">');
    dic ('<input type="hidden" name="numerus" value="'.$numerus.'">');
    dic ('<input type="hidden" name="paradigma" value="'.$paradigma.'">');
}

// desinentia

elseif ($statio == 'desinentia')
{
    $genetiuus = $_POST['genetiuus'];
    $nomen = $_POST['nomen'];
    $ndecl = $_POST['ndecl'];
    $genus = $_POST['genus'];
    $paradigma = $_POST['paradigma'];
    $casus = $_POST['casus'];
    $numerus = $_POST['numerus'];
    $radix = $_POST['radix'];

    $solutio = radix ($genetiuus, $ndecl);
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
    $genetiuus = $_POST['genetiuus'];
    $nomen = $_POST['nomen'];
    $ndecl = $_POST['ndecl'];
    $genus = $_POST['genus'];
    $paradigma = $_POST['paradigma'];
    $casus = $_POST['casus'];
    $numerus = $_POST['numerus'];
    $radix = $_POST['radix'];
    $desinentia = $_POST['desinentia'];

    $solutio = desinentia ($nomen, $radix, $paradigma, $casus, $numerus);
    if ($desinentia == $solutio) dic ("RECTE !$nl");
    else
    {
        printf ("ERRAVISTI ! Non est %s sed %s !<br />\n", $desinentia, $solutio);
        $desinentia = $solutio;
    }

    printf ("Nunc declinare debes nomen %s, "
           ."casus %s et numerus %s <br />\n", 
           $nomen, $casus, $numerus);
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
    $genetiuus = $_POST['genetiuus'];
    $nomen = $_POST['nomen'];
    $ndecl = $_POST['ndecl'];
    $genus = $_POST['genus'];
    $paradigma = $_POST['paradigma'];
    $casus = $_POST['casus'];
    $numerus = $_POST['numerus'];
    $radix = $_POST['radix'];
    $desinentia = $_POST['desinentia'];
    $forma = $_POST['forma'];

    $solutio = $radix.$desinentia;
    if ($forma == $solutio)  dic ("RECTE !$nl");
    else
    {
        printf ("ERRAVISTI ! Non est %s sed %s !<br />\n", $forma, $solutio);
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
if ($statio != 'nomen')
  echo '<input type="submit" name="quaestus" value="RETRO">&nbsp;';
if ($statio != 'solutio')
  echo '<input type="submit" name="quaestus" value="PORRO">&nbsp;';
else
  echo '<input type="submit" name="quaestus" value="DENUO">&nbsp;';

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
