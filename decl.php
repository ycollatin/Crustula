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
// module de dÃ©clinaison
/*
Utilisation : 
   - lexique -> trouver le modÃ¨le x 7
   - lexique -> trouver l'accusatif x 5
   - lexique -> trouver l'accusatif pluriel ;
   - lexique -> trouver un cas ;
   - lexique -> trouver n'importe quel cas.
   - sans lexique -> trouver n'importe quel cas !
*/

$listeK = array(
  'nominatif','vocatif','accusatif','génitif','datif','ablatif');

$listeN = array('singulier','pluriel');  

$modeles = array(
   'uita', 'amicus', 'puer', 'ager', 'templum',
   'miles', 'ciuis', 'corpus', 'mare', 'manus', 'res');

function sorsColl($c) {
    if (count($c) == 1) return $c[0];
   return $c[mt_rand(0, count($c)-1)];   
}

function sorsM($l) {
   // tire un modÃ¨le
   global $modeles;
   if (empty($l)) return sorsColl($modeles);
   return sorsColl($l);
}

function sorsK(){
   // tire un cas
   global $listeK;
   return sorsColl($listeK);
}

function sorsNb(){
   // tire un nombre
   global $listeN;
   return sorsColl($listeN);
}

function sorsN($m) {
  // tire un nom de modÃ¨le $m et renvoie en tableau 
  // lemme, radical, modÃ¨le, genre, et texte complet de l'entrÃ©e lexicale
  include "lexica/".$m.".php";
  $l = sorsColl($lex);
  $l[4] = $l[0].", ".$l[4];
  return $l;
}

function linea($l, $m) {
  include "lexica/".$m.".php";
  foreach ($lex as $lin) {
     if ($lin[0] == $l) return $lin;
  }
}

function decline($l, $r, $m, $g, $c, $n) {
  $c = strtolower(substr($c, 0, 3));
  if ($c == 'gé') $c = 'gén'; // encore un coup de l'encodage !
  $n = strtolower($n{0});
  // ajustements
  if ($l == 'locus' && $n == 'p') $g = 'n';
  
  if ($c == 'nom') {
     // nominatif singulier
     if ($n == 's') return $l; 
     // nominatif pluriel
     if ($m == 'uita') return $r.'ae';
     if ($m == 'mare' ) return $r.'ia';
     if ($m == 'manus' && $g == 'n') return $r.'ua';
     if ($g == 'n') return $r.'a';
     if ($m == 'amicus' || $m == 'puer' || $m == 'ager') return $r.'i';
     if ($m == 'miles' || $m == 'ciuis') return $r.'es';
     if ($m == 'manus' || $m == 'res') return $l;
  }
  if ($c == 'voc') {
     // vocatif singulier
     if ($n == 's') {
        if ($l == 'deus') return $l;
	if (substr($l, -3) == "ius") return $r;
        if ($m == 'amicus') return $r.'e';
        return $l;
     }
     // vocatif pluriel
     return decline($l, $r, $m, $g, 'nom', $n);
  }
  if ($c == 'acc') {
     // accusatif singulier
     if ($n == 's') {
        if ($g == 'n') return $l;
	if ($m == 'uita') return $r.'am';
	if ($m == 'amicus' || $m == 'puer' 
	   || $m == 'ager' || $m == 'manus') return $r.'um';
	if ($l == 'turris') return 'turrim';
	if ($m == 'miles' || $m == 'ciuis' || $m == 'res') return $r.'em';
     }
     // accusatif pluriel
     if ($g == 'n') return decline($l, $r, $m, $g, 'nom', $n);
     if ($m == 'uita') return $r.'as';
     if ($m == 'amicus' || $m == 'puer' || $m == 'ager') return $r.'os';
     if ($m == 'miles' || $m == 'ciuis') return $r.'es';
     if ($m == 'manus' || $m == 'res') return decline($l, $r, $m, $g, 'nom', $n);
  }
  if ($c == 'gén' || $c == 'gen') {
     if ($n == 's') {
        // génifif singulier
	if ($m == 'uita') return $r.'ae';
	if ($m == 'amicus' || $m == 'puer' || $m == 'ager' || $m == 'templum') 
	   return $r.'i';
	if ($m == 'miles' || $m == 'ciuis' 
         || $m == 'corpus' || $m == 'mare') return $r.'is';
        if ($m == 'manus' || $m == 'cornu') return $r.'us';
	if ($m == 'res') return $r.'ei';
     }
     // génifif pluriel
     if ($l == 'bos') return 'boum';
     if ($m == 'uita') return $r.'arum';
     if ($m == 'amicus' || $m == 'puer' || $m == 'ager' || $m == 'templum') return $r.'orum';
     if ($m == 'miles' || $m == 'corpus') return $r.'um';
     if ($m == 'ciuis' || $m == 'mare') return $r.'ium';
     if ($m == 'manus' || $m == 'cornu') return $r.'uum';
     if ($m == 'res') return $r.'erum';
  }
  if ($c == 'dat') {
     if ($n == 's') {
        // datif singulier
	if ($m == 'uita') return $r.'ae';
	if ($m == 'amicus' || $m == 'puer' || $m == 'ager' || $m == 'templum') return $r.'o';
	if ($m == 'miles' || $m == 'ciuis' 
         || $m == 'corpus' || $m == 'mare') return $r.'i';
        if ($m == 'manus' || $m == 'cornu') return $r.'ui';
	if ($m == 'res') return $r.'ei';
     }
     // datif pluriel
     if ($l == 'bos') return 'bubus';
     if ($l == 'dea' || $l == 'filia') return $r.'abus';
     if ($m == 'uita' || $m == 'amicus' || $m == 'puer' || $m == 'ager' || $m == 'templum')
        return $r.'is';
     if ($m == 'miles' || $m == 'corpus' || $m == 'ciuis' || $m == 'mare' 
        || $m == 'manus' || $m == 'cornu')
        return $r.'ibus';
     if ($m == 'res') return $r.'ebus';
  }
  if ($c == 'abl') {
     if ($n == 's') {
     // ablatif singulier
     if ($m == 'uita') return $r.'a';
     if ($m == 'amicus' || $m == 'puer' || $m == 'ager' || $m == 'templum') return $r.'o';
     if ($m == 'miles' || $m == 'ciuis' || $m == 'corpus') 
        return $r.'e';
     if ($m == 'mare') return $r.'i';
     if ($m == 'manus' || $m == 'cornu') return $r.'u';
     if ($m == 'res') return $r.'e';
     }
     // ablatif pluriel
     return decline($l, $r, $m, $g, 'datif', $n);
  }
}
?>
