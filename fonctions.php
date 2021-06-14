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

$fonctions = array (
   // 0:cas; 1:emploi; 2:latin; 3:français
   array('nominatif',
            'sujet du verbe','-terra- ipsa dea est.','la terre elle-même est une déesse.'),
   array('nominatif',
            'attribut du sujet', 'Ego nominor -leo-.','Moi, je m\'appelle le lion.'),
   array('vocatif','nomme le destinataire', 'Heus, -Pythodice-, sequere me.',
         'Hé, Pythodicus, suis-moi.'),
   array('accusatif','complément d\'objet direct du verbe (COD)',
            'uenti -terras- uerrunt.',
            'les vents balaient les terres'),
   array('accusatif','attribut du COD', 'solem quis dicere -falsum- audeat ?',
            'Qui oserait dire le soleil trompeur ?'),
   array('accusatif','sujet dans une proposition infinitive',
            'ecquam scis -filium- tibicinam meum amare ?',
            'Est-ce que tu sais que mon fils est amoureux d\'une joueuse de flûte ?'),
   array('accusatif','distance, durée, âge','-horas- tres fere dixit.',
         'Il a parlé presque trois heures.'),
   array('accusatif','après de nombreuses prépositions : ad, ante, apud, post...',
            'naues Caesar ad -terram- detrahit.',
            'César tira les vaisseaux à terre.'),
   array('génitif','Complément du nom ou du pronom, désigne l\'ensemble auquel appartient/ennent '
        .'un ou plusieurs éléments',
         'is longe omnium -amicorum- carissimus erat.',
         'Il était de loin le plus cher de tous mes amis.'),
   array('génitif','complément du nom, du pronom, de l\'adjectif ou du verbe, qui apporte une '
        .'précision',
         'nuntiatur -terrae- motus horribilis.',
         'un terrible tremblement de terre est annoncé.'),
   array('datif','donne le destinataire de l\'action','Reddenda -terrae- est terra.',
            'Il faut rendre la terre à la terre.'),
   array('datif','donne la destination de l\'action',
         'studet -eloquentiae-','Il étudie l\'éloquence.'),
   array('ablatif','exprime une origine (point de départ, cause)',
            'omnia oriuntur e -terris-.','Tout vient de la terre (des terres).'),
   array('ablatif','moyen, manière, matière, agent, qualité, accompagnement, lieu par où l\'on passe',
            'utinam ueris domum -amicis- impleam !',
            'Puissé-je emplir ma maison de vrais amis !'),
   array('ablatif','exprime le lieu, où l\'on est, la date.',
            'falsi amici sereno uitae -tempore- praesto sunt.',
            'Les faux amis sont à votre service dans le temps heureux de la vie.')
);

$alin = "<br>\n";
$lbr  = "\n";
$lescas = array('nominatif','vocatif','accusatif','génitif','datif','ablatif');

function sorsColl($c) {
    if (count($c) == 1) return $c[0];
    return $c[mt_rand(0, count($c)-1)];   
}

function enrouge($l) {
   preg_match('/^(.*)-(.*)-(.*)$/', $l, $eclats);
   return $eclats[1].'<span class="conseil">'.$eclats[2].'</span>'.$eclats[3];
}        

function lacune($l) {
   preg_match('/^(.*)-(.*)-(.*)$/', $l, $eclats);
   return $eclats[1].'<input type="text" class="questmin" name="resp">'.$eclats[3];
}        

function abslacune($l) {
   preg_match('/^(.*)-(.*)-(.*)$/', $l, $eclats);
   return $eclats[1].$eclats[3];
}   

function enlacune($l) {
   preg_match('/^(.*)-(.*)-(.*)$/', $l, $eclats);
   return $eclats[2];
}   

function exempleslg() {
   global $fonctions;
   foreach ($fonctions as $emploi)
      $retour[] = $emploi[2].' '.$emploi[3];
   shuffle($retour);
   return $retour;
}        

function exemplesl() {

}        

/**************************************
              en-tête  
**************************************/
session_start();
echo "<html>\n<head>\n";
$titre = 'FONCTIONS';
echo "<title>CRVSTVLA - $titre </title>\n";
include "css.inc";
include "meta.inc.php";
echo "</head>\n<body>";
echo '<p class="titre">'."\n$titre</p>";


/**************************************
     dépouillement de la réponse
**************************************/
if(isset($_POST['niveau']))
    $niveau = $_POST['niveau'];
if (!isset($niveau)) {
    $niveau = 1; // debog !//$niveau = n;
    $ch = str_repeat('0', count($fonctions));
} else {
    $resp = $_POST['resp']; 
    $resp = stripslashes($resp);
    $quest = $_POST['quest'];
    $quest = stripslashes($quest);
    $status = $_POST['status'];
    $ch = decbin($status);
    $ch = substr($ch, 1);

    /**********************************************
              NIVEAU I
     phrases + traduction ; trouver cas et emploi
    ***********************************************/
    if ($niveau == 1 || $niveau == 3) {
        // chercher la question, extraire la solution 
        for($isol = 0; $isol < count($fonctions); $isol++ )
            if ($fonctions[$isol][2] == $quest) {
               $sol = $fonctions[$isol][0].', '.$fonctions[$isol][1];
               break;
            }
        $recte = ($resp == $sol);
        if ($recte) $ch{$isol} = '1';
    }

    /**********************************************
             NIVEAU II
          cas et emploi ; trouver phrases + traduction
    ***********************************************/

    if ($niveau == 2) {
        for ($isol = 0; $isol < count($fonctions); $isol++ )
            if ( $fonctions[$isol][0].', '.$fonctions[$isol][1] == $quest) {
                $sol = $fonctions[$isol][2].' '.$fonctions[$isol][3];
                break;
            }
        $recte = ($resp == $sol);
        if ($recte) $ch{$isol} = '1';
    }

    /**********************************************
          NIVEAU III
          phrases sans traduction ; trouver cas et emploi
    ***********************************************/
    //if ($niveau == 3) {

    //}

    /**********************************************
          NIVEAU IV
          phrase lacunaire + traduction 
          NIVEAU V
          phrase lacunaire sans traduction
    ***********************************************/
    if ($niveau >= 4) {
        for ($isol = 0; $isol < count($fonctions); $isol++ ) {
            if ($quest == abslacune($fonctions[$isol][2])) {
                $sol = enlacune($fonctions[$isol][2]);
                break;
            }
        }
        $recte = ($resp == $sol);
        if ($recte) $ch{$isol} = '1';
    }

/**************************************
             sanction
**************************************/
    echo 'Quaestio : '. enrouge($quest) .$alin;
    echo "Solutio : $sol $alin";
    if ($recte)
        echo "<div class=\"juste\">RECTE !</div>"; 
    else
        echo "<div class=\"faux\"> Errauisti. Respondisti : $resp</div>";
}
if (isset($recte))
    include 'session.php.html';
$sus = substr_count($ch, '1');
echo  '    '. $sus . '/'. strlen($ch);


/***************************************

         AFFICHAGE DU FORMULAIRE

***************************************/

function purgef() {
    // renvoie le tableau d'index des emplois non sus.
    global $fonctions, $ch;
    for ($i = 0; $i < strlen($ch); $i++)
       if ($ch{$i} == '0') $retour[] = $i;
    return $retour;
}        

// passage de niveau
if ($sus == strlen($ch)) {
    $niveau++;
    $ch = str_repeat('0', count($fonctions));
}    

echo " ;  niveau $niveau $alin";

if ($niveau == 1) {
//phrases + traduction ; trouver cas et emploi
    $sors = sorsColl(purgef());
    $f = $fonctions[$sors];
    // 0:cas; 1:emploi; 2:latin; 3:français
    $quest = $f[2];
    $g = $f[3];
    $l = enrouge($quest);
    echo '<p class="latin">'."$l</p>$lbr";
    echo '<p class="questmin">'."$g</p>$lbr";
    echo '<form method="post">'.$lbr;
    $anciencas = 'nominatif';
    foreach ($fonctions as $emploi){
            if ($emploi[0] != $anciencas) echo $alin;
            echo '<input type="submit" name="resp" value="'.$emploi[0].', '.$emploi[1].'">';
            $anciencas = $emploi[0];
        }
    $ch = '1'.$ch;
    $status = bindec($ch);
    echo '<input type="hidden" name="quest" value="'.$quest.'">'.$lbr;
    echo '<input type="hidden" name="niveau" value="'.$niveau.'">'.$lbr;
    echo '<input type="hidden" name="status" value="'.$status.'">'.$lbr;
    echo '</form>'.$lbr;
}        

elseif ($niveau == 2) {
    $sors = sorsColl(purgef()); 
    $f = $fonctions[$sors];
    $quest = $f[0] . ', ' . $f[1];
    echo '<p class = "questmin">'."$quest</p>$lbr";
    echo '<form method="post">'.$lbr;
    $exemples = exempleslg();
    foreach ($exemples as $exemple)
       echo '<input type="submit" name="resp" value="'.$exemple.'">';//.$alin;
    $ch = '1'.$ch;
    $status = bindec($ch);
    echo '<input type="hidden" name="quest" value="'.$quest.'">'.$lbr;
    echo '<input type="hidden" name="niveau" value="'.$niveau.'">'.$lbr;
    echo '<input type="hidden" name="status" value="'.$status.'">'.$lbr;
    echo '</form>'.$lbr;
}        

elseif ($niveau == 3) {
    $sors = sorsColl(purgef());
    $f = $fonctions[$sors];
    // 0:cas; 1:emploi; 2:latin; 3:français
    $quest = $f[2];
    $l = enrouge($quest);
    echo '<p class="latin">'."$l</p>$lbr";
    echo '<form method="post">'.$lbr;
    $anciencas = 'nominatif';
    foreach ($fonctions as $emploi){
            if ($emploi[0] != $anciencas) echo $alin;
            echo '<input type="submit" name="resp" value="'.$emploi[0].', '.$emploi[1].'">';
            $anciencas = $emploi[0];
        }
    $ch = '1'.$ch;
    $status = bindec($ch);
    echo '<input type="hidden" name="quest" value="'.$quest.'">'.$lbr;
    echo '<input type="hidden" name="niveau" value="'.$niveau.'">'.$lbr;
    echo '<input type="hidden" name="status" value="'.$status.'">'.$lbr;
    echo '</form>'.$lbr;

}        

elseif ($niveau == 4) {
    $sors = sorsColl(purgef());
    $f = $fonctions[$sors];
    // 0:cas; 1:emploi; 2:latin; 3:français
    $quest = $f[2];
    $g = $f[3];
    $l = lacune($quest);
    $lquest = abslacune($quest);
    echo '<form method="post">'.$lbr;
    echo '<p class="latin">'."$l</p>$lbr";
    echo '<p class="questmin">'."$g</p>$lbr";
    echo '<input type="submit" class="questmin" value=" Respondi. ">'.$lbr;
    $ch = '1'.$ch;
    $status = bindec($ch);
    echo '<input type="hidden" name="quest" value="'.$lquest.'">'.$lbr;
    echo '<input type="hidden" name="niveau" value="'.$niveau.'">'.$lbr;
    echo '<input type="hidden" name="status" value="'.$status.'">'.$lbr;
    echo '</form>'.$lbr;
}        

elseif ($niveau >= 5) {
    $sors = sorsColl(purgef());
    $f = $fonctions[$sors];
    // 0:cas; 1:emploi; 2:latin; 3:français
    $quest = $f[2];
    $l = lacune($quest);
    $lquest = abslacune($quest);
    echo '<form method="post">'.$lbr;
    echo '<p class="latin">'."$l</p>$lbr";
    echo '<input type="submit" class="questmin" value=" Respondi. ">'.$lbr;
    $ch = '1'.$ch;
    $status = bindec($ch);
    echo '<input type="hidden" name="quest" value="'.$lquest.'">'.$lbr;
    echo '<input type="hidden" name="niveau" value="'.$niveau.'">'.$lbr;
    echo '<input type="hidden" name="status" value="'.$status.'">'.$lbr;
    echo '</form>'.$lbr;
}        
// debog
// echo $alin.$ch;
?>
<p class="redi"><a href='./'>reditus</a> <a href="gpl.html" target="gpl">Licentia GPL</a></p>
</body>
</html>
