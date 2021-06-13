<?php
// Facilitateur de lecture,
// méthode inspiré de la RAM de C. Pavur.

// initialiser le numero des derniers ajouts.
if (!isset($_GET['numero'])) 
   $numero = 1;
else $numero = $_GET['numero'];

if (!isset($_GET['fichier']))
    $fichier = 'phrase1.txt'; 
else $fichier = $_GET['fichier'];
   
// lire le fichier
if (isset($fichier)) {
   $f = fopen($fichier, "r");
   $texte = fread($f, filesize($fichier));
   fclose($f);
}   

// $aff est une copie de $texte, qui doit rester intact
$aff = $texte;

// supprimer les balises des segments déjà affichés
for ($i = 0; $i < $numero; $i ++)
   $aff = ereg_replace("(<$i>|</$i>)", "", $aff);

// en rouge, les segments nouvellement affichés
$aff = ereg_replace("<$i>", "<span class=\"rouge\">", $aff);
$aff = ereg_replace("</$i>", "</span>", $aff);  

// supprimer les autres balises
$aff = ereg_replace("<[0-9]*>[^<]*</[0-9]*>", "", $aff);
// penser au suivant
$numero++
?>
<html>
<head>
</head>
   <style>
      .rouge {    
    color : Red;
    font-weight : bold; 
      }
   </style>
<body>
<p><? echo $aff; ?></p>  
<a href="./">retour</a>
<a href="ram.php?texte=<? echo "$texte&numero=$numero"; ?>">la suite</a><br/>
</body>
</html>
