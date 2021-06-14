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
// module de conjugaison
$infectum = array("présent","futur","imparfait");
$perfectum = array("parfait","futur antérieur","plus-que-parfait");
$tempora = array_merge($infectum, $perfectum);
$personne = array('','je','tu','il','nous','vous','ils');

function elide($pronom, $forme) {
   if ($pronom == 'je' && in_array($forme{0}, array('a','e','é','i','o','u')))
      return "j'$forme";
   return "$pronom $forme";
}

function coniug($v, $m, $ri, $rp, $rs, $tempus, $modus, $persona) {
   // $v = verbe
   // $m = modèle (sum, amo, moneo, lego, capio, audio)
   // $ri, $rp, $rs : radical infectum, perfectum, supin
global $infectum, $perfectum, $tempora;
// data
$templatum = array('o','is','it','imus','itis','unt');
$templatum_int = array('o','is','it','imus','itis','int');
$futAm = array('am','es','et','emus','etis','ent');

if (in_array($tempus, $infectum))
   $radix = $ri;
else $radix = $rp;
if ($modus == 'infinitif')
   if ($tempus == 'présent')
        switch($m) 
        {
            case "amo":
                return $radix.'are';
                break; // inutile, censeo. sed.
            case "sum":
                return $radix.'esse';
                break;
            case 'moneo':
            case 'lego':
            case 'capio':
                return $radix.'ere';
                break;
            case 'audio':
                return $radix.'ire';
        }

// reste plus que l'indicatif
switch ($tempus) {
   case "présent":
      switch($m) {
          case "sum":
	         $liste_d = array('sum','es','est','sumus','estis','sunt');
             break;
          case "amo":
	         $liste_d = array('o','as','at','amus','atis','ant');
	         break;
          case "moneo":
	         $liste_d = array('eo','es','et','emus','etis','ent');
             break;
          case "lego":
	         $liste_d = $templatum; 
	         break;
          case "capio":
	      case "audio":
	         $liste_d = array('io','is','it','imus','itis','iunt');
	         break;
      }
      break;
   case "futur":
      switch($m) {
          case "sum":
	     $radix = 'er';
	     $liste_d = $templatum;
	     break;
          case "amo":
	     $radix .= 'ab';
	     $liste_d = $templatum;
	     break;
          case "moneo":
	     $radix .= 'eb';
	     $liste_d = $templatum;
	     break;
          case "lego":
	     $liste_d = $futAm;
	     break;
          case "capio":
	  case "audio":
	     $radix .= 'i';
	     $liste_d = array('am','es','et','emus','etis','ent');
	     break;
      }
      break;
   case "imparfait":
      $liste_d = array('bam','bas','bat','bamus','batis','bant');
      switch($m) {
          case "sum":
	     $radix = 'er';
	     break;
          case "amo":
	     $radix .= 'a';
	     break;
          case "moneo":
	     $radix .= 'e';
	     break;
          case "lego":
	     $radix .= 'e';
	     break;
          case "capio":
	  case "audio":
	     $radix .= 'ie';
	     break;
      }
      break;
   case "parfait":
      $liste_d = array('i','isti','it','imus','istis','erunt');
      break;
   case "futur antérieur":
      $radix .= 'er';
      $liste_d = $templatum_int;
      $liste_d[6] = 'int';
      break;
   case "plus-que-parfait":
      $radix .= 'er';
      $liste_d = array('am','as','at','amus','atis','ant');
      break;
}
return $radix.$liste_d[$persona-1];
}

function conjF($v,$t,$m,$p) {
   // data
   $avoir_impf = array('avais','avais','avait','avions','aviez','avaient');
   $avoir_fut  = array('aurai','auras','aura','aurons','aurez','auront');
   $etre_impf = array('étais','étais','était','étions','étiez','étaient');
   $etre_fut = array('serai','seras','sera','serons','serez','seront');
   $desFut = array('ai','as','a','ons','ez','ont');
   $desImpf  = array('ais','ais','ait','ions','iez','aient');
   $desPrSst = array('s','s','t','ons','ez','ent');
   $desPrDsdsd = array('ds','ds','d','ons','ez','ent');
   $desPrIrissant = array('is','is','it','issons','issez','issent');
   $desPsU = array('us','us','ut','ûmes','ûtes','urent');
   $desPsI = array('is','is','it','îmes','îtes','irent');
   $desPsIn = array('ins','ins','int','înmes','întes','inrent');

   $auxEtre = in_array($v, array('venir','partir','devenir','rester'));
   // commun
   if ($t == "futur") $desin = $desFut;
   elseif ($t == "imparfait") $desin = $desImpf;
   elseif ($t == "plus-que-parfait") {
      $desin = array();
      if ($auxEtre) $aux = $etre_impf;
      else $aux = $avoir_impf;
   }
   elseif ($t == "futur antérieur") {
      $desin = array();
      if ($auxEtre) $aux = $etre_fut;
      else $aux = $avoir_fut;
   }
   // modèles
   if (substr($v, -2) == 'er') {
      $radix = substr($v, 0, -2);
      $pp = $radix.'é';
      switch($t) {
          case "présent":
	     $desin = array('e','es','e','ons','ez','ent');
	     if (substr($radix,-1) == 'y' && in_array($p, array(1,2,3,6)))
	         $radix = substr($radix, 0, -1).'i';
             elseif (substr($radix,-2,1)=='é' && !in_array($p, array(4,5)))
	         $radix{strlen($radix)-2} = 'è';
	     break;
	  case "futur":
	     $radix = $v; 
	     if ($v == 'renvoyer') $radix = 'renverr'; 
	     break;
	  case "imparfait":
	     $desin = $desImpf;
	     break;
	  case "parfait":
	     $desin = array('ai','as','a','âmes','âtes','èrent');
      }
      if ((substr($radix, -1) == 'c') 
          && (preg_match("/^[aâouû]/", $desin[$p-1])==1))
          $radix = preg_replace("/c$/","ç", $radix);
  }
  elseif ($v == "avoir") {
      $radix = '';
      $pp = 'eu';
      switch($t) {
          case "présent":
	     $desin = array('ai','as','a','avons','avez','ont');
	     break;
	  case "futur":
	     $radix = 'aur';
	     $desin = $desFut;
	     break;
	  case "imparfait":
	     $desin = $avoir_impf;
	     break;
	  case "parfait":
	     $radix = 'e';
	     $desin = $desPsU;
     }
  }
  elseif ($v == "être") {
      $radix = '';
      $pp = 'été';
      switch($t) {
          case "présent":
	     $desin = array('suis','es','est','sommes','êtes','sont');
	     break;
	  case "futur":
	     $radix = 'ser';
	     $desin = $desFut;
	     break;
	  case "imparfait":
         $radix = 'ét';
	     $desin = $desImpf;
	     break;
	  case "parfait":
	     $radix = 'f';
	     $desin = $desPsU;
     }
  }
  elseif ($v == 'recevoir') {
      $pp = 'reçu';
      switch($t) {
          case "présent":
	     $desin = $desPrSst;
	     if ($p < 4) $radix = 'reçoi';
	     elseif ($p < 6) $radix = 'recev';
	     else $radix = 'reçoiv';
	     break;
	  case "futur":
	     $radix = 'recevr';
	     $desin = $desFut;
	     break;
	  case "imparfait":
	     $radix = 'recev';
	     $desin = $desImpf;
	     break;
	  case "parfait":
	     $radix = 'reç';
	     $desin = $desPsU;
     }
  }
  elseif ($v == 'vivre') {
      $pp = 'vécu';
      switch($t) {
          case "présent":
	     $desin = $desPrSst;
	     if ($p < 4) $radix = 'vi';
	     else $radix = 'viv';
	     break;
	  case "futur":
	     $radix = 'vivr';
	     $desin = $desFut;
	     break;
	  case "imparfait":
	     $radix = 'viv';
	     $desin = $desImpf;
	     break;
	  case "parfait":
	     $radix = 'véc';
	     $desin = $desPsU;
     }
  }
  elseif ($v == 'détruire') {
      $pp = 'détruit';
      $radix = 'détruis';
      switch($t) {
          case "présent":
	     $desin = $desPrSst;
	     if ($p < 4) $radix = 'détrui';
	     break;
	  case "futur":
	     $radix = 'détruir';
	     $desin = $desFut;
	     break;
	  case "imparfait":
	     $desin = $desImpf;
	     break;
	  case "parfait":
	     $desin = $desPsI;
     }
  }
  elseif ($v == 'venir') {
      $pp = 'venu';
      switch($t) {
          case "présent":
	     $desin = $desPrSst;
	     if ($p < 4) $radix = 'vien';
	     elseif ($p < 6) $radix = 'ven';
	     else $radix = 'vienn';
	     break;
	  case "futur":
	     $radix = 'viendr';
	     $desin = $desFut;
	     break;
	  case "imparfait":
	     $radix = 'ven';
	     $desin = $desImpf;
	     break;
	  case "parfait":
	     $radix = 'v';
	     $desin = $desPsIn;
     }
  }
  elseif ($v == 'transmettre') {
      $pp = 'transmis';
      switch($t) {
          case "présent":
	     $desin = $desPrSst;
	     if ($p < 3) $radix = 'transmet';
	     elseif ($p == 3) $radix = 'transme';
	     else $radix = 'transmett';
	     break;
	  case "futur":
	     $radix = 'transmettr';
	     $desin = $desFut;
	     break;
	  case "imparfait":
	     $radix = 'transmett';
	     $desin = $desImpf;
	     break;
	  case "parfait":
	     $radix = 'transm';
	     $desin = $desPsI;
     }
  }
  elseif ($v == 'rendre') {
      $pp = 'rendu';
      switch($t) {
          case "présent":
	     $desin = $desPrDsdsd;
	     if ($p < 4) $radix = 'ren';
	     else $radix = 'rend';
	     break;
	  case "futur":
	     $radix = 'rendr';
	     $desin = $desFut;
	     break;
	  case "imparfait":
	     $radix = 'rend';
	     $desin = $desImpf;
	     break;
	  case "parfait":
	     $radix = 'rend';
	     $desin = $desPsI;
	     break;
     }
  }
  elseif ($v == 'agir') {
      $pp = 'agi';
      switch($t) {
          case "présent":
	     $desin = $desPrIrissant;
	     $radix = 'ag';
	     break;
	  case "futur":
	     $radix = 'agir';
	     $desin = $desFut;
	     break;
	  case "imparfait":
	     $radix = 'agiss';
	     $desin = $desImpf;
	     break;
	  case "parfait":
	     $radix = 'ag';
	     $desin = $desPsI;
	     break;
     }
  }
  elseif ($v == 'joindre') {
      $pp = 'joint';
      $radix = 'joign';
      switch($t) {
          case "présent":
	     $desin = $desPrSst;
	     if ($p < 4) $radix = 'join';
	     break;
	  case "futur":
	     $radix = 'joindr';
	     $desin = $desFut;
	     break;
	  case "imparfait":
	     $desin = $desImpf;
	     break;
	  case "parfait":
	     $desin = $desPsI;
	     break;
     }
  }
  elseif ($v == 'voir') {
      $pp = 'vu';
      switch($t) {
          case "présent":
	     $desin = $desPrSst;
	     if ($p < 4) $radix = 'voi';
	     elseif ($p < 6) $radix = 'voy';
	     else $radix = 'voi';
	     break;
	  case "futur":
	     $radix = 'verr';
	     $desin = $desFut;
	     break;
	  case "imparfait":
	     $radix = 'voy';
	     $desin = $desImpf;
	     break;
	  case "parfait":
	     $radix = 'v';
	     $desin = $desPsI;
	     break;
     }
  }
  elseif ($v == 'répondre') {
      $pp = 'répondu';
      $radix = 'répond';
      switch($t) {
          case "présent":
	     $desin = $desPrDsdsd;
	     if ($p < 4) $radix = 'répon';
	     break;
	  case "futur":
	     $radix = 'répondr';
	     $desin = $desFut;
	     break;
	  case "imparfait":
	     $desin = $desImpf;
	     break;
	  case "parfait":
	     $desin = $desPsI;
	     break;
     }
  }
  elseif ($v == 'fournir') {
      $pp = 'fourni';
      switch($t) {
          case "présent":
	     $desin = $desPrIrissant;
	     $radix = 'fourn';
	     break;
	  case "futur":
	     $radix = 'fournir';
	     $desin = $desFut;
	     break;
	  case "imparfait":
	     $radix = 'fourniss';
	     $desin = $desImpf;
	     break;
	  case "parfait":
	     $radix = 'fourn';
	     $desin = $desPsI;
	     break;
     }
  }
  elseif ($v == 'devoir') {
      $pp = 'dû';
      switch($t) {
          case "présent":
	     $desin = $desPrSst;
	     if ($p < 4) $radix = 'doi';
	     elseif ($p < 6) $radix = 'dev';
	     else $radix = 'doiv';
	     break;
	  case "futur":
	     $radix = 'devr';
	     $desin = $desFut;
	     break;
	  case "imparfait":
	     $radix = 'dev';
	     $desin = $desImpf;
	     break;
	  case "parfait":
	     $radix = 'd';
	     $desin = $desPsU;
	     break;
     }
  }
  elseif ($v == 'combattre') {
      $pp = 'combattu';
      $radix = 'combatt';
      switch($t) {
          case "présent":
	     $desin = $desPrSst;
	     if ($p < 4) $radix = 'combat';
	     break;
	  case "futur":
	     $radix = 'combattr';
	     $desin = $desFut;
	     break;
	  case "imparfait":
	     $desin = $desImpf;
	     break;
	  case "parfait":
	     $desin = $desPsI;
	     break;
     }
  }
  elseif ($v == 'atteindre') {
      $pp = 'atteint';
      $radix = 'atteign';
      switch($t) {
          case "présent":
	     $desin = $desPrSst;
	     if ($p < 4) $radix = 'attein';
	     break;
	  case "futur":
	     $radix = 'atteindr';
	     $desin = $desFut;
	     break;
	  case "imparfait":
	     $desin = $desImpf;
	     break;
	  case "parfait":
	     $desin = $desPsI;
	     break;
     }
  }
  elseif ($v == 'craindre') {
      $pp = 'craint';
      $radix = 'craign';
      switch($t) {
          case "présent":
	     $desin = $desPrSst;
	     if ($p < 4) $radix = 'crain';
	     break;
	  case "futur":
	     $radix = 'craindr';
	     $desin = $desFut;
	     break;
	  case "imparfait":
	     $desin = $desImpf;
	     break;
	  case "parfait":
	     $desin = $desPsI;
	     break;
     }
  }
  elseif ($v == 'perdre') {
      $pp = 'perdu';
      $radix = 'perd';
      switch($t) {
          case "présent":
	     $desin = $desPrDsdsd;
	     if ($p < 4) $radix = 'per';
	     break;
	  case "futur":
	     $radix = 'perdr';
	     $desin = $desFut;
	     break;
	  case "imparfait":
	     $desin = $desImpf;
	     break;
	  case "parfait":
	     $desin = $desPsI;
	     break;
     }
  }
  elseif ($v == 'courir') {
      $pp = 'couru';
      switch($t) {
          case "présent":
	     $desin = $desPrSst;
	     $radix = "cour";
	     break;
	  case "futur":
	     $radix = 'courr';
	     $desin = $desFut;
	     break;
	  case "imparfait":
	     $radix = 'cour';
	     $desin = $desImpf;
	     break;
	  case "parfait":
	     $radix = 'cour';
	     $desin = $desPsU;
	     break;
     }
  }
  if (isset($aux)) {
     if ($auxEtre && $persona > 3) 
        $pp .= 's';
     return $aux[$p-1]." $pp";
  }
  return $radix.$desin[$p-1];
}
?>
