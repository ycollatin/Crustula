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
$alin = "<br>\n";

$exempla = array(
   // bonus
   array("Vicinis bonus esto.",
         "Sois bon pour tes voisins."),
   array("Orator est, Marce fili, uir bonus, dicendi peritus.",
         "Un orateur, Marcus, mon fils, est un homme bon, habile Ã  parler."),
   array("Bonus vates poteras esse, nam quae sunt futura dicis.",
         "Tu aurais pu Ãªtre un bon devin, car tu dis l'avenir."),
   array("Vir bonus mihi videtur esse.",
         "Il m'a l'air d'Ãªtre un homme bon."),
// bone
   array("Lucem redde tuae, dux bone, patriae.",
         "Rends la lumiÃ¨re, bon chef, Ã  notre patrie."),
   array("Bone et optime magister vale.",
         "Adieu, Bon et excellent maÃ®tre."),
   array("Bone uir, salue.",
         "Salut, homme bon."),
// bonum
   array("Bonum Ã¡nimum habe.",
         "Aie bon courage."),
   array("Filium bonum patri esse oportet.",
         "Il faut que le fils soit bon pour son pÃ¨re."),
   array("Solum bonum est quod honestum est.",
         "N'est bon que ce qui est honnÃªte."),
   array("In cognitione et scientia summum bonum ponit.",
         "Il place le bien suprÃªme dans l'Ã©tude et le savoir."),
// boni
   array("DÃ­ boni! quid hoc ?",
         "Bons dieux, qu'est-ce ?"),
   array("Postea indito mellis boni p. IIIIS:",
         "Ajoute ensuite quatre livres de bon miel."),
   array("In foro infimo boni homines atque dites ambulant.",
         "Au bas du forum vont les hommes bons et riches."),
   array("Gaudeo edepol, si quid propter me tibi evenit boni.",
         "Je suis heureux, parbleu, si quelque chose de bon t'est arrivÃ© grÃ¢ce Ã  moi."),
// bono
   array("Nonnumquam male fecimus sed bono animo.",
         "Nous avons quelquefois mal fait, mais avec une bonne intention."),
   array("tabulas bene pictas conlocare in bono lumine.",
         "placer des tableaux bien peints dans une bonne lumiÃ¨re."),
   array("Dempta aeternitate nihilo beatior Iuppiter quam 
          Epicurus; uterque enim summo bono fruitur, id est voluptate.",
         "Mise Ã  part l'Ã©ternitÃ©, Jupiter n'est aucunement plus heureux
	 qu'Ãpicure, car tous deux jouissent du bien suprÃªme, c'est Ã  dire
	 le plaisir."),
   array("Bono animo es.",
         "Sois d'une bonne confiance (= Aie confiance)."),
// bonos
   array("Trebonius viros bonos et honestos compluris fecit heredes.",
         "Trebonius fit ses lÃ©gataires de trÃ¨s nombreux hommes bons et 
	  honnÃªtes."),
   array("Bonos se viros haberi volunt.",
         "Ils veulent Ãªtre considÃ©rÃ©s comme des hommes bons."),
   array("Mirum in modum omnis (=omnes) a se bonos alienavit.",
         "Il s'est aliÃ©nÃ© tous les hommes bons d'une maniÃ¨re Ã©tonnnante."),
   array("Bonos inimicos habet, improbos ipsos non amicos.",
         "Il considÃ¨re les bons comme ses ennemis, et pas mÃªme les mÃ©chants comme ses amis."),
// bonorum
   array("Haec bonorum eius sunt reliquiae.",
         "Ce sont les restes de ses biens."),
   array("Est bonorum et fortium civium intercludere omnis seditionum vias.",
         "C'est le propre des citoyens bons et courageux de barrer 
	  la route Ã  toutes les sÃ©ditions."),
   array("Oratorum bonorum duo genera sunt.",
         "Il y a deux genres de bons orateurs."),
   array("Ne liceat mulieri plus quam dimidiam partem bonorum suorum relinquere.",
         "Qu'il ne soit pas permis Ã  une femme de lÃ©guer plus que la moitiÃ© de ses biens."),
// bonis
   array("Atque meÃ­s bonis omnibus Ã©go te herem faciam.",
         "Et je te ferai hÃ©ritier de tous mes biens."),
   array("Mali sunt homines, qui bonis dicunt male.",
         "Mauvais sont les hommes qui parlent mal aux hommes bons."),
   array("At iste Andro spoliatus bonis, ut dicitis, ad dicendum testimonium non venit.",
         "Mais cet Andro, spoliÃ© de ses biens, comme vous dites, n'est pas venu pour donner son tÃ©moignage."),
   array("Ego malis sententiis vinci non possum, bonis forsitan possim et libenter.",
         "Moi, je ne peux Ãªtre vaincu par de mauvais raisonnements ; par de bons, peut-Ãªtre, et volontiers."),
// bona
   array("Venus multipotens, bona multa mihi dedisti.",
         "Venus toute puissante, tu m'as donnÃ© beaucoup de biens."),
   array("Dic bona fide : tu id aurum non surripuisti ?",
         "Parle de bonne foi : n'est-ce pas toi qui a volÃ© cet or ?"),
   array("Bona civium Romanorum diripuit.",
         "Il a pillÃ© les biens des citoyens romains."),
   array("Pontificibus bona causa visa est : adprobaverunt.",
         "La cause parut bonne aux Pontifes : ils l'approuvÃ¨rent."),
// bonam
   array("Per aestatem boues aquam bonam et liquidam bibant semper curato.",
         "Aie toujours soin que l'Ã©tÃ© les boeufs boivent de l'eau bonne et limpide."),
   array("Cenabis bene, mi Fabulle, si tecum attuleris bonam atque magnam cenam.",
         "Tu dÃ®neras bien, mon cher Fabullus, si tu apportes avec toi un dÃ®ner bon et abondant."),
   array("Divitias alii praeponunt, bonam alii valitudinem.",
         "Certains mettent en premier les richesses, d'autres la bonne santÃ©."),
   array("Si legumina celeriter percocta fuerint, indicabunt aquam esse bonam et salubrem.",
         "Si les lÃ©gumes sont rapidement cuits, ils indiqueront que l'eau est bonne et saine."),
// bonae
   array("Multae et bonae et firmae sunt legiones Lepidi et Asini.",
         "Les lÃ©gions de Lepidus et d'Asinus sont nombreuses, bonnes et solides."),
   array("Illi pariter laeti ac spei bonae pleni esse.",
         "Eux sont Ã©galement joyeux et pleins de bon espoir."),
   array("Tam bonae memoriae sum, ut frequenter nomen meum obliviscar.",
         "J'ai une si bonne mÃ©moire que souvent j'oublie mon nom."),
   array("O bonae conscientiae incauta simplicitas !",
         "Ã insouciante naÃ¯vetÃ© de la bonne conscience !"),
// bonas
   array("Res bonas verbis electis dictas quis non legat ?",
         "Qui ne voudrait lire des choses bonnes, dites avec des mots choisis ?"),
   array("Defaecatum uinum in amphoras bonas adicito.",
         "Tu verseras du vin clarifiÃ© dans de bonnes amphores."),
   array("Disce bonas artes, moneo, Romana iuventus.",
         "Apprends la vertu (les bons arts), jeunesse romaine, je t'y exhorte."),
   array("Scit divitias bonas non esse.",
         "Il sait que les richesses ne sont pas bonnes."),
// bonarum
   array("Prudentia est rerum bonarum et malarum neutrarumque scientia.",
         "La sagesse est la science des choses bonnes, mauvaises et ni bonnes ni mauvaises."),
   array("Rerum autem bonarum et malarum tria sunt genera.",
         "Il y a trois genres de bonnes et de mauvaises choses."),
   array("Bonarum rerum consuetudo pessima est.",
         "La pire des choses est de s'habituer aux bonnes choses.")
);	 

function sorsColl($c) {
    if (count($c) == 1) return $c[0];
    $red = $c[array_rand($c)]; 
    return $red;
}

$q = sorsColl($exempla);
$gallice = $q[1];
$latine = $q[0];
$expr = "/\b([Bb]on(a(rum|[ems])?|e|is?|o(s|rum)?|u[sm]))/";
$latine = preg_replace($expr, '<input class="question" type="text" name="resp">', $latine);

function sol($sent) {
    global $exempla, $expr, $linea;
    foreach ($exempla as $ex) {
        $g = $ex[1];
	if ($g == $sent) {
           $linea = $ex[0];
	   preg_match($expr, $linea, $partes);
	   return strtolower($partes[1]);
	}
    }
    return "Nullam inueni.";
}
session_start();
if (isset($_POST['resp'])) {
    $resp = $_POST['resp'];
    $resp = strtolower($resp); 
    $priorsent = $_POST['priorsent']; 
    $priorsent = stripslashes($priorsent);
    $recte = ($resp == sol($priorsent));
}
?>
<html>
<head>
<title>CRVSTVLA - Bonus</title>
<?php 
   include "css.inc";
   include "meta.inc.php";
?>
<body>
<p class="titre">
BONVS
</p>
<?php
if (!empty($priorsent)){
   echo "prior sententia : $priorsent$alin$linea$alin";
   if ($recte)
	   echo "<div class=\"juste\">RECTE !</div>"; 
   else 
	   echo "<div class=\"faux\"> Errauisti. Respondisti $resp";
   include "session.php.html";
} else {
   $_SESSION['prius'] = 0;
   $_SESSION['consec'] = 0;
}

?>
</p>
<p class="question">
   <?php 
   echo $gallice;
   ?> 
</p>
<form method="post">
<p class="question">
<?php
echo $latine;
?>
&nbsp;<input type="submit" value="Num recte dixi ?">
<input type="hidden" name="priorsent" value="<?php echo $gallice; ?>">
</p>
</form>
<p class="redi"><a href='./'>reditus</a> <a href="gpl.html" target="gpl">Licentia GPL</a></p>
</body>
</html>
</body>
