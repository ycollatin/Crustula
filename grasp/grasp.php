<?php
// Facilitateur de lecture,
// méthode inspiré de la RAM de C. Pavur.

// initialiser le numero des derniers ajouts.
if (isset($_POST['numero'])) 
   $numero = $_POST['numero'];
else $numero = 0;

if (isset($_POST['fichier'])) {
   $fichier = $_POST['fichier'];
   $f = fopen("./txt/$fichier", "r");
   $texte = fread($f, filesize("./txt/$fichier"));
   fclose($f);
}   
elseif (isset($_POST['texte']))
   $texte = $_POST['texte'];

if (isset($_POST['porro'])) $numero++;
elseif (isset($_POST['retro'])) $numero--;
else $numero = 0;
   

// $aff est une copie de $texte, qui doit rester intact
$aff = $texte;

// supprimer les balises des segments déjà affichés
for ($i = 0; $i < $numero+1; $i ++)
   $aff = ereg_replace("(<$i>|</$i>)", "", $aff);

// en rouge, les segments nouvellement affichés
$aff = ereg_replace("<$i>", "<span class=\"rouge\">", $aff);
$aff = ereg_replace("</$i>", "</span>", $aff);  

// supprimer les autres balises
$aff = ereg_replace("<[0-9]*>[^<]*</[0-9]*>", "", $aff);
?>
<html>
<head>
</head>
  <style type="text/css">
  body { 
     font-family: Arial,Helvetica,sans-serif;
     opacity: 1;
     background-color: rgb(239, 240, 239);
    }

  h1 { 
    text-align: center;
    font-size: 20pt;
    color: rgb(255, 153, 102);
    }

  table.rubrique { 
    border-style: dotted;
    background-color: white;
    display: block;
    margin-left: 20px;
    margin-right: 20px;
    }

  .gras { 
    font-weight: bold;
    }

  .italique { 
    font-style: italic;
    }

  .petit { 
    font-size: 8pt;
    }
   .maior
    {
       font-size: 14pt;
    }

  .signature{ 
    font-size: 8pt;
    text-align: right
    }

  .date { font-size: 10pt;
    text-align: right;
    }
  .rouge {    
    color : Red;
    font-weight : bold; 
  }
  </style>
<body>
<h1>GRASP via PHP</h1>
<table class="rubrique"><tr><td>
<p><?php echo "$numero <br/>\n $aff"; ?></p>  
<form method="post">
<input type="submit" name="retro" value=" Retro ">&nbsp;
<input type="submit" name="porro" value=" Porro ">
</td></tr></table>
<input type="hidden" value="<?php echo $texte ?>" name="texte">
<input type="hidden" value="<?php echo $numero ?>" name="numero">
</form>
<a href="./">retour</a>
<?php
?>
</td></tr></table>
</body>
</html>
