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
// module INCREMENTVM 
/*
   Ce module a pour but de gérer le questionnement sur une liste
   de paires question-réponse.
   Il utilise un tableau d'entiers longs pour transmettre de page
   en page l'état des items acquis et non acquis. un autre tableau
   garde quant à lui la liste des échecs récents.

   En cas d'échec sur une question, le bit représentant la question
   est désarmé, et considéré comme devant être demandé en priorité.

   Si la liste est entièrement sue, une nouvelle question est ajoutée.
*/

$maximum = 2147483647;

function sorsColl($c) {
   if (count($c) == 1) return $c[0];
   return $c[mt_rand(0, count($c)-1)];   
}

function coglex($cog, $num, $lex) {
   return $lex[$cog*31 + $num];
}        

function lexcog($gal, $lex) {
   for ($i = 0; $i < count($lex); $i++)
      if ($lex[$i][1] == $gal) {
         $cog = floor($i / 31);
         $num = $i % 31;
         break;
      }
   if (isset($cog)) return array($cog, $num);
   return false;
}        

function Qincr($lex, $cognita) {
   global $maximum;
   // include du lexique
   include $lex;
   // recensement des sus et non sus; 
   $listeN = array();
   $listeC = array();
   for ($cog = 0; $cog < count($cognita); $cog++) {
      $ch = decbin($cognita[$cog]);
      for ($car = 0; $car < strlen($ch); $car++) {
        $adde = coglex($cog, $car, $bini);
        if ($ch{$car} == '0')
            $listeN[] = $adde;
        else $listeC[] = $adde;
        }
   }
   if (count($listeN) > 0 && (count($listeC) == 0 || mt_rand(0,7) >= 3))
      return sorsColl($listeN);
   return sorsColl($listeC);
}

function perfectum($cognita) {
   global $maximum;
   foreach ($cognita as $num) {
      $ch = decbin($num);
      if (strpos('0', $ch)) return false;
   }
   return true;
}        

function ultima($gal, $cognita, $lex) {
    // renvoie vrai si $gal est 
    // le dernier bit du dernier item de $cognita
    $lc = lexcog($gal, $lex);
    $cog = $lc[0]; $num = $lc[1];
    $ch = decbin($cognita[count($cognita)-1]);
    return ($cog == count($cognita)-1 && $num == strlen($ch)-1); 
}

function succes($lex, $cognita, $gal ) {
   /* 
   armer le $gal enclavé.
   s'il n'y a plus d'enclave, 
      et si la question posée était nouvelle,
         ajouter un item dans le questionnement
   */
   global $maximum;
   include $lex;
   // armer $gal
   for($l = 0; $l < count($bini); $l++)
      if ($bini[$l][1] == $gal) {
         $cog = floor($l / 31);
         $num = $l % 31;
         break;
      }
   $ch = decbin($cognita[$cog]);
   //$ch{$num} = '1';
   $ch = substr_replace($ch, '1', $num, 1);
   $cognita[$cog] = bindec($ch); 
   if (perfectum($cognita) 
      and ultima($gal, $cognita, $bini) 
      and (bilan($cognita) < count($bini))) {
      // ajouter un item s'il en reste
         $ult = $cognita[count($cognita)-1];
         $ch = decbin($ult);
         // si le dernier item de cognita n'est pas saturé, 
         //ajouter 1 bit
         if (strlen($ch) < 31) {
            $ch = $ch.'0';
            $ult = bindec($ch);
            $cognita[count($cognita)-1] = $ult;
         }
         // sinon, ajouter un item à cognita
         else $cognita[] = '0';
      }
   return $cognita;
}

function echec($lex, $cognita, $gal) {
   // déclare l'échec de $gal, donc crée l'enclave correspondante
   include $lex;
   for ($i = 0; $i < count($bini); $i++)
       if ($bini[$i][1] == $gal) {
           $itemcog = floor($i/31);
           $itemcur = $i % 31;
           $ch = decbin($cognita[$itemcog]);
           $ch[$itemcur] = '0';
           $cognita[$itemcog] = bindec($ch);
       }
   return $cognita;
}        

function bilan($cognita) {
   $cog = 0;
   for ($i = 0; $i < count($cognita); $i++) {
       $ch = decbin($cognita[$i]);
       $cog += substr_count($ch, '1'); 
   }           
   return $cog;
}        

?>
