<?php
/*
  Données pour un exercice sur le subjonctif.
  choisir un ou deux verbes par modèle :
  sum - adsum
  eo 
  rogo
  habeo  
  dico
  facio
  uenio 
*/
$verbes = array (
  'sum'=>'es, esse, fui : être',
  'eo'=>'is, ire, iui, itum : aller',
  'abeo'=>"abis, abire, abii, abitum : partir, s'éloigner",
  'exeo'=>"exis, exire, exii, exitum : sortir",
  'redeo'=>"redis, redire, redii, reditum : revenir",
  'rogo'=>'as, are : demander',
  'habeo'=>'es, ere, habui, habitum : avoir',
  'dico'=>'is, ere, dixi, dictum : dire, parler',
  'facio'=>'is, ere, feci, factum : faire',
  'uenio'=>'is, ire, ueni, uentum : venir, arriver');

$data = array(
  // sum, absum
    array('uereor ne molestus sim1 uobis, iudices.',
          "Je crains, juges, de vous être désagréable.",
          array('sim','sum')),
    array('te non nouimus, nescimus qui sis1.',
          "Nous ne te connaissons pas, nous ignorons qui tu es.",
          array('sis','es')),
    array('quo iure societas ciuium teneri potest, cum par non sit1 condicio ciuium ?',
          "Par quel droit la société des citoyens peut-elle être tenue, alors que la condition des "
         ."citoyens n'est pas égale ?",
         array('sit','est')),
    array('si fato omnia fiunt, nihil nos admonere potest, ut cautiores simus1.',
          "Si tout arrive par le destin, rien ne peut nous avertir d'être plus vigilants.",
         array('simus','sumus')),
    array('uos, cum praesertim tam pauci sitis1, uolui esse quam coniunctissimos',
          "J'ai voulu que vous soyez le plus unis possible, surtout au moment où vous êtes si peu nombreux.",
         array('sitis','estis')),
    array('Quare cuius modi putamus esse illa quae negat, cum haec tam improba sint1 quae fatetur ?',
          "Aussi, de quel genre pensons nous que sont les fautes qu'il nie, quand celles "
         ."qu'il avoue sont si grandes ?",
         array('sint','sunt')),
    array('Non sum0 ita hebes, ut istud dicam.',
          "Je ne suis pas stupide au point de dire cela.",
         array('sum','sim')),
    array('Non es0 dignus tu qui habeas quae tam bene facta sunt, meae dignitatis ista sunt.',
          "Tu n'es pas digne, toi, d'avoir des objets de si belle facture. Ils sont adaptés à ma dignité.",
         array('es','sis')),
    array('Non enim possumus omnia per nos agere; alius in alia est0 re magis utilis.',
          "Car nous ne pouvons tout faire nous-mêmes ; chacun est plus utile dans un domaine différent.",
         array('est','sit')),
    array('legum denique idcirco omnes serui sumus0 ut liberi esse possimus.',
          "Enfin, nous sommes tous esclaves des lois précisément pour que nous puissions être libres.",
         array('sumus','simus')),
    array('si pecuniam non habetis, pauperes estis0.',
          "Si vous n'avez pas d'argent, vous êtes pauvres.",
         array('estis','sitis')),
    array('Alii vestrum anseres sunt0 qui tantum modo clamant, nocere non possunt, alii canes qui et '
         .'latrare et mordere possunt.',
          "Certains d'entre vous sont des oies, qui crient seulement, et ne font pas de mal ; d'autres "
         ."sont des chiens, qui peuvent et aboyer et mordre.",
         array('sunt','sint')),
  // eo 
    array('sinite abeam1 si possum uiua a uobis.', //Plaut. miles
          "Permettez que je m'éloigne, vivante si je peux, de vous.",
         array('abeam','abeo')),
    array('Ego uero iam te nec hortor nec rogo ut domum redeas1.',
          "Mais moi, je ne te prie plus, ni ne te demande que tu reviennes à la maison.",
         array('redeas','redis')),
    array('aut bibat aut abeat1.',
          "Qu'il boive, ou qu'il parte.",
         array('abeat','abit')),
    array('eamus1 deambulatum.',
          "Allons nous promener.", // eatis : peu d'exemples
         array('eamus','imus')),
    array('sunt etiam animalia in aqua, quae in terram interdum exeant1.',
          "Il y a aussi des animaux aquatiques qui de temps en temps peuvent sortir sur la terre.",
         array('exeant','exeunt')),
    array('Nunc ante quam ad sententiam redeo0, de me pauca dicam.',
          "Maintenant, avant de revenir à mon avis, je parlerai un peu de moi.",
         array('redeo','redeam')),
    array('Quid ad istas ineptias abis0 ?',
          "Pourquoi pars-tu dans ces sottises ?",
         array('abis','abeas')),
    array('Romam redit0 : triumphum ab senatu postulat.',
          "Il revient à Rome, il demande le triomphe au Sénat.",
         array('redit','redeat')),
    array('Malum ego vobis dabo, ni abitis0.', // Plaut. Pers
          "Je vous ferai du mal, si vous ne partez pas.",
         array('abitis','abeatis')),
    array('nacti idoneum uentum ex portu exeunt0.',
          "Ayant trouvé un vent favorable, ils sortent du port.",
         array('exeunt','exeant')),
  // rogo 
    array('Reliquum est ut te hoc rogem1 ne temere naviges.',
          "Il me reste à te demander de ne pas naviguer inconsidérément.",
         array('rogem','rogo')),
    array('arma deponat, roget1, deprecetur.',
          "Qu'il dépose les armes, qu'il demande, qu'il implore.",
         array('roget','rogat')),
    array('Haec igitur lex in amicitia sanciatur, ut neque rogemus1 res turpes nec faciamus rogati.',
          "Qu'en amitié cette loi soit consacrée, qui veut que nous ne demandions pas de choses "
         ."honteuse, ni n'en fassions si on nous en demande.",
        array('rogemus','rogamus')),
    array('Non dicam, licet usque me rogetis1,<br> Qui sit Postumus in meo libello', // Mart
          "Je ne dirai pas, même si vous m'interrogez sans cesse,<br> Qui est Postumus dans mon livre.",
         array('rogetis','rogatis')),
          // rogent : pas trouvé.
    array('rogo0 uos quam primum mihi rescribatis.',
          "Je vous demande de me répondre le plus tôt possible.",
         array('rogo','rogem')),
    array('Ciceronem et ut rogas0 amo et ut meretur et debeo.',
          "J'aime Cicéron et comme tu me le demandes, et comme il le mérite, et comme je le dois.",
         array('rogas','roges')),
    array('adulescens, tam etsi properas, hoc te saxulum<br> '
         .'rogat0 ut se aspicias, deinde, quod scriptum est, legas.',
          "Jeune homme, même si tu es pressé, cette petite pierre<br>te demande de la regarder, "
         ."puis de lire ce qui est écrit.",
        array('rogat','roget')),
    array('ne desis, omnes te rogamus0.',
          "Nous te demandons tous de ne pas nous faire défaut.",
         array('rogamus','rogemus')),
    array('rogant0 me servi quo eam.', // Plaut.
          "Les esclaves me demandent où je vais.",
         array('rogant','rogent')),
  // habeo 
    array('tuas etiam Epiroticas exspecto litteras, ut habeam1 rationem non modo negoti '
         .'verum etiam oti tui.',
          "J'attends ta lettre d'Épire pour avoir un compte-rendu non seulement de tes activités, "
         ."mais aussi de tes loisirs.",
        array('habeam','habeo')),
    array('fortem fac animum habeas1 et magnum, quem semper habuisti.',
          "Fais en sorte d'avoir le courage fort et généreux que tu as toujours eu.",
         array('habeas','habes')),
    array('Cur enim pecuniam non habeat1 mulier ?',
          "En effet, pourquoi une femme n'aurait-elle pas de l'argent ?",
         array('habeat','habet')),
/*
Iam hoc fere scitis omnes quantam vim habeat ad coniungendas amicitias studiorum ac naturae similitudo.
Num quisnam est vestrum qui tribum non habeat? Certe nemo.
quid, si uxorem meliorem habeat, quam tu habes, utrum <tuamne an> illius malis?
*/
    array('ego contra deos precor, ne umquam huius modi civem habeamus1.', // Rut. Lup.
          "Moi, je prie au contraire les dieux pour que nous n'ayons jamais "
         ."un concitoyen de cette espèce.",
        array('habeamus','habemus')),
    array('numerate saltem quot ipsi sitis, quot aduersarios habeatis1.',
          "Comptez au moins combien vous êtes, combien d'adversaires vous avez.", // lv
         array('habeatis','habetis')),
    array('Arbores raris interuallis serito, ut, cum creuerint, spatium habeant1, quo ramos extendant.',
          // Columelle
          "Plante les arbres à de grands intervalles, pour que lorsqu'ils croîtront, ils aient "
         ."de l'espace pour étendre leurs rameaux.",
        array('habeant','habent')),
    array('Vellem id quidem, sed habeo0 paulum, quod requiram.',
          "Je le voudrais bien, mais j'ai peu de choses à demander.",
         array('habeo','habeam')),
    array('si hortum in bibliotheca habes0, deerit nihil.',
          "Si tu as un jardin dans ta bibliothèque, rien ne manquera.",
         array('habes','habeas')),
    array('Terentia magnos articulorum dolores habet0.',
          "Terentia a de grandes douleurs d'articulations.",
         array('habet','habeat')),
    array('pro urbis vero salute cur non omnibus facultatibus quas habemus0 utamur ?',
          "Mais pour le salut de la ville, pourquoi n'utiliserions-nous pas toutes les possibilités "
         ."que nous avons ?",
        array('habemus','habeamus')),
    array('habetis0 ducem memorem vestri, oblitum sui, quae non semper facultas datur.',
          "Vous avez un guide qui ne vous oublie pas, qui ne pense pas à soi ; "
         ."occasion qui n'est pas toujours donnée.",
        array('habetis','habeatis')),
    array('omnes tantam habent0 similitudinem inter se ut in eorum praenominibus errem.',
          "Ils ont tous une telle ressemblance entre eux que je confonds leurs prénoms.",
        array('habent','habeant')),
  // dico 
    array('neque quo modo dicam1 neque quo modo taceam reperire possum.',
          "Je ne puis trouver ni comment parler, ni comment me taire.",
         array('dicam','dico')),
    array('uerba tu fingas et ea dicas1, quae non sentias ?',
          "Formerais-tu, toi, des paroles avec lesquelles tu ne serais pas d'accord, et les dirais-tu ?",
         array('dicas','dicis')),
    array('dicat1 quos agros empturus sit ; ostendat et quid et quibus daturus sit.',
          "Qu'il dise quels terrains il achètera ; qu'il indique ce qu'il donnera, et à qui.",
         array('dicat','dicit')),
    array('Et ne bis aut saepius idem dicamus1, cauendum est.',
          "Et il nous faut veiller à ne pas dire deux fois ou plus la même chose.",
         array('dicamus','dicimus')),
    array('quomodo istum disertum dicatis1 nescio : tria verba non potest iungere.', // Sen.
          "Je ne vois pas comment vous pouvez dire qu'il parle bien : il ne sait pas aligner trois mots.",
         array('dicatis','dicitis')),
    array('At etiam sunt qui dicant1, Quirites, a me eiectum esse Catilinam.',
          "Mais il y a même des gens pour dire, Quirites, que Catilina a été chassé par moi.",
         array('dicant','dicunt')),
    array('Magna sunt ea quae dico0, mihi crede ; noli haec contemnere.',
          "Ce que je dis est important, crois-moi ; ne le néglige pas.",
         array('dico','dicam')),
    array('Est, inquit Catulus, ut dicis0.',
          "C'est, dit Catulus, comme tu le dis.",
         array('dicis','dicas')),
    array('cum igitur "nosce te" dicit0, hoc dicit: "nosce animum tuum."',
          "Donc, lorsqu'il dit : \"connais-toi toi-même\", il dit cela : \"Connais ton coeur\".",
         array('dicit','dicat')),
    array('Hostis enim apud maiores nostros is dicebatur, quem nunc peregrinum dicimus0.',
          "Du temps de nos ancêtres, on appelait 'hostis' (ennemi) celui que maintenant nous appelons "
         ."'peregrinus' (étranger).",
        array('dicimus','dicamus')),
    array('At iste Andro spoliatus bonis, ut dicitis0, ad dicendum testimonium non venit.',
          "Mais cet Andro, spolié de ses biens, comme vous dites, n'est pas venu donner son témoignage.",
         array('dicitis','dicatis')),
    array('Homerum Colophonii civem esse dicunt0 suum.',
          "Les habitants de Colophon disent qu'Homère est leur concitoyen.",
         array('dicunt','dicant')),
  // facio 
    array('non enim nescis quanti te faciam1.',
          "Car tu n'ignores pas combien je t'estime.",
         array('faciam','facio')),
    array('non vereor ne quid timide, ne quid stulte facias1 si ea defendes quae ipse recta esse senties.',
          "Je ne crains pas que tu fasses quelque chose de craintif, de sot, si tu défends des choses "
         ."que toi-même ressens comme justes.",
        array('facias','facis')),
    array('si Phalarim, crudelem tyrannum et immanem, vir bonus, ne ipse frigore conficiatur, '
         .'vestitu spoliare possit, nonne faciat1 ?',
          "Si un homme bon, pour ne pas mourir lui-même de froid, pouvait dépouiller de ses vêtements "
         ."Phalaris, tyran cruel et inhumain, ne le ferait-il pas ?",
        array('faciat','facit')),
    array('Haec igitur lex in amicitia sanciatur, ut neque rogemus res turpes nec faciamus1 rogati.',
          "Qu'en amitié cette loi soit consacrée, qui veut que nous ne demandions pas de choses "
         ."honteuse, ni n'en fassions si on nous en demande.",
        array('faciamus','facimus')),
    array('Moneo ne faciatis1.',
          "Je vous conseille de ne pas le faire",
         array('faciatis','facitis')),
    array('Dalmatis di male faciant1 qui tibi molesti sunt !',
          "Que les dieux fassent du mal aux Dalmates, qui te sont désagréables !",
         array('faciant','faciunt')),
    array('Verum ego quod invitus ac necessario facio0 neque diu neque diligenter facere possum.',
          "Mais moi, ce que je fais à contre-coeur et sous la contrainte, je ne peux le faire ni "
         ."longtemps ni soigneusement.",
        array('facio','faciam')),
    array('puerum Ciceronem curabis et amabis, ut facis0.',
          "Tu t'occuperas et tu aimeras le petit Cicéron, comme tu le fais.",
         array('facis','facias')),
    array('testamento facit0 heredem quem habebat e Caesennia filium',
          "Par testament il désigne comme son héritier le fils qu'il avait de Caesennia.",
         array('facit','faciat')),
    array('Quam multa enim, quae nostra causa numquam faceremus, facimus0 causa amicorum !',
          "Combien de choses faisons-nous pour nous amis, que nous ne ferions pas pour nous-mêmes !" ,
         array('facimus','faciamus')),
          //même ?
    array('bene facitis0, cum venitis : sed rectius fecissetis, si ad me domum recta abissetis.',
          "Vous faites bien de venir, mais vous auriez mieux fait d'aller me voir directement chez moi.",
         array('facitis','faciatis')),
    array('Quod consuetudine patres faciunt0, id quasi novum reprehendis.',
          "Ce que les sénateurs font par habitude, tu le critiques comme si c'était nouveau.",
         array('faciunt','faciant')),
  // uenio 
    array('tria sunt autem, maneamne Arpini an propius accedam an ueniam1 Romam.',
          "Or il y a trois possibilités : que je reste à Arpinum, que je me rapproche de Rome, ou "
         ."que j'y vienne.",
        array('ueniam','uenio')),
    array('Te iusta causa impediri quo minus ad nos uenias1 uideo.',
          "Je vois que tu es empêché par une bonne raison de venir à nous.",
        array('uenias','uenis')),
    array('et quo facilius consilium dare possis, quid in utramque partem mihi '
         .'in mentem ueniat1 explicabo breui.',
          "Et pour que tu puisses plus facilement donner ton avis, je t'exposerai brièvement "
         ."ce qu'il me vient à l'esprit pour l'une et l'autre solution.",
        array('ueniat','uenit')),
    array('Sed nimis multa de nugis: ad maiora ueniamus1.',
          "Mais nous avons trop parlé de bêtises. Venons-en à des choses plus sérieuses.",
         array('ueniamus','uenimus')),
    array('uos hortor ut Brundisium ueniatis1 quam primum.',
          "Je vous exhorte à venir au plus vite à Brindes.",
         array('ueniatis','uenitis')),
    array('Sed scire ex te peruelim quam ob rem qui ex municipiis ueniant1 peregrini tibi esse uideantur.',
          "Mais je voudrais bien savoir de toi pour quelle raison ceux qui viennent des municipes "
         ."te paraissent être des étrangers.",
        array('ueniant','ueniunt')),
    array('adsum amicis, uenio0 in senatum frequens.',
          "Je soutiens mes amis, je viens souvent au sénat.",
         array('uenio','ueniam')),
    array('quid autem illius interest, quoniam in senatum non uenis0, ubi sis ?',
          "Que lui importe, alors, de savoir où tu es, puisque tu ne viens pas au sénat ?",
         array('uenis','uenias')),
    array('Venit0 praetor; frumentum, inquit, me abs te emere oportet.',
          "Le préteur arrive ; 'Il faut, dit-il, que je t'achète du blé'.",
         array('uenit','ueniat')),
    array('bene facitis, cum uenitis0 : sed rectius fecissetis, si ad me domum recta abissetis.',
          "Vous faites bien de venir, mais vous auriez mieux fait d'aller me voir directement chez moi.",
         array('uenitis','ueniatis')),
    array('ueniunt0 in mentem mihi permulta, vobis plura, certo scio.',
          "De très nombreuses pensées me viennent à l'esprit, de plus nombreuses encore vous viennent "
         ."au vôtre, je le sais avec certitude.",
        array('ueniunt','ueniant')),
);
