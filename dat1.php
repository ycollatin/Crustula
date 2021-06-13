<?php
/*
                     capsa dat1.php

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

bogues :
  - les doublons s/o/dat. ne sont pas neutralisés ;
  - Les phrases françaises commencent par des minuscules.

*/
$alin = "<br>\n";

$pers = array(0, 1, 2, 3, 4, 5, 6);

/*
pecuniam uxorem filiam reddo, 
chose est + pers, 
iniuriam facere + pers, 
salutem pecuniam dare + pers., 
statuam ponere + pers
pareo + pers dat
*/

function sors ($c) 
{
    if (count ($c) == 1) return 0;
    return mt_rand(0, count ($c)-1);
}

function sorsColl($c) {
    return $c[sors ($c)];   
}

class Sententia
{
   var $nomina = array(
       array('pat-er-rem-ri', 'm', 'mon père'),     // 0
       array('mat-er-rem-ri', 'f', 'ma mère'),      // 1
       array('frat-er-rem-ri', 'm', 'mon frère'),   // 2
       array('sor-or-orem-ori', 'm', 'ma soeur'),   // 3
       array('fili-us-um-o', 'n', 'mon fils'),      // 4
       array('fili-a-am-ae', 'f', 'ma fille'),      // 5
       array('ux-or-orem-ori',  'f', 'ma femme'),   // 6

       array('pecuni-a-am-ae', 'f', "l'argent"),    // 7
       array('iniuri-a-am-ae', 'f', "un préjudice"),// 8
       array('statu-a-am-ae', 'f', 'une statue'),   // 9
       array('liberta-s-tem-tis', 'f', 'la liberté')// 10
       );

   var $sujets;
   var $datifs;
   var $objets;
   var $verbes;
   var $personne;
   var $nombre;

   var $sujet;
   var $objet;
   var $datif;

   var $Nsujet;
   var $Nnobjet;
   var $Ndatif;

   var $datavl = array();
   var $datavg = array();

   function tire_personne ()
   {
       return sorsColl (array(1,2,3));
   }

   function tire_nombre ()
   {
      return sorsColl (array('s', 'p'));
   }

   function tire_sujet ()
   {
      $this->Nsujet = sorsColl ($this->sujets);
      $this->sujet = $this->nomina[$this->Nsujet];
   }

   function tire_objet ()
   {
      $this->Nobjet = sorsColl ($this->objets);
      $this->objet = $this->nomina[$this->Nobjet];
   }

   function tire_datif ()
   {
      $this->Ndatif = sorsColl ($this->datifs);
      $this->datif = $this->nomina[$this->Ndatif];
   }

   function decl($nomen, $k) 
   {
       $eclats = explode ('-', $nomen[0]);
       $radical = $eclats[0];
       if ($k == 'n') return $radical.$eclats[1];
       if ($k == 'a') return $radical.$eclats[2];
       return  $radical.$eclats[3];
   }

   function sujet_nom ()
   {
       return ($this->personne == 3 && $this->nombre == 's');
   }

   function lat ()
   {
       $r = array();
       if ($this->sujet_nom ())
           $r[] = $this->decl ($this->sujet, 'n');
       $r[] = $this->decl ($this->objet, 'a');
       $r[] = $this->decl ($this->datif, 'd');
       if ($this->nombre == 's')
           $r[] = $this->datavl[$this->personne - 1];
       else $r[] = $this->datavl[$this->personne + 2];
       shuffle ($r);
       return implode (' ', $r);
   }

   function gal ()
   {
       // sujet
       $r = '';
       if ($this->sujet_nom())
       {
           $r = $this->sujet[2];
           $r .= " ";
       }
       // verbe
       if ($this->nombre == 's')
           $r .= $this->datavg[$this->personne - 1];
       else $r .= $this->datavg[$this->personne + 2];
       $r .= " ";
       // objet
       $r .= $this->objet[2];
       // datif
       $r .= ' à ';
       $r .= $this->datif[2];
       
       return $r;
   }

   function schema()
   {
       return sprintf("%d:%s:%d:%d:%d:%s", 
          $this->personne,
          $this->nombre,
          $this->Nsujet,
          $this->Nobjet,
          $this->Ndatif,
          $this->Classe
          );
   }

   function doc ()
   {
      echo "personne : ".$this->personne." du ".$this->nombre;
      echo "<br>\n";
   }

   function Sententia ($sch="-")
   {
     if ($sch == "-") {
       $this->personne = $this->tire_personne ();
       $this->nombre   = $this->tire_nombre ();
       $this->tire_sujet ();
       do $this->tire_objet ();
          while ($this->Nobjet == $this->Nsujet);
       do $this->tire_datif ();
          while ($this->Ndatif == $this->Nobjet || $this->Ndatif == $this->Nsujet);
     }
     else
     {
        $eclats = explode(":", $sch);
        $this->personne = $eclats[0];
        $this->nombre = $eclats[1];
        $this->Nsujet = $eclats[2];
        $this->Nobjet = $eclats[3];
        $this->Ndatif = $eclats[4];
        $this->Classe = $eclats[5];

        if ($this->sujet_nom ()) $this->sujet = $this->nomina[$this->Nsujet];
        else $this->sujet = '';
        if (count ($this->objets) > 0) $this->objet = $this->nomina[$this->Nobjet];
        $this->datif = $this->nomina[$this->Ndatif];
     }
     
   }
}


class Spareo extends Sententia
{
    var $sujets = array (0,1,2,3,4,5,6);
    var $objets = array ();
    var $datifs = array (0,1,2,3,4,5,6); 
    var $datavl = array('pareo','pares','paret','paremus','paretis','parent');
    var $datavg = array("j'obéis",'tu obéis','obéit','nous obéissons','vous obéissez','ils obéissent');
    var $Classe = "pareo";
}

class Sreddo extends Sententia
{
    var $sujets = array (0,1,2,3,4,5,6);
    var $objets = array(7, 9, 10);
    var $datifs = array (0,1,2,3,4,5,6);
    var $datavl = array('reddo','reddis','reddit','reddimus','redditis','reddunt');
    var $datavg = array('je rends','tu rends','rend','nous rendons','vous rendez','ils rendent');
    var $Classe = 'reddo';
}

class Sfacio extends Sententia
{
    var $sujets = array (0,1,2,3,4,5,6);
    var $objets = array (8);
    var $datifs = array (0,1,2,3,4,5,6);
    var $datavl = array ('facio','facis','facit','facimus','facitis','faciunt');
    var $datavg = array ('je cause','tu causes','cause','nous causons','vous causez','ils causent');
    var $Classe = 'facio';
}

class Sdo extends Sententia
{
    var $sujets = array (0,1,2,3,4,5,6);
    var $objets = array (7, 9, 10);
    var $datifs = array (0,1,2,3,4,5,6);
    var $datavl = array ('do','das','dat','damus','datis','dant');
    var $datavg = array ('je donne','tu donnes','donne','nous donnons','vous donnez','ils donnent');
    var $Classe = 'do';
}

class Spono extends Sententia
{
    var $sujets = array (0,1,2,3,4,5,6);
    var $objets = array (8);
    var $datifs = array (0,1,2,3,4,5,6);
    var $datavl = array ('facio','facis','facit','facimus','facitis','faciunt');
    var $datavg = array ('je cause','tu causes','cause','nous causons','vous causez','ils causent');
    var $Classe = 'facio';
}

class Ssum extends Sententia
{
    var $datifs = array (0,1,2,3,4,5,6);
    var $sujets = array (7, 9);
    var $datavl = array ('sum','es','est','sumus','estis','sunt');
    var $datavg = array ("j'ai",'tu as','a','nous avons','vous avez','ils ont');
    var $Classe = 'sum';

   function tire_personne ()
   {
       return 3;
   }

   function tire_nombre ()
   {
      return 's';
   }

   function gal()
   {
       return sprintf ("%s a %s.", $this->datif[2], $this->sujet[2]);
   }
}

$meta = sorsColl(array('latine','gallice'));
$liste_s = array('pareo','reddo','facio','do','pono','sum');
$cl = sorsColl ($liste_s);
// DEBOG
//$cl = 'sum';
// fin debog
if     ($cl == 'pareo') $sAb = new Spareo ;
elseif ($cl == 'reddo') $sAb = new Sreddo ;
elseif ($cl == 'facio') $sAb = new Sfacio ;
elseif ($cl == 'do')    $sAb = new Sdo ;
elseif ($cl == 'pono')  $sAb = new Spono ;
elseif ($cl == 'sum') $sAb = new Ssum ;

if ($meta == 'latine') $sententia = $sAb->lat (); 
else $sententia = $sAb->gal ();

session_start();
?>
<html>
<head>
<title>CRVSTVLA - DATIVVS CASVS</title>
<?php 
   include "css.inc";
   include "meta.inc.php";   
?>
</head>
<body>
<p class="titre">
    DATIVVS CASVS 
</p>
<?php
// nettoyage de chaîne
function nettoie ($ch) {
   $r = trim ($ch);
   $r = preg_replace ("/\s+/", " ", $r);
   $r = strtolower ($r);
   $r = str_replace('.', '', $r);
   return $r;
}


if (isset($_POST["schema"])) 
   $schema = $_POST["schema"]; 
if (isset($schema)) {
    $resp = $_POST['resp']; 
    $resp = stripslashes ($resp);
    $respC = trim($resp);
    // solutionem a schemate
    $eclats = explode(":", $schema);
    $kl = $eclats[5];
    if     ($kl == 'pareo') $priorAbs = new Spareo ($schema) ;
    elseif ($kl == 'reddo') $priorAbs = new Sreddo ($schema) ;
    elseif ($kl == 'facio') $priorAbs = new Sfacio ($schema) ;
    elseif ($kl == 'do')    $priorAbs = new Sdo ($schema) ;
    elseif ($kl == 'pono')  $priorAbs = new Spono ($schema) ;
    elseif ($kl == 'sum')   $priorAbs = new Ssum ($schema) ;
// Debog
// echo "Classe : $kl<br>";
// fin Debog

    $pMeta = $_POST['meta'];
    if ($pMeta == 'gallice')
    {
        // alphabeticum ordinem ut comparatio pertinens fiat.
        $eclats = explode (' ', $respC);
        natcasesort($eclats);
        $respC = implode (' ', $eclats);

        $sol = $priorAbs->lat ();
        $eclats = explode (' ', $sol);
        natcasesort ($eclats);
        $solC = implode (' ', $eclats);

        $priorSent = $priorAbs->gal ();
    }
    else 
    { 
        $sol = $priorAbs->gal (); 
        $solC = $sol;
        $priorSent = $priorAbs->lat ();
        $respC = $resp;
    }
    $solC = nettoie ($solC);
    $respC = nettoie ($respC);
    echo "Prior Sententia : $priorSent $alin";
    echo "Respondisti &laquo;$resp&raquo;$alin";
    echo "Solutio : &laquo;$sol&raquo;$alin";
    //debog
/*
    echo "DEBOG<br>schéma :$schema:".$priorAbs->gal().':'.$priorAbs->lat().':<br>';
    echo "pMeta :$pMeta<br>\n";
    echo "solC,respC :$solC:$respC:<br>\n";
    echo "recte:$recte:<br>\n";
*/
    // fin debog
    // $recte = ($sol == $resp);
    //$recte = strcasecmp($solC, $respC) == 0;
    $recte = ($solC == $respC);
    if ($recte)
        echo "<div class=\"juste\">RECTE !</div>"; 
    else 
        echo "<div class=\"faux\"> Errauisti.";
    include "session.php.html";
} else {
   $_SESSION['prius'] = 0;
   $_SESSION['consec'] = 0;
}
?>
</p>
<p class="question">
   <?php 
   echo $sententia;
   // echo "<br>\n".$sAb['num']; // debog
   ?> 
</p>
<form method="post">
<p class="question">
<input type="text" size="45" name="resp">
<?php
echo "<input type=\"submit\" value=\" Num recte dixi ? \">\n";
echo "<input type=\"hidden\" name=\"meta\" value=\"$meta\">\n";
echo "<input type=\"hidden\" name=\"schema\" value=\"".$sAb->schema ()."\">\n";
?>
</p>
</form>
<div class="conseil">Utilise "mon" et "ma" devant tous les noms de personne,<br />
    Pour les autres noms : l'argent, un préjudice, une statue, la liberté.</div>

<p class="redi"><a href='./'>reditus</a> <a href="gpl.html" target="gpl">Licentia GPL</a></p>
</body>
</html>
