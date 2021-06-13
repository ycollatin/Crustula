<?php
$bini = array(
// qui
   array("Quae gerantur, accipies ex Pollione, -qui|sujet de interfuit|nom. masc. sing- omnibus negotiis non "
       . "interfuit solum, sed praefuit.",
          "Tu apprendras tout ce qui est fait de Pollion, qui non seulement a participé à "
         ."toutes les opérations, mais encore les a dirigées."),
   array("-qui|sujet de uoluerunt|nom.masc.pl.- me homines quod saluum esse uoluerunt, est mihi gratissimum;",
         "Il m'est très réconfortant (de savoir) que ces hommes ont voulu que je sois sain et sauf."),
   array("-qui|sujet de ueniunt|nom. masc. pl.- istinc ueniunt, partim te superbum esse dicunt, "
        ."partim contumeliosum.",
         "Ceux qui viennent de par chez toi te disent tantôt orgueilleux, tantôt insultant."),
   array("Ciuem mehercule non puto esse, -qui|sujet de possit|nom. masc. sing.- temporibus "
        ."his ridere possit.",
         "Je ne considère pas, ma foi, comme un citoyen celui qui est capable de rire "
        ."par les temps qui courent."),
   array("Suscipe paullisper meas partes et eum te esse finge, -qui|sujet de sum|nom.masc.sing.- sum ego.",
         "Mets-toi un peu à ma place, et imagine que tu es celui que je suis."),
   array("Recordor enim desperationes eorum -qui|sujet de erant|nom.masc.pl.|- senes erant adulescente me.",
         "Je me souviens, en effet, du désespoir de ceux qui étaient des vieillards "
         ."quand j'étais un jeune homme."),
   array("Ego C. Pomptinum, legatum meum, Brundisii exspectabam eumque ante Kalendas Iunias "
        ."Brundisium uenturum arbitrabar; -qui|sujet de uenerit|nom.masc.pl.- cum uenerit, quae primum "
        ."nauigandi nobis facultas data erit, utemur.",
         "Moi, J'attendais Caius Pomptinum, mon légat, à Brindes, et je pensais qu'il arriverait"
         ." avant le premier Juin. Quand il sera arrivé, dès que j'aurai une occasion de "
         ."prendre la mer, je la saisirai."),

// quem
   array("ut enim Aristarchus Homeri uersum negat, -quem|COD de probat|acc.masc.sing.- non probat, sic tu ?",
         "Alors tu es comme Aristarque, qui nie que le vers qu'il n'approuve pas soit d'Homère ?"),
   array("Nullus dolor est, -quem|COD de minuat|acc.masc.sing.- non longinquitas temporis minuat ac molliat.",
         "Il n'est pas de douleur que le temps qui passe ne diminue et n'allège."),
   array("Quod ad librum attinet, -quem|COD de dabit|acc.m.s.- tibi filius dabit, peto a te, "
        ."ne exeat, aut ita corrigas, ne mihi noceat.", 
        "En ce qui concerne le livre que mon fils te donnera, je te demande de ne pas "
        . "le rendre public, ou de le corriger en sorte qu'il ne me cause pas de tort."),
   array("Tu fac habeas fortem animum, -quem|COD de habuisti|acc. m. s.- semper habuisti.",
         "Quant à toi, veille à garder le caractère courageux que tu as toujours eu."),
   array("spem maximam habeo in Balbo, ad -quem|c. prépositionnel de scribo|acc.m.s.- de te "
        ."diligentissime et saepissime scribo.",
         "J'ai très grand espoir en Balbus, à qui j'écris très consciencieusement et très ."
         ."souvent pour lui parler de toi."),
   array("Sed tamen, si -quem|déterminant de sermonem|acc.m.s.- cum eo sermonem habueris, scribes ad me.",
         "Mais cependant, si tu as quelque conversation avec lui, tu me l'écriras."),
   array("Quis erat, qui putaret ad eum amorem, -quem|COD de habeam|acc.m.s.- erga te habebam, "
        ."posse aliquid accedere ?",
         "Qui pouvait penser que quelque chose pouvait approcher l'amitié que j'avais pour toi ?"),
//cuius
   array("non possum eum non diligere, -cuius|CDN beneficio|gén.m.s.- beneficio id consecutus sum.",
         "Je ne peux pas ne pas aimer celui grâce à qui j'ai obtenu cela."),
   array("Venit paratus Seruilius, Ioui ipsi iniquus, -cuius|CDN templo|gén.m.s.- in templo res agebatur.",
         "Servilius est venu prêt, injuste envers Jupiter lui-même, "
         ."dans le temple duquel l'affaire était menée."),
   array("petiuit a me, ut ad te quam accuratissime scriberem de re C. Albinii senatoris, "
        ."-cuius|CDN filia|gén.m.s.- ex filia natus est L. Sestius, optimus adolescens, filius P. Sestii.",
         "Il m'a demandé de t'écrire le plus exactement possible au sujet de la situation "
         ."où se trouve le sénateur Caius Albinius, dont la fille est la mère de Lucius Sestius, "
         ."excellent jeune homme, fils de Paulus Sestius."),
   array("pudori tamen malui famaeque cedere quam salutis meae rationem ducere. "
        ."-cuius|déterminant de facti|gén.n.s.- me mei facti paenituit",
         "J'ai pourtant donné la préférence à mon honneur et ma réputation plutôt que de tenir "
         ."compte de mon salut. Je me suis repenti de ce choix."),
// cui
   array("ad me litteras is miserit, quibus, etiamsi tibi, -cui|tour datif+esse|dat.m.sing- sum amicissimus,"
        ." hostis essem, placarer tamen.",
         "Il m'a envoyé une lettre par laquelle, même si j'étais ton ennemi, moi qui suis ton "
         ."meilleur ami, je serais quand même apaisé."),
   array("ego habeo, -cui|COS de debeam|dat.m.s.- plus quam tibi debeam, neminem.",
         "Pour ma part, il n'y a personne à qui je doive plus qu'à toi."),
   array("-cui|COS de dixi|dat.m.s.- tamen dixi, cum me aliquoties inuitaret: oro te, quis tu es ?",
         "Je lui ai tout de même dit, un jour qu'il m'invitait : \"Dis-moi, je t'en prie, qui es-tu ?"),
   array("Omnino liberti mei uideo esse culpam, -cui|COD de mandaram|dat.m.s- plane res certas mandaram.",
         "Je vois que c'est entièrement de la faute de mon affranchi, à qui j'avais donné des ordres "
         ."parfaitement clairs."),
   array("ego eam sententiam dixi, -cui|COI de sunt assensi|dat.f.s- sunt assensi omnes ad unum.",
         "Moi, j'ai donné l'avis avec lequel tous, jusqu'au dernier, ont été d'accord."),
   array("fauebam et rei publicae, -cui|COI de faui|dat.f.s- semper faui, et dignitati ac gloriae tuae.",
         "J'étais partisan et de l'état, dont j'ai toujours été partisan, "
         ."et de ta dignité et de ta gloire."),
   array("secuti sumus classem Dolabellae, -cui|COI de praeerat|dat.f.s- L. Figulus praeerat.",
         "Nous avons suivi la flotte de Dollabella, que commandait Lucius Figulus."),
// quo
   array("Ego certe rei publicae non deero et, quidquid acciderit, a -quo|C.prép. de absit|abl.n.s.- mea "
        ."culpa absit, animo forti feram.",
         "Je ne ferai certes pas défaut à l'état et, quoi qu'il advienne, je supporterai "
         . "avec une fermeté courageuse tout ce qui arrivera et ne sera pas de ma faute."),
   array("fuit in Cilicia mecum tribunus militum, -quo|dét. de munere|abl.n.s- in munere ita "
        ."se tractauit, ut accepisse ab eo beneficium uiderer, non dedisse;",
         "Il a été avec moi en Cilicie, tribun des soldats, charge dont il s'est si bien acquité "
         ."qu'il semblait non pas que je lui eusse rendu un service, mais qu'il me l'eût rendu."),
   array("Ille in morbum continuo incidit, ex -quo|compl.prépos. de conualuit|abl.m.s.- non conualuit.",
         "Il contracta aussitôt une maladie dont il ne se remit pas."),
   array("-quo|dét. de nuntio|abl.n.s- nuntio allato, cum essent nonnulli, qui ei regi "
        ."minorem fidem habendam putarent, statui exspectandum esse, si quid certius afferretur.",
         "À cette nouvelle, comme quelques uns pensaient qu'on devait accorder peu de confiance "
         ."à ce roi, j'ai décidé qu'il fallait attendre que quelque chose de plus sûr soit annoncé."),
   array("legati Parthos in Syriam transisse nuntiauerunt : -quo|abl abs avec audito|abl.n.s.- audito "
        ."uehementer sum commotus.",
         "Les envoyés annoncèrent que les Parthes étaient passés en Syrie : à cette nouvelle, je "
         ."fus gravement ébranlé."),
   array("Adhuc neminem uideram, qui te postea uidisset quam M. Volusius, "
        ."a -quo|compl. prép. de accepi|abl.m.s.- tuas "
        ."litteras accepi.",
         "Je n'avais vu jusqu'alors personne qui t'eût vu après Marcus Volusius, par qui j'ai "
         ."reçu ta lettre."),
   array("Ego ad te Aegyptam misi, quod nec inhumanus est et te uisus est mihi diligere, "
         ."ut is tecum esset, et cum eo cocum, -quo|Compl. de uterere (utor)|abl.m.s.- uterere. Vale.",
         "Je t'envoie Aegypta, parce qu'il n'est pas inhumain et qu'il m'a paru t'apprécier, lorsqu'il "
         ."était avec toi, et avec lui le cuisinier que tu utilisais. Adieu."),
// -quos||-
   array("res agitur per eosdem creditores, per -quos|compl.prép.de aderas|acc.m.p.-, cum ".
         "tu aderas, agebatur.",
         "La chose se fait par les mêmes créanciers qu'elle se faisait lorsque tu étais présent."),
   array("scripsi igitur Aristotelio more, quemadmodum quidem uolui, tres libros in disputatione "
        ."ac dialogo de oratore, -quos|COD de arbitror ou sujet de fore|acc.m.p.- arbitror "
        ."Lentulo tuo fore non inutiles.",
         "J'ai donc écrit, à la manière d'Aristote, du moins l'ai-je voulu, trois livres de discussion"
         ."et de dialogue, le \"de oratore\", que je ne pense pense pas devoir être inutiles à ton "
         ."ami Lentulus"),
   array("Nostri porro, -quos|COD de nosti|acc.m.p.- tu bene nosti, ad extremum "
        ."certamen rem deducere non audent.",
         "Les nôtres, que tu connais bien, n'osent porter plus loin l'affaire jusqu'au "
         ."combat décisif."),
   array("Itaque pridie Nonas Iunias omnes copias Isaram traieci pontesque, "
        ."-quos|COD de feceram|acc.m.p.- feceram, interrupi.",
         "C'est pourquoi, le 4 juin, j'ai fait passer l'Isère à toutes les troupes, et j'ai coupé "
         ."les ponts que j'avais construits."),
   array("nondum legati redierant, -quos|COD de miserat|acc.m.p.- senatus non ad pacem deprecandam, "
         ."sed ad denuntiandum bellum miserat",
         "Les légats que le sénat avait envoyés non pour implorer la paix, mais pour "
         ."déclarer la guerre, n'étaient pas encore revenus."),
// quorum
   array("hoc idem omnes, qui te diligunt, sentiunt, -quorum|CDN multitudo|gén.m.p.- est "
        ."magna pro tuis maximis clarissimisque uirtutibus multitudo.",
         "Tous ceux qui t'aiment pensent pensent aussi cela, et leur nombre est grand, "
         ."en proportion de tes si grandes et si illustres qualités."),
   array("Peto a te ut ipsos, -quorum|CDN nomina|gén.m.p.- nomina scripsi, quam honorificentissime "
        ."quam liberalissime tractes.",
         "Je te demande de traiter ceux-là même dont j'ai écrit les noms, avec tous les "
         ."honneurs et les libéralités possibles."),
// quibus
   array("Periucundae mihi fuerunt litterae tuae, -quibus|C moyen de intellexi|abl.f.p.- "
        ."intellexi te perspicere meam in te pietatem.",
         "Ta lettre m'a été fort agréable, par laquelle j'ai compris que tu distingues"
       . "mon dévouement envers toi."),
   array("totus est nunc ab iis, a -quibus|C agent de tuendus fuerat|abl.m.p.- tuendus fuerat, derelictus",
         "Il est maintenant tout entier abandonné par ceux par qui il aurait dû être protégé."),
   array("A. d. III. Kal. Maias cum essem in Cumano, accepi tuas litteras, -quibus|abl. abs.|abl.f.p.- "
        ."lectis cognoui non satis prudenter fecisse Philotimum",
         "J'étais le 28 avril dans la région de Cumes lorsque j'ai reçu ta lettre. Je l'ai lue"
         ."et j'ai appris que Philotimus n'avait pas été assez prudent."),
   array("non enim iis rebus pugnabamus, -quibus|C. moyen de ualere|abl.f.p.- ualere poteramus.",
         "Car nous ne combattions pas sur le terrain sur lequel nous pouvions être forts."),
   array("puer Acidini obuiam mihi uenit cum codicillis, "
        ."in -quibus|C de lieu de erat scriptum|abl.m.p- erat scriptum paullo "
        ."ante lucem Marcellum diem suum obisse.",
         "Un esclave d'Acidinus est venu à ma rencontre avec des tablettes sur lesquelles "
         ."on avait écrit que Marcellus s'était éteint un peu avant le lever du jour."),
   array("Itaque orbus iis rebus omnibus -quibus|COI de assuefecerat|dat.f.p.- et natura me et uoluntas"
        ." et consuetudo assuefecerat, cum ceteris, ut quidem uideor, tum mihi ipse displiceo.",
        "Ainsi, privé de toutes les choses auxquelles ma nature, ma volonté et mes usages m'avaient "
         ."accoutumé, je déplais, à ce qu'il me semble, non seulement aux autres, mais aussi à moi-même."),
//quae
   array("omnia, -quae|COD de uoles|acc.n.p.- uoles, obtinebis.",
         "Tu obtiendras tout ce que tu voudras."),
   array("Quod scribis de reconciliata gratia nostra, non intelligo, cur reconciliatam esse dicas, "
        ."-quae|sujet de imminuta est|nom.f.s.- numquam imminuta est.",
         "Quant à ce que tu écris sur notre bonne entente retrouvée, je ne comprends pas pourquoi "
         ."tu la dis retrouvée alors qu'elle n'a jamais été amoindrie."),
   array("sed ea, -quae|sujet de delata sunt|nom.n.p.- ad me delata sunt, malo te ex Pomponio, "
        ."cui non minus molesta fuerunt, quam ex meis litteris cognoscere.",
         "Mais je préfère que tu apprennes par une lettre de Pomponius ce qui m'a été rapporté, "
         ."qui n'en a pas moins été attristé, plutôt que par la mienne."),
   array("Faciam omnia sedulo, -quae|COD de sciam ou de uelle|acc.n.p.- te sciam uelle.",
         "Je ferai de mon mieux tout ce que je saurai que tu veux que je fasse."),
   array("nulla uideri miseria debeat, -quae|sujet de sentiatur|nom.f.s.- non sentiatur.",
         "Rien de ce qu'on ne sent pas ne doit être considéré comme une douleur."),
   array("Non minus nostra sunt, -quae|COD de complectimur|acc.n.p.- animo complectimur, "
        ."quam quae oculis intuemur.",
         "Ce qu'on embrasse par l'esprit n'est pas moins à nous que ce que nous considérons avec les yeux."),
   array("-quae|COD de facimus|acc.n.p.- enim facimus, ea prudentissimo cuique maxime probata esse uolumus.",
         "Car je veux que tout ce que je fais soit complètement approuvé par les plus sages."),
//quarum
   array("Tres uno die a te accepi epistulas : unam breuem, quam Flacco Volumnio"
        ."dederas; duas pleniores, -quarum|C. de l'adj alteram|gén.f.p.- alteram tabellarius "
        ."T. Vibii attulit, alteram ad me misit Lupus.",
         "J'ai reçu trois lettres de toi le même jour : une brève, que tu avais donnée à "
         ."Flaccus Volumnius ; deux plus longues, dont le courrier de Titus Vibius m'a apporté l'une, "
         ."et Lupus m'a envoyé l'autre."),
   array("habeo duas res, quibus me sustentem, optimarum artium scientiam et "
        ."maximarum rerum gloriam, -quarum|C. de l'adj altera|gén.f.p.- altera mihi uiuo numquam eripietur,"
        ."altera ne mortuo quidem.",
         "Il y a deux choses grâce auxquelles je tiens bon : ma connaissance des meilleurs vertus, et "
         ."la gloire des plus grandes choses. La première, moi vivant, ne me sera jamais enlevée, "
         ."la seconde non plus, même après ma mort.")
);
?>
