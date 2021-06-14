<html>
<?php
/*
 include "coniug.php";
 //   coniug($v, $m $ri, $rp, $rs, $tempus, $modus, $persona) {
// echo coniug("habeo","moneo","hab","habu","habit","plus-que-parfait","indicatif",5);
 echo "\n";
 foreach ($tempora as $t) {
    echo "<br>$t<br>\n";
    for ($i = 1; $i < 7; $i++)
       echo conjF("commencer",$t,"indicatif",$i)."<br>\n";
 }
*/
/*
include "decl.php";

//$modele = sorsM(array('uita','miles','manus'));
$modele = "mare"; 

$nomen = sorsN($modele);

$cas = array('nom','voc','acc','gen','dat','abl');
$nombres = array('sing','plur');

echo "<html>";
echo "<br>";
foreach($nombres as $n){
  foreach($cas as $c) {
     // function decline($l, $r, $m, $g, $c, $n) {
     echo decline($nomen[0], $nomen[1], $modele, $nomen[3], $c, $n)."<br>\n";
   }
   echo "&nbsp;<br>\n";
}
*/

function trans($ph, $m) { 
   global $aides;
   preg_match('/^(.*)-(.*)-(.*)$/', $ph, $eclats);
   $aides = explode('|',$eclats[2]);
   if ($m == 'q')
      return $eclats[1].'...'.$eclats[3];
   if ($m == 'o')
      return $eclats[1].$aides[0].$eclats[3];
}        

$ph = array('Dum illum -rideo|rideo, es, ere, risi, risum|ind.prés.-, paene sum factus ille.',
         'En me moquant de lui, je suis presque devenu lui.');

echo trans($ph[0], 'o');         
?>
</html>
