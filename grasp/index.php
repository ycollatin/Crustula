<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Facilitateur de lecture</title>
  <meta name="generator" content="amaya 6.2, see http://www.w3.org/Amaya/" />
  <style type="text/css">
  body { 
     font-family: Arial,Helvetica,sans-serif;
     opacity: 1;
     background-color: rgb(239, 240, 239);
     border-left-width: 20px;
    }

  h1 { 
    text-align: center;
    font-size: 20pt;
    color: rgb(255, 153, 102);
    }
  h2 { 
    text-align: center;
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

  </style>
 
</head>
<body>
<h1>Facilitateur de lecture, test inspiré de la GRASP</h1>
<h2>(GRadual Aggregative Syntactic Praxis), mise au point par Claude Pavur</h2>
<table class="rubrique"><tr><td>
La page de GRASP :<a href="http://www.slu.edu/colleges/AS/languages/classical/latin/tchmat/pedagogy/grasp.html">
http://www.slu.edu/colleges/AS/languages/classical/latin/tchmat/pedagogy/grasp.html</a><br>
<p> Hoc uide quoque :&nbsp;  
<a href="http://www.slu.edu/colleges/AS/languages/classical/latin/tchmat/pedagogy/har/har1.html">
http://www.slu.edu/colleges/AS/languages/classical/latin/tchmat/pedagogy/har/har1.html</a>
</p>
<?php
echo "phrases proposées <br/>\n";
$d_form =  "<form method=\"post\" action=\"grasp.php\">\n";
$d = dir("./txt");
while($entry=$d->read()) {
   //$breue = str_replace(".php","",$entry);
   if (!preg_match("/^\.+/", $entry))
      echo $d_form.'<input type="submit" value="'.$entry.'"><br>'."\n"
          .'<input type="hidden" name="fichier" value="'.$entry.'">'."</form>\n";
}
$d->close();
?>
</form>

<p>Vous pouvez tester le script en saisissant ici votre exercice. Il suffit
de placer entre &lt;1&gt;  et &lt;/1&gt; ce qui apparaîtra en premier, puis
entre &lt;2&gt; et &lt;/2&gt; ce qui apparaîtra ensuite, etc.</p>

<form method="post" action="grasp.php">
<p><textarea cols="80" rows="7" name="texte">
<2>Ibi </2><1>Syphax </1><4>dum obequitat hostium turmis </4><6>si </6><7>pudore, si periculo suo </7><6>fugam sistere posset </6><5>, equo grauiter icto </5><2>effusus </2><1>opprimitur capiturque </1><3>et uiuus </3><8>, laetum </8><10>ante omnes </10><9> Masinissae </9><8>praebiturus spectaculum, </8><3>ad Laelium pertrahitur</3>.
</textarea></p>
  <input type="submit" value="Valider" />
</form>
<p></p>
<a href="facgrasp.php">Un éditeur de Grasp</a>
</td></tr></table>
<a href="../#grasp">reditus</a>
</body>
</td></tr>
</html>
