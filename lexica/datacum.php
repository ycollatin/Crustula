<?php         
$lsens = array(
  /*O*/'prép. + abl. : avec, en compagnie de',
  /*1*/'prép. cum primis + adj. : parmi les plus..., des plus...',
  /*2*/"prép. + abl. en même temps que",
  /*3*/'prép. + abl contre après un mot suggérant combat ou inimitié',
  /*4*/'prép. + abl. : avec le secours de, avec pour résultat, avec un intérêt de, pour.',
  /*5*/'prép. avec, au moyen de',
  /*6*/"prép. +abl : pourvu de, habillé de",
  /*7*/"conj. cum primum + indicatif : dès que",
  /*8*/"conj. cum + indicatif : lorsque, quand, chaque fois que",
  /*9*/"conj. cum + subjonctif : comme, parce que, puisque (cause)",
 /*10*/'conj. cum + subjonctif : quoique, bien que, alors que (concession, opposition)',
 /*11*/"conj. cum + subjonctif imparfait ou plus-que-parfait : après que",
 /*12*/"conj. cum + subjonctif : chaque fois que ",
 /*13*/"conj. cum maxime + subjonctif : au moment même où",
 /*14*/"conj. cum + indicatif... tum : au moment où..., alors",
 /*15*/"conj. cum... tum : conj. coord. non seulement..., mais aussi",
 /*16*/"conj. cum... tum etiam : conj. coord. non seulement, mais surtout",
 /*17*/"conj. tempus cum + indicatif : le temps où...");

$data = array(
    array(0,'cum Chaeribulo incedit aequali suo.',"Il arrive avec son camarade Chéribule"),
    array(0,'Meus pater nunc cum Alcumena cubat amans animo obsequens.',
          "Maintenant mon père couche avec Alcmène, amoureux satisfaisant son désir."),
    array(1,'Profectus est una L. Albius, homo cum primis honestus.',
           'L.Albius partit en même temps, homme des plus honnêtes.'),
    array(2,'aestate cum prima luce exeunt pastum.','Elles sortent paître dès le premier rayon du jour.'),
    array(3,'Erant ei veteres inimicitiae cum duobus Rosciis Amerinis.',
           'Il avait de vieilles inimitiés avec les deux Roscius Amerinus.'),
    array(3,'Alfenus Romae cum isto gladiatore vetulo cotidie pugnabat.',
           "À Rome, Alfenus combattait chaque jour contre ce gladiateur vieillissant."),
    array(4,'hunc ipsum, Tenem pulcherrime factum abstulit magno cum gemitu civitatis.',
            "Ce Tenès lui même, remarquablement sculpté, il l'a volé, avec pour résultat "
            ."une grande plainte de cette cité."),
    array(4,'ager efficit cum octauo, bene ut agatur.',
            "Le champ a un rendement de quatre-vingts pour cent, lorsqu'il est bien travaillé."),
    array(5,'Rhodii tamen et Athenienses cum silentio auditi sunt.',
            "cependant les Rhodiens et les Athéniens furent écoutés en silence."),
    array(6,'Quis hic est homo cum collatiuo uentre atque oculis herbeis ?',
            "Qui est cet homme au ventre de percepteur et aux yeux couleur de légume ?"),
    array(6,'Deiphilus hanc graece scripsit, post id rursum denuo latine Plautus cum latranti nomine.',
            "Déiphile l'écrivit en grec, après lui, encore une fois, de nouveau en latin, Plaute au nom '
            .'qui aboie."),
    array(6,'Menaechmus cum corona exit foras.',
            "Ménechme sort, une couronne sur la tête."),
        //'Erat etiam Stesichori poetae statua senilis incurva CUM libro'
    array(7,'cum primum igitur poteris, venies.',
            "Donc, dès que tu le pourras, tu viendras."),
       // - vix (jam, nondum)... cum : à peine... que.
    array(8,'Occisus est a cena rediens; nondum lucebat cum Ameriae scitum est.',
            "Il fut tué en revenant de dîner ; Il ne faisait pas encore jour lorsque ce fut su à Ameria."),
    array(8,'cum palam eius anuli ad palmam conuerterat, a nullo uidebatur.',
            "Chaque fois qu'il avait tourné le chaton de cet anneau vers sa paume, "
            ."il n'était vu de personne"),
    array(9,'cum duos filios haberet, alterum a se non dimittebat, alterum ruri esse patiebatur.',
            "Comme il avait deux fils, il ne laissait pas l'un s'éloigner de lui, et tolérait que "
            ."l'autre fût à la campagne."),
    array(9,'Et grammaticus sudans multum ac rubens multum, cum id plerique prolixius '
            .'riderent, exsurgit',
            "Et le grammairien, tout en sueur et très rouge, comme la plupart riaient assez fort, "
            ."se leva"),
    array(9,'is cum haberet unicam filiam, fecit ut filiam bonis suis heredem institueret.',
            "Puisqu'il avait une fille unique, il fit en sorte d'instituer sa fille héritière de ses biens."),
    array(9,'Fit clamor maximus, cum id universis indignum ac nefarium videretur.',
            "Il y eut une très grande clameur, parce que tout le monde trouvait cela indigne et impie."),
    array(10,'Patrem meum, cum proscriptus non esset, iugulastis.',
            'Vous avez étranglé mon père, bien qu\'il n\'ait pas été proscrit'),
    array(10,'cum illi tamen ornarint templa deorum immortalium, hic etiam illorum monumenta atque '
           .'ornamenta sustulit.',
            "Alors que ceux-là avaient orné les temples des dieux immortels, celui-ci a volé même "
            ."leurs monuments et leurs ornements."),
    array(11,'Gyges, cum terra discessisset magnis quibusdam imbribus, descendit in illum hiatum',
            "Après que la terre se fut fendue sous l'effet de certains grands orages, Gygès descendit "
            ."dans cette ouverture."),
    array(11,'Nam Q. Lollius, cum in Siciliam esset profectus, in itinere occisus est.',
            "Car Quintus Lollius, après qu'il fut parti en Sicile, fut tué en chemin."),
//    'Quare cuius modi putamus esse illa quae negat, CUM haec tam improba sint quae fatetur ?'
    array(12,'Qui cum in convivium venisset, si quicquam caelati aspexerat, manus '
           .'abstinere, iudices, non poterat.',
            "Chaque fois qu'il allait à un dîner, s'il voyait quelque chose de ciselé, il ne pouvait, "
            ."juges, retenir sa main."),
    array(13,'haec cum maxime loqueretur, sex lictores circumsistunt valentissimi.',
            "Au moment même où il disait ces mots, six licteurs très robustes l'encerclent."),
    array(14,'nam cum pugnabant maxime, ego tum fugiebam maxime.',     
            "Car au moment où ils combattaient le plus, alors je fuyais le plus."),
    array(15,'Ego meum consilium cum iudicibus tum populo Romano probavi.',     
            "Moi j'ai fait approuver mon projet non seulement par les juges, "
            ."mais aussi par le peuple romain."),
    array(16,'Haec vidit vir prudentissimus et cum rei publicae, cum mihi, '
            .'tum etiam veritati amicissimus, L. Cotta.',
            "un homme très sage, et très ami non seulement de l'état, non seulement "
            ."de moi, mais surtout de la vérité, a vu ces choses."),
    array(17,'omnia consilia differs in id tempus cum scierimus quid actum sit.',
            "Tu diffères tous tes avis au moment où nous saurons ce qui s'est passé.")
    );
//quis hic homo est cum tunicis longis quasi puer cauponius?
?>
