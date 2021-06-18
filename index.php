<?php
include_once "i18n.inc.php";
?>
<!DOCTYPE html>
<html lang="lt" xmlns="http://www.w3.org/1999/xhtml" >
  <head>
    <title>CRVSTVLA</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <meta name="description" content="Crustula, exercices latins"/>
    <meta name="keywords" content="Latin, latin, exercice, exercices, exercise, exercises, Crustula, crustula"/>
    <style>
      .titre {
      font-family : sans-serif;
      font-size : 25px;
      font-weight : bold;
      text-align : center;
      border : 1px solid black;
      padding: 0.5px;
      background-color : Silver;
      }
      p.sstitre {
      font-family : sans-serif;
      font-size : 16px;
      font-weight : bold;
      text-align : center;
      border : 1px black solid;
      margin: 0px auto;
      padding: 0.5ex;
      width: 80%;
      background-color : Silver;
      }
      ol {
      margin-left: 40px;
      }
      .hor{
      margin-left: 40px;
      font-style: italic;
      }
      p.indente{
      padding-left: 4em;
      }
      div#sommaire {
      position: fixed;
      top: 50px;
      right: 10px;
      color: rgba(0,0,0,0.5);
      background: rgba(128,128,128,0.5);
      border: 1px solid black;
      padding : 0.8ex;
      border-radius: 0.8ex;
      display: inline-block;
      }
    </style>
  </head>
  <body>
    <div id="sommaire"><a href="#top"><?= _("Sommaire")?></a></div>
    <p class="titre">CRVSTVLA</p>
    <p class="hor"> ut pueris olim dant crustula blandi<br/>
    doctores, elementa velint ut discere prima ?<br/>
    Hor. Serm. I, 1, 25.</p>
    <p class="indente">
      <?= _("Je remercie Jacques Julien pour son aide amicale, et patiente.")?>
    </p>
    <p style="text-align: center">-oOo-</p>
    <p class="hor indente">
      <?= _("Cher latiniste, débutant ou maître, salut.")?>
      </p><p class="hor indente">
      <?= _("Tu trouveras ici une collection d'exercices d'apprentissage de la langue latine.")?>
      <?= _("Un lien au bas de cette page te permettra de les télécharger sur tout serveur web équipé du langage PHP.")?>
      <?= _("Reviens souvent : de nouveaux crustula sont régulièrement ajoutés, et il n'est pas rare que les autres soient modifiés.")?>
    </p>
    <p class="indente">
      <?= _("Tu peux chercher :")?>
    </p>
    <ul>
      <li><a href="#niveau">
	  <?= _("les crustula correspondant à ton niveau ;")?>
	</a>
	<a href="#debutant">
	  <?= _("débutant")?>
	</a>
	<a href="#moyen">
	  <?= _("moyen")?>
	</a>
	<a href="#avance">
	  <?= _("avancé")?>
	</a>
      </li>
      <li><a href="#morpho">
	  <?= _("les crustula qui font travailler déclinaison et conjugaison ;")?>
      </a></li>
      <li><a href="#lexique">
	  <?= _("les crustula qui font travailler le vocabulaire ;")?>
      </a></li>
      <li><a href="#syntaxe">
	  <?= _("les crustula qui font travailler la syntaxe ;")?>
      </a></li>
      <li><a href="#texte">
	  <?= _("les crustula qui accompagnent la lecture d'un texte ;")?>
      </a></li>
      <li><a href="#grasp">
	  <?= _("La méthode GRASP de Claude Pavur")?>
	</a>
      <?= _("Claude Pavur enseigne à L'Université de Saint-Louis, aux USA.")?>
      <?= _("Il a imaginé cette méthode qui fait lire la phrase par étapes successives, en la compliquant progressivement, pour retrouver finalement la phrase authentique.")?>
      </li>
      <li><a href="sommaire.html">
	  <?= _("dans la liste complète des crustula")?>
      </a></li>
    </ul>

    <ol type="I">
      <li><a id="niveau"><b>
	    <?= _("LES CRVSTVLA CORRESPONDANT À TON NIVEAU")?>
	</b></a>
	<p class="sstitre"><a id="debutant">
	    <?= _("DÉBUTANT")?>
	</a></p>
      <p class="indente">
	<?= _("La langue française est proche de la langue latine parce qu'elle lui a emprunté la plus grande partie de son dictionnaire.")?>
	<?= _("Pourtant elle est très difficile à apprendre. Pourquoi ?")?>
      </p>
      <p class="indente">
	<?= _("Parce que ce n'est pas <b>l'ordre</b> des mots qui permet de comprendre, mais <b>la fin</b> des mots.")?>
	<?= _("Le crustulum <a href='sov.php'>QVIS QVEM AMAT ?</a> te propose de petites phrases qui t'initient à ce principe.")?>
        <?= _("Évite de répondre automatiquement, et regarde bien la fin des noms.")?>
      </p>
      <p class="indente">
	<?= _("Le crustulum <a href='gal.php'>NOMINATIF ET ACCUSATIF</a> lui ressemble, mais te permet de comprendre deux cas importants : le nominatif et l'accusatif.")?>
      <?= _("Un nom sujet se met au nominatif, et un nom COD se met à l'accusatif.")?>
      </p>
      <p class="indente">
	<?= _("Un peu plus difficile : tu dois écrire la traduction, soit du latin au français, soit du français au latin : <a href='sov1.php'>SOV bis</a>")?>
      </p>
      <p class="indente">
	<?= _("Le crustulum <a href='amo.php'>AMO, PRÉSENT DE L'INDICATIF</a> te montre comment conjuguer le verbe <i>amo</i> à toutes les personnes du présent.")?>
      </p>
      <p class="indente">
	<?= _("La conjugaisons de <i>sum</i>, être, est abordée dans <a href='sum.php'>SVM, PRÉSENT DE L'INDICATIF</a>.")?>
      </p>
      <p class="indente">
	<?= _("Un nom au génitif a de fortes chances d'être complément du nom. Pour t'entrainer à la lecture du génitif, tu peux pratiquer <a href='gen.php'>CVIVS ?</a> et <a href='est-gen.php'>QVIS QVID EST CVIVS ?</a>")?>
      </p>
      <p class="indente">
	<?= _("Le datif est le cas de la personne ou de la chose à qui on destine ce qui est fait.")?>
	<?= _("Le crustulum <a href='dat.php'>QVIS CVI QVEM COMMENDAT ?</a> est une initiation au datif, et <a href='dat1.php'>DATIVVS CASVS</a> en est une application plus complète.")?>
      </p>
      <p class="indente">
	<?= _("Le crustulum pour <a href='ablatif.php'>l'ablatif</a> est un peu difficile.")?>
	<?= _("N'insiste pas si tu ne parviens pas au cinquième niveau.")?>
      </p>
      <p class="indente">
       <?= _("Deux crustula te permettront d'être parfaitement à l'aise dans le système des cas et de leurs valeurs : d'abord <a href='fonctions-fr.php'>Initiation aux cas : les valeurs </a> puis <a href='valeurk.php'>Quem casum ?</a>")?>
      </p>
      <p class="indente">
	<?= _("Maintenant que tu connais les cas et leurs valeurs, il faut apprendre les déclinaisons :")?>
	<?= _("D'abord, <a href='nag12.php'>Les deux premières déclinaisons nominatif, accusatif et génitif singuliers.</a>")?>
	<br/>
	<?= _("Puis <a href='nag12p.php'>les mêmes cas, en ajoutant le pluriel</a>.")?>
	<?= _("Il faut ensuite apprendre")?>
	<a href="voc1.php">
           <?= _("un petit vocabulaire des deux premières déclinaisons")?>
     </a>.
      </p>
      <p class="indente">
	<?= _("Tu auras alors accès à une plus grande variété de phrases :")?>
	<a href="sov2.php">
	  <?= _("Sujet, objet, verbe (+ modèles en -er)")?>
	</a>.
	<?= _("Voici un aperçu du même principe, avec la troisième déclinaison :")?>
	<a href="sov3.php">
	  <?= _("sujet, objet, verbe (+ 3e déclinaison)")?>
	</a>
	<?= _("Dans <a href='sov4.php'>sujet, objet, verbe (+ conjugaison)</a>, tu devras savoir conjuguer le présent de plusieurs verbes ;")?>
	<?= _("et dans <a href='sov5.php'>sujet, objet, verbe, génitif, imparfait</a>, il y aura des génitifs et des imparfaits.")?>
      </p>
      <p class="indente">
	<?= _("Il est temps, maintenant, d'apprendre tous les cas grâce à des phrases d'exemple :")?>
	<a href="terra.php">
	  <?= _("Première déclinaison et valeur des cas")?>
	</a>
	<?= _("et <a href='amicus.php'>Deuxième déclinaison et valeur des cas</a> <a href='gladius.php'>Gladius</a> et <a href='dux.php'>Dux</a> sont une rapide révision de cette notion.")?>
      </p>
      <p class="indente">
	<?= _("Mais tu n'as encore vu que deux déclinaisons. Il y en a cinq ! Tu dois d'abord apprendre à reconnaître facilement les <a href='modeles.php'>modèles de déclinaison</a>.")?>
	<?= _("Ensuite, il faut apprendre progressivement toutes les déclinaisons.")?>
	<?= _("C'est assez long, et il faudra pratiquer longtemps un <a href='decliner.php'>entraînement progressif à la déclinaison</a>.")?>
      </p>
      <p class="indente">
	<?= _("L'étude du verbe se fait suivant le même principe :")?>
	<?= _("Tu dois apprendre à reconnaître facilement les <a href='modelesv.php'>modèles de conjugaison</a>.")?>
	<?= _("Il faut alors conjuguer.")?>
	<?= _("Il est possible d'apprendre à la fois actif et passif au présent :")?>
	<a href="ueho.php">Veho, uehor</a>.
	<?= _("La conjugaison d'un verbe s'appuie en latin sur trois radicaux : celui du présent (ou de l'infectum), du parfait (ou du perfectu), et du supin : <a href='radicaux.php'>les trois radicaux des verbes</a>.")?>
	<?= _("Tu dois aussi apprendre à lire correctement ce que dit le dictionnaire lorsqu'il donne un verbe : <a href='primitifs.php'>les temps primitifs</a>.")?>
	<?= _("Commence par le <a href='present.php'>présent</a>.")?>
	<?= _("Le parfait utilise le radical du perfectum et des désinences particulières.")?>
	<?= _("<a href='fui.php'>Le parfait de sum</a> en est un exemple.")?>
	<?= _("Applique ce principe pour travailer les <a href='amaui.php'>présent et parfait de amo</a>.")?>
	<?= _("Tu es alors équipé pour apprendre tout <a href='ind_actif.php'>l'indicatif actif</a>, l'exercice est progressif : il faut réussir le présent pour aborder le futur, le futur pour l'imparfait, etc.")?>
</p>
	<p class="sstitre"><a id="moyen">
	    <?= _("MOYEN")?>
	</a></p>

      <p class="indente">
	<?= _("Pour des révisions des déclinaisons <a href='decl-ocius.php'>DECL-OCIVS</a> est plus approprié.")?>
      </p>
      <p class="indente">
	<?= _("Pour une connaissance plus approfondie de la valeur des cas : ")?>
	<a href='fonctions.php'>
	  <?= _("Valeur des cas et fonctions")?>
	</a>.
      </p>
      <p class="indente">
	<?= _("Comme pour toute langue, il faut non seulement acquérir du vocabulaire :")?>
      </p>
      <ul>
	<li><a href='uocesii.php'>
	    <?= _("CVIII noms de la deuxième déclinaison")?>
	</a></li>
	<li><a href='uocesiii.php'>
	    <?= _("CLXXXVI noms de la troisième déclinaison")?>
	</a></li>
	<li><a href='radicesiii.php'>
	    <?= _("radicaux des noms de la 3e déclinaison")?>
	</a></li>
	<li><a href='uocesiiib.php'>
	    <?= _("CLXXXVIII noms de la troisième déclinaison, avec génitif et genre")?>
	</a></li>
	<li><a href='uocesiiii.php'>
	    <?= _("XLII noms des quatrième et cinquième déclinaisons")?>
	</a></li>
      </ul>

	<p class="indente">
	  <?= _("... mais aussi l'utiliser : <a href='valeurcas.php'>CVI phrases à étudier</a>.")?>
	  <?= _("Les crustula ont maintenant plusieurs niveaux.")?>
	  <?= _("Au premier, il suffit de donner le cas utilisé, mais il faut ensuite décliner correctement le mot manquant.")?>
	  <?= _("Dans le dernier niveau, aucune indication n'est donnée.")?>
	  <?= _("Le mot manque, et il faut le retrouver.")?>
      </p>
      <p class="indente">
	<?= _("Le crustulum <a href='amatur.php'>QVIS QVEM AMAT ?</a> te familiarisera avec le passif.")?>
	Apprends à reconnaître Ab introduisant un complément d'agent et Ab introduisant un complément de lieu : <a href='agent.php'>Ab, le lieu et le passif</a>.
      </p>
      <p class="indente">
	<?= _("<a href='partparf.php'>Le participe parfait passif</a> est une forme très fréquente en latin.")?>
      </p>
      <p class="indente">
	Apprends à distinguer et à employer <a href='subjonctif.php'>le subjonctif</a>.
      </p>
      <p class="indente">
	<?= _("Parmi les pronoms, tu peux étudier <a href='iseaid.php'>is, ea, id</a> et <a href='relatifs.php'>qui, quae, quod</a>.")?>
      </p>

	<p class="sstitre"><a id="avance">
	    <?= _("AVANCÉ")?>
	</a></p>

      <ul style="margin-top: 1ex;">
	<li>
	  <?= _("Une révision de l'emploi de l'adjectif bonus :")?>
	  <a href='bonus.php'>
	    <?= _("Bonus (phrases longues, chercher l'accord)")?>
	  </a>.</li>
	<li><a href='cum.php'>
	    <?= _("Les emplois de CVM")?>
	</a></li>
	<li><a href='dum.php'>
	    <?= _("Syntaxe de DVM")?>
	</a></li>
	<li>
       <?= _("Dans <a href='orthographia.php'>De orthographia (Flauius Caper)</a>, un aperçu de la grammaire vue par les anciens.")?>
    </li>
      </ul>
    </li>
      <li><a id="morpho"><b>
	    <?= _("LES CRUSTULA QUI FONT TRAVAILLER DÉCLINAISON ET CONJUGAISON")?>
	</b></a>
      <ul>
	<li><a href='gal.php'>
	    <?= _("Nominatif et accusatif")?>
	</a></li>
	<li><a href='amo.php'>
	    <?= _("amo, présent de l'indicatif")?>
	</a></li>
	<li><a href='sum.php'>
	    <?= _("sum, présent de l'indicatif")?>
	</a></li>
	<li><a href='gen.php'>
	    <?= _("nominatif, génitif")?>
	</a></li>
	<li><a href='dat.php'>
	    <?= _("nominatif, accusatif, datif")?>
	</a></li>
	<li><a href='nag12.php'>
	    <?= _("déclinaison : nom. acc. gén. sing. decl. 1 et 2masc.")?>
	</a></li>
	<li><a href='nag12p.php'>
	    <?= _("déclinaison : nom. acc. gén. decl. 1 et 2masc.")?>
	</a></li>
	<li><a href='terra.php'>
	    <?= _("Première déclinaison et valeur des cas")?>
	</a></li>
	<li><a href='amicus.php'>
	    <?= _("Deuxième déclinaison et valeur des cas")?>
	</a></li>
	<li><a href='modeles.php'>
	    <?= _("modèles de déclinaison")?>
	</a></li>
	<li><a href='decliner.php'>
	    <?= _("déclinaison, entraînement progressif")?>
	</a></li>
	<li><a href='decl-ocius.php'>
	    <?= _("déclinaison, avance rapide")?>
	</a></li>
	<li><a href='radicesiii.php'>
	    <?= _("radicaux des noms de la 3e déclinaison")?>
	</a></li>
	<li><a href='modelesv.php'>
	    <?= _("modèles de conjugaison")?>
	</a></li>
	<li><a href='ueho.php'>
	    <?= _("Veho, uehor : actif et passif")?>
	</a></li>
	<li><a href='radicaux.php'>
	    <?= _("les trois radicaux des verbes")?>
	</a></li>
	<li><a href='primitifs.php'>
	    <?= _("les temps primitifs")?>
	</a></li>
	<li><a href='present.php'>
	    <?= _("le présent de l'indicatif")?>
	</a></li>
	<li><a href='ind_actif.php'>
	    <?= _("l'indicatif actif</a>, entraînement progressif")?>
	</li>
	<li><a href='subjonctif.php'>
	    <?= _("le subjonctif actif")?>
	</a></li>
	<li><a href='partparf.php'>
	    <?= _("le participe parfait passif")?>
	</a></li>
	<li><a href='fui.php'>
	    <?= _("le parfait de sum")?>
	</a></li>
	<li><a href='amaui.php'>
	    <?= _("amo, présent et parfait")?>
	</a></li>
	<li><a href='iseaid.php'>
	    is, ea, id
	</a></li>
	<li><a href='relatifs.php'>
	    qui, quae, quod
	</a></li>
	<li>
	  <?= _("<a href='casus'>CASVS</a> est un assistant qui devrait te permettre de décliner n'importe quel nom à la forme que tu cherches.")?>
	  <?= _("Il utilise son propre lexique.")?>
	</li>
      </ul>
    </li>
      <li><a id="lexique"><b>
	    <?= _("LES CRUSTULA QUI FONT TRAVAILLER LE VOCABULAIRE")?>
	</b></a>
      <ul>
	<li><a href='noms5.php'>
	    <?= _("Les noms qu'il faut connaître en 5ème")?>
	</a></li>
	<li><a href='adj5.php'>
	    <?= _("Les adjectifs qu'il faut connaître en 5ème")?>
	</a></li>
	<li><a href='verbes5.php'>
	    <?= _("Les verbes qu'il faut connaître en 5ème")?>
	</a></li>
	<li><a href='adv5.php'>
	    <?= _("Les adverbes qu'il faut connaître en 5ème")?>
	  </a><br/>&nbsp;</li>
	<li><a href='noms4.php'>
	    <?= _("Les noms qu'il faut connaître en 4ème")?>
	</a></li>
	<li><a href='adj4.php'>
	    <?= _("Les adjectifs qu'il faut connaître en 4ème")?>
	</a></li>
	<li><a href='verbes4.php'>
	    <?= _("Les verbes qu'il faut connaître en 4ème")?>
	</a></li>
	<li><a href='adv4.php'>
	    <?= _("Les adverbes qu'il faut connaître en 4ème")?>
	  </a><br/>&nbsp;</li>
	<li><a href='noms3.php'>
	    <?= _("Les noms qu'il faut connaître en 3ème")?>
	</a></li>
	<li><a href='adj3.php'>
	    <?= _("Les adjectifs qu'il faut connaître en 3ème")?>
	</a></li>
	<li><a href='verbes3.php'>
	    <?= _("Les verbes qu'il faut connaître en 3ème")?>
	</a></li>
	<li><a href='adv3.php'>
	    <?= _("Les adverbes qu'il faut connaître en 3ème")?>
	  </a><br/>&nbsp;</li>
	<li><a href='voc1.php'>
	    <?= _("Vocabulaire decl 1 et 2 masc.")?>
	</a></li>
	<li><a href='uoces.php'>
	    <?= _("LXXXXVI noms de la première déclinaison")?>
	</a></li>
	<li><a href='uocesii.php'>
	    <?= _("CVIII noms de la deuxième déclinaison")?>
	</a></li>
	<li><a href='uocesiii.php'>
	    <?= _("CLXXXVI noms de la troisième déclinaison")?>
	</a></li>
	<li><a href='radicesiii.php'>
	    <?= _("radicaux des noms de la 3e déclinaison")?>
	</a></li>
	<li><a href='uocesiiib.php'>
	    <?= _("CLXXXVIII noms de la troisième déclinaison, avec génitif et genre")?>
	</a></li>
	<li><a href='uocesiiii.php'>
	    <?= _("XLII noms des quatrième et cinquième déclinaisons")?>
	</a></li>
	<li><a href='orthographia.php'>
	    <?= _("De orthographia (Flauius Caper)")?>
	</a></li>
      </ul>
    </li>

      <li><a id="syntaxe"><b>
	    <?= _("LES CRUSTULA QUI FONT TRAVAILLER LA SYNTAXE")?>
	</b></a>
      <ul>
	<li><a href='sov.php'>
	    <?= _("Sujet, objet, verbe")?>
	</a></li>
	<li><a href='sov1.php'>
	    <?= _("Sujet, objet, verbe (plus facile)")?>
	</a></li>
	<li><a href='gal.php'>
	    <?= _("Nominatif et accusatif")?>
	</a></li>
	<li><a href='gen.php'>
	    <?= _("nominatif, génitif")?>
	</a></li>
	<li><a href='dat.php'>
	    <?= _("nominatif, accusatif, datif")?>
	</a></li>
	<li><a href='est-gen.php'>
	    <?= _("Qui est l'ami de qui ?")?>
	</a></li>
	<li><a href='sov2.php'>
	    <?= _("Sujet, objet, verbe (+ modèles en -er)")?>
	</a></li>
	<li><a href='fonctions-fr.php'>
	    <?= _("initiation aux cas : les valeurs")?>
	</a></li>
	<li><a href='valeurk.php'>
	    <?= _("quem casum ? (quel cas ?)")?>
	</a></li>
	<li><a href='terra.php'>
	    <?= _("Première déclinaison et valeur des cas")?>
	</a></li>
	<li><a href='amicus.php'>
	    <?= _("Deuxième déclinaison et valeur des cas")?>
	</a></li>
	<li><a href='fonctions.php'>
	    <?= _("Valeur des cas et fonctions")?>
	</a></li>
	<li><a href='valeurcas.php'>
	    <?= _("Valeur des cas")?>
	</a></li>
	<li><a href='ueho.php'>
	    <?= _("Veho, uehor : actif et passif")?>
	</a></li>
	<li><a href='amatur.php'>
	    <?= _("transformation actif vers passif")?>
	</a></li>
	<li><a href='agent.php'>
	    <?= _("Ab, le lieu et le passif")?>
	</a></li>
	<li><a href='sov3.php'>
	    <?= _("sujet, objet, verbe (+ 3e déclinaison)")?>
	</a></li>
	<li><a href='sov4.php'>
	    <?= _("sujet, objet, verbe, présent")?>
	</a></li>
	<li><a href='sov5.php'>
	    <?= _("sujet, objet, verbe, CDN, présent, imparfait")?>
	</a></li>
	<li><a href='iseaid.php'>
	    is, ea, id
	</a></li>
	<li><a href='relatifs.php'>
	    qui, quae, quod
	</a></li>
	<li><a href='orthographia.php'>
	    De orthographia (Flauius Caper)
	</a></li>
	<li><a href='gladius.php'>
	    <?= _("Gladius (à tous les cas)")?>
	</a></li>
	<li><a href='dux.php'>
	    <?= _("Dux (à tous les cas)")?>
	</a></li>
	<li><a href='cum.php'>
	    <?= _("Syntaxe de CVM")?>
	</a></li>
	<li><a href='dum.php'>
	    <?= _("Syntaxe de DVM")?>
	</a></li>
	<li><a href='bonus.php'>
	    <?= _("Bonus (phrases longues, chercher l'accord)")?>
	</a></li>
      </ul>
    </li>

      <li><a id="texte" href='indextxt.php'><b>
	    <?= _("LES CRUSTULA QUI ACCOMPAGNENT LA LECTURE D'UN TEXTE")?>
      </b></a></li>
      <li><a id="grasp" href='grasp'>
	  <?= _("LA MÉTHODE de CLAUDE PAVUR : GRASP")?>
	</a>
	<?= _("Claude Pavur enseigne à L'Université de Saint-Louis, aux USA.")?>
	<?= _("Il a imaginé cette méthode qui fait lire la phrase par étapes successives, en la compliquant progressivement, pour retrouver finalement la phrase authentique.")?>
      </li>
    </ol>
    <?= _("Consulter <a href='https://github.com/ycollatin/Crustula'> les codes sources</a> &copy; Yves Ouvrard, VII Kal. Oct. MMDCCLVIII AVC (27 septembre 2005) - licentiâ <a href='LICENSE'>GPL</a>.")?>
    <br/>
    <?= _("Pour installer ces Crustula, décompresser <a href='https://github.com/ycollatin/Crustula/archive/refs/heads/master.zip'>cette archive</a> dans la partie publique d'un serveur web équipé de PHP.")?>
    <br/>
    <a href='/crustula'>
      reditus
    </a>
  </body>
</html>
