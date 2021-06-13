<?php
$auxilium = 
"Totam sententiam ab initio scribere debes. "
."Deinde, ut additiones indica per signa "
   ."'<' et '>'. ";

function balisas ($sen, $sta)
{
    $r = preg_replace("/\(/","<$sta@", $sen);
    $r = preg_replace("/\)/","</$sta@", $r);
    $r = preg_replace("/@/",">", $r);
    return $r;
}

if (isset ($_POST['sententia']))
{
   $sententia = $_POST['sententia'];
   $statio = $_POST['statio'];
   $sententia = balisas ($sententia, $statio);
} 
else
{
    $sententia = "Cum M. Crassus "
                ."exercitum Brundisii inponeret, quidam in portu caricas "
                ."Cauno advectas vendens Cauneas clamitabat.";  
    $statio = 0;
    // signa < et > fieri debent balisae.
}
?>
<html>
<head>
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

  </style>
</head>
<body>
<h1><?php echo "GRASP editor, statio $statio"; ?></h1>
<table class="rubrique">
<tr><td>
<div class="italique">
Primum, totam sententiam hic infer et inter parentheses inseres
quae in proxima statio esse uolueris.<br/>
Dein, tantum parentesibus cura.
</div>
<form method="post" action="facgrasp.php">
<textarea class="maior" name="sententia" cols="80" rows="5"><?php echo $sententia;?></textarea><br/>
<input type="submit" value=" Porro ">
<input type="hidden" value="<?php echo $statio+1; ?>" name="statio">
</form>
</td></tr>
</table><br/>
<a href="./">reditus</a>
</body>
