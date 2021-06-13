<?php
$bini = array(
   // is
   array("-is|sujet de utitur|nom.m.s.- utitur consilio ne suorum quidem, sed suo.",
         "Il ne prend même pas l'avis de ses partisans, mais le sien propre."),
   array("ego enim -is|sujet de sum|nom.m.s.- sum qui nihil umquam mea potius quam meorum ciuium "
        ."causa fecerim;",
         "Je suis, moi, celui qui ne peux jamais en aucun cas plaider ma propre cause "
	 ."mieux que celle de mes concitoyens."),
   array("-is|sujet de factus est|nom.m.s.- dictator cum L. Papirio Cursore magistro equitum "
        ."factus est annis post Romam conditam CCCCXV.",
         "Il fut nommé dictateur avec Lucius Cursor comme maître de la cavalerie, "
	."en l'an 415 après la fondation de Rome."),
   array("-is|sujet de uocitatus est|nom.m.s.- Connus uocitatus est : num id obscenum putas?",
         "Il s'appelait Connus : penses-tu que ce soit obscène ?"),
   array("qui enim Antonium oppresserit, -is|sujet de confecerit|nom.m.s.- hoc bellum "
        ."taeterrimum periculosissimumque confecerit.",
         "Celui qui abattra Antoine mettra un terme à la guerre la plus affreuse et la plus dangereuse."),
   array("Ita, si id agitur, ut rursus in potestate omnia unius sint, quicumque "
        ."-is|sujet de est|nom.m.s.- est, ei me profiteor inimicum.",
         "Donc, s'il se produit que de nouveau tout soit au pouvoir d'un seul, quel qu'il soit, "
         ."je me déclare son ennemi personnel."),
   array("Atque haec omnia -is|sujet de feci|nom.m.s.- feci, qui sodalis et familiarissimus Dolabellae eram,",
         "Et tout cela, c'est moi qui l'ai fait, qui étais compagnon et meilleur ami de Dollabella."),
   // ea
   array("Quod extremum fuit in -ea|compl.prép. de fuit|abl.f.s.- epistula, quam a te proxime "
        ."accepi, ad id primum respondebo;",
         "Ce qui est à la fin de la lettre que je viens de recevoir de toi, j'y répondrai en premier."),
   array("Non modo tibi, cui nostra omnia notissima sunt, sed neminem in populo Romano arbitror esse, "
        ."cui sit ignota -ea|déterminant de familiaritas|nom.f.s.- familiaritas, quae mihi cum L. Lamia est;",
	 "Non seulement la familiarité qui me lie à Lucius Lamia ne t'est pas inconnue, mais encore "
	."je pense qu'elle ne l'est de personne parmi le peuple romain."),
   array("Peto a te in maiorem modum pro nostra necessitudine, ut tibi "
        ."-ea|déterminant de res|nom.f.s.- res curae sit",
         "Je te demande avec insistance, au nom de l'amitié qui nous lie, de t'occuper de cette affaire."),
   array("utinam -ea|déterminant de res|nom.f.s.- res ei uoluptati sit !",
         "Pourvu que cette chose lui fasse plaisir !"),
   array("De -ea|déterminant de re|abl.f.s.- re et de ceteris rebus quam primum uelim nobis litteras mittas.",
         "Au sujet de cette affaire et de toutes les autres, je voudrais que tu m'envoies une lettre "
	 ."le plus tôt possible."),
   array("-ea|déterminant de laus|nom.f.s.- est enim profecto iucunda laus, quae ab iis proficiscitur, "
        ."qui ipsi in laude uixerunt.",
         "C'est assurément une agréable louange, que celle qui vient de ceux qui ont eux-même vécu "
        ."dans la louange."),
   array("tua uoluntas -ea|attribut du sujet uoluntas|nom.f.s.- uidebatur esse, ut prorsus nisi "
        ."confirmato corpore nolles nauigare.",
         "Ta volonté semple être telle que tu ne veuilles pas naviguer plus avant si ton corps ne s'est "
         ."fortifié."),
   // id
   array("Medico mercedis quantum poscet promitti iubeto : -id|COD de scripsi|acc.n.s- scripsi ad Ummium.",
         "Fais promettre au médecin des honoraires pour le montant qu'il demandera : c'est ce que j'ai "
         ."écrit à Ummius."),
   array("-id|COD de facias|acc.n.s.- quum tua, tum mea causa facias, a te peto.",
         "Je te demande cela autant pour toi que pour moi."),
   array("nec -id|attribut du sujet id|nom.n.s.- mirum.","Et cela n'est pas étonnant."),
   array("Etsi iusta et idonea usus es excusatione intermissionis litterarum tuarum, tamen, " 
        ."-id|COD de facias|acc.n.s.- ne saepius facias, rogo;",
        "Même si tu m'as donné une excuse juste et pertinente pour l'interruption de tes lettres, je"
        ."te demande de ne pas faire cela plus souvent."),
   array("Senatus haberi ante Kalendas Februarias per legem Pupiam, "
        ."-id|apposé au groupe haberi... Pupiam|acc.n.s.- quod scis, non potest.",
         "Selon la loi Pupia, le Sénat ne peut, tu le sais, se réunir avant le premier février."),
   array("Si iniquus es in me iudex, condemnabo eodem ego te crimine; sin me "
        ."-id|COD de facere|acc.n.s.- facere noles, te mihi aequum praebere debebis.",
        "Si tu es envers moi un juge injuste, je te condamnerai pour le même grief ; mais si tu "
        ."ne veux pas que je le fasse, tu devras te montrer juste pour moi."),
   array("Haec ad te in praesentia scripsi ut sperares te adsequi -id|COD de adsequi|acc.n.s.- quod "
        ."optasses.",
         "Je t'écris cela actuellement pour que tu espères obtenir ce que tu as souhaité."),
   // eum
   array("M. Fabio, uiro optimo et homine doctissimo, familiarissime utor mirificeque "
        ."-eum|COD de diligo|acc.m.s.- diligo", 
        "Je suis des plus proches de Marcus Fabius, homme excellent, personnage très savant, et "
         ."j'ai pour lui un attachement extraordinaire."),
   array("Togam praetextam texi Oppio puto te audisse; nam Curtius noster dibaphum cogitat, sed "
         ."-eum|COD de moratur|acc.m.s- infector moratur.",
         "Je pense que tu as appris qu'on tissait une toge prétexte pour Oppius : notre Curtius songe"
        ."en effet à la pourpre, mais il est retardé par son teinturier."),
   array("Trebatio mandaui, ut, si quid tu -eum|sujet de mittere|acc.m.s.- uelles ad me mittere, "
        ."ne recusaret",
         "J'ai demandé à Trébatius de ne pas refuser si de ton côté tu voulais qu'il "
         ."m'envoie quelque chose."),
   array("Nos in nobilissimo orbis terrarum gymnasio Academiae locum delegimus ibique "
        ."-eum|COD de commussimus|acc.m.s.- combussimus",
         "J'ai choisi un emplacement dans le gymnase le plus célèbre du monde, celui de l'Académie, "
         ."et là j'ai procédé à sa crémation."),
   array("de te cum Furfanio ita loquar, ut tibi litteris meis ad -eum|compl.prép. de litteris|acc.m.s.- "
        ."nihil opus sit.",
         "Je parle de toi avec Furfanius d'une manière qui rende inutile que je t'envoie une lettre "
        ."de recommendation pour lui."),
   array("sed ad -eum|compl.prép. de scribere|acc.m.s.- propter eius luctum nihil sum ausus scribere.",
         "Mais je n'ai rien osé lui écrire à cause de son affliction."),
   array("sed mehercules extra iocum homo bellus est; uellem -eum|sujet de abduxisses|acc.m.s.- tecum "
        ."abduxisses.",
         "Mais parbleu, sans plaisanter, cet homme a de l'esprit. Je voudrais que l'eusses amené avec toi."),
   // eam
   array("Domum Sullanam desperabam iam, sed tamen non abieci: tu uelim, ut scribis, cum fabris "
        ."-eam|COD de perscipias|acc.f.s.- perspicias;",
        "Je désespérais déjà de la maison de Sylla, mais n'y ai quand même pas renoncé : je voudrais que "
        ."tu l'inspectes avec des professionnels."),
   array("Non moleste fero -eam|déterminant de necessitudinem|acc.f.s.- necessitudinem, quae mihi "
        ."tecum est, notam esse quam plurimis.",
         "Il ne m'est pas désagréable que l'amitié qui nous lie soit connue du plus grand nombre."),
   array("Pompeius in -eam|déterminant de prouinciam|acc.f.s.- prouinciam cum exercitu uenit.",
         "Pompée est venu dans cette province avec son armée."),
   array("Ego in Ciliciam proficisci cogito circiter K. Mai: ante -eam|déterminant de diem|acc.f.s.- "
        ."diem M. Anneius ad me redeat oportet.",
         "Moi, je pense partir pour la Cilicie vers le premier Mai : il faut que Marcus Anneius revienne "
         ."auprès de moi avant cette date."),
   array("sed mihi ita persuadeo (potest fieri, ut fallar), -eam|déterminant de rem|acc.f.s.- rem laudi "
        ."tibi potius quam uituperationi fore.",
         "Mais je suis persuadé (il se peut que je me trompe), que tu te féliciteras de cette chose "
         ."plutôt que tu ne la blâmeras."),
   array("Nauem spero nos ualde bonam habere; in -eam|Compl.prép. de conscendi|acc.f.s.- simul atque "
        ."conscendi, haec scripsi.",
        "J'espère que nous avons un excellent navire ; Je t'écris cela juste après y être embarqué."),
   // eius
   array("Post diem tertium -eius|déterminant de diei|gén.m.s.- diei, circiter hora decima noctis "
        ."P. Postumius ad me uenit.",
         "Trois jours après ce jour, vers la dixième heure de la nuit, Paulus Postumius est venu à moi."),
   array("Ego tamen ad tabernaculum -eius|CDN tabernaculum|gén.m.s.- perrexi.",
         "Je me suis tout de même rendu à sa tente."),
   array("etsi abest maturitas aetatis, tamen personare aures -eius|CDN aures|gén.m.s.- huiusmodi "
        ."uocibus non est inutile.",
         "Même si il est loin de l'âge mûr, il n'est pas inutile, cependant, que des paroles de ce genre "
         ."lui sonnent aux oreilles."),
   array("Cognouimus Cn. Carbonem et -eius|CDN fratrem|gén.m.s.- fratrem scurram : quid iis improbius ?",
         "Je connais Cnéius Carbo et son bouffon de frère : y a-t-il rien de plus malhonnête qu'eux ?"),
   array("Exemplar -eius|déterminant de chirographi|gén.m.s.- chirographi Titio misi.",
         "J'ai envoyé à Titius une copie de cette pièce."),
   array("legionesque duae de exercitu Antonii ad -eius|CDN auctoritatem|gén.m.s.- se auctoritatem "
        ."contulerunt",
         "Deux légions de l'armée d'Antoine se sont rangées sous son autorité."),
   array("in dies singulos -eius|CDN copiae|gén.m.s.- copiae minuuntur.",
         "De jour en jour ses troupes diminuent."),
   // ei (semble n'être employé que pour le datif singulier) 
   array("omnesque intelligunt nec dignitatem -ei|compl. deesse|dat.m.s.- deesse nec gratiam.",
         "et tous comprennent qu'il ne manque ni de mérite ni de charme."),
   array("-eum|COD de commendo|acc.m.s- tibi penitus commendo atque trado: ut omnibus in rebus ei commodes.",
         "Je te le recommande et te le confie entièrement, pour que tu l'obliges en toute chose."),
   array("utinam ea res -ei|Double datif|dat.s.- uoluptati sit !"
        ,"Pourvu que cette chose lui fasse plaisir !"),
   array("egi -ei|COS de egi|dat.m.s.- per litteras gratias.","Je l'ai remercié par lettre."),
   array("multo amicior -ei|Compl de l'adj. amicior|dat.m.s.- sum factus."
        ,"je suis devenu beaucoup plus ami avec lui."),
   array("-ei|COI de dixi|dat.m.s.- cupienti audire nostra dixi sine te omnia mea muta esse.",
         "Comme il était désireux d'entendre notre histoire, j'ai dit que sans toi la mienne était muette."),
   array("quod semper amicissimus Bibulo fui, dedi operam ut -ei|COI de scriberem|dat.m.s.- quam "
        ."humanissime scriberem.",
         "Comme j'ai toujours été très ami avec Bibulus, je me suis efforcé de lui écrire "
         ."le plus humainement possible."),
   // ii (nom. pl. seulement)
   array("Quod si essem ea perfidia, qua sunt -ii|sujet de sunt|nom.m.p.-, qui in nos haec conferunt, "
        ."tamen ea stultitia certe non fuissem.",
         "Si j'avais la perfidie de ceux qui nous accusent de cela, je n'en aurais certainement pas "
        ."la bêtise."),
   array("genus hoc consolationis miserum atque acerbum est, propterea quia, per quos ea confieri "
        ."debet propinquos ac familiares, -ii|sujet de afficiuntur|nom.m.p.- ipsi pari molestia "
        ."afficiuntur neque sine lacrimis multis id conari possunt.",
        "Ce genre de consolation est pauvre et pénible, parce que ceux par qui elle doit être "
        ."présentée, les proches et les intimes, sont eux-mêmes affligés d'une égale tristesse, "
        ."et ne peuvent la tenter sans force larmes."),
   array("ut enim grauius aegrotant -ii|sujet de aegrotant|nom.m.p.-, qui, quum leuati morbo "
        ."uiderentur, in eum de integro inciderunt, sic uehementius nos laboramus.",
        "Car de même que ceux qui se sont crus guéris et ont rechuté, sont plus gravements malades, "
        ."moi, de même, je souffre plus violemment."),
   // eo 
   array("uelim ut -eo|déterminant de animo|abl.m.s- sis animo, quo debes esse.",
         "Je voudrais que tu aies le moral que tu dois avoir."),
   array("nam in senatu Kal. Ianuariis sic cum -eo|compl.prép. de disputaui|abl.m.s- de re publica "
        ."disputaui, ut sentiret sibi cum uiro forti et constanti esse pugnandum;",
         "Car au Sénat le premier Janvier, j'ai disputé avec lui de politique de manière à ce qu'il "
        ."comprenne qu'il devrait combattre contre un homme courage et ferme."),
   array("si hoc uitium est, -eo|C. de carere|abl.m.s- me non carere confiteor.",
         "Si c'est un défaut, j'avoue ne pas en être exempt."),
   array("ita Caninio consule scito neminem prandisse; nihil tamen -eo|abl.abs.|abl.m.s- consule mali "
        ."factum est.",
         "Ainsi, sache que sous le consulat de Caninius personne ne déjeuna, mais que sous son consulat "
         ."aucune mauvaise action ne fut faite."),
   array("Antonius Id. Maiis ad Forum Iulii cum primis copiis uenit; Ventidius bidui spatio abest "
        ."ab -eo|compl. prép. de abest|abl.m.s-.",
         "Antoine est arrivé à Fréjus le 5 juin avec les premières troupes ; Ventidius est éloigné de lui "
         ."de deux jours de marche."),
   array("Quod de Planci et Bruti concordia scribis, in -eo|compl. prép. de pono|abl.m.s- uel "
        ."maximam spem pono uictoriae.",
         "À propos de ce que tu écris sur la bonne entente entre Plancus et Brutus : je place en "
         ."cela un très très grand espoir de victoire."),
   array("Nobis erat in animo Ciceronem ad Caesarem mittere et cum "
        ."-eo|compl. prép. de mittere|abl.m.s- Cn. Sallustium.",
         "J'avais l'intention d'envoyer Cicéron auprès de César, et avec lui Cnéius Sallustius."),
   // eae
   array("summum periculum sit, ne amittendae sint "
        ."omnes -eae|déterminant de prouinciae|nom.f.p.- prouinciae.",
         "Il y a très grand danger qu'il ne faille perdre ces provinces."),
   array("Sed, si, ut scribis, -eae|déterminant de litterae|nom.f.p.- litterae non fuerunt "
        ."disertae, scito meas non fuisse.",
         "Mais si, comme tu l'écris, cette lettre ne n'était pas d'un beau style, sache qu'elle "
         ."n'était pas de moi."),
   // eos 
   array("non tam grauiter -eos|COD de ferimus|acc.m.p.- casus ferimus, quos nullo consilio uitare possimus.",
         "Nous supportons moins difficilement les malheurs que nous ne pourrions absolument pas éviter."),
   array("commune nihil postest esse apud -eos|compl.prép. de esse|acc.m.p.-, qui omnia uoluptate "
        ."sua metiuntur ?",
         "Il ne peut rien y avoir en commun chez ceux qui mesurent tout suivant leur propre plaisir."),
   array("Cum audissem Antonium cum suis copiis in prouinciam meam uenire, cum exercitu meo ab "
        ."confluente castra moui ac contra -eos|compl.prép de uenire|acc.m.p.- uenire institui.",
         "Après avoir appris qu'Antoine arrivait dans ma province avec ses troupes, j'ai levé "
        ."le camp avec mon armée,  et, depuis le confluent j'ai entrepris de marcher contre eux."),
   array("ex eorum oratione intellexi gratiarum actione -eos|sujet de egere|acc.m.p.- magis egere "
        ."quam commendatione.",
         "À leur discours, j'ai compris qu'ils manquaient plus de remerciements que de recommandation."),
   array("Quod si -eos|COD de tractaris|acc.m.p.- honorifice liberaliterque tractaris, et tibi "
        ."gratissimos optimosque adolescentes adiunxeris et mihi gratissimum feceris.",
         "Si tu les traites avec honneur et générosité, tu t'adjoindras les jeunes gens les plus "
         ."reconnaissans et les plus précieux, et du même coup tu me sera très agréable."),
   array("Ego, ad quos scribam, nescio, nisi ad -eos|compl.prép de scribam|acc.m.p.-, qui ad me scribunt.",
         "Je ne sais, moi, à qui écrire, sinon à ceux qui m'écrivent."),
   // eas
   array("mihi Munatius -eas|déterminant de litteras|acc.f.p- litteras legendas dedit, quas ipsi miseras.",
         "Munatius m'a fait lire la lettre que tu lui avais envoyée en privé."),
   array("Recurri ad meas copiolas ; sic enim uere -eas|COD de appellare|acc.f.p- appellare possum:",
         "Je suis retourné en courant à mes mini-troupes : je puis vraiment les appeler ainsi."),
   // eorum 
   array("opportunum uidetur habere perfugium -eorum|CDN urbem|gén.m.p- urbem, quibus carus sis.",
         "Il paraît opportun d'avoir comme asile la ville de gens à qui tu sois cher."),
   array("L. et C. Aurelios L. filios, quibus, et ipsis et patre -eorum|CDN patre|gén.m.p.-, uiro "
        ."optimo, familiarissime utor, commendo tibi maiorem in modum",
         "Je te recomande chaudement Lucius et Cailus Auruleius, fils de Lucius, "
         ."avec qui j'ai, comme avec leur excellent père, des relations très amicales."),
   array("Hac a me sententia dicta magnus animorum motus est factus cum -eorum|CDN motus|gén.m.p.-, quorum "
        ."oportuit, tum illorum etiam, quorum numquam putaram",
         "Lorsque j'eus donné cet avis, il se fit une grand mouvement dans l'esprit non seulement "
         ."de ceux qui le devaient, mais encore de ceux dont je ne l'aurais jamais pensé."),
   array("Recordor enim desperationes -eorum|CDN desperationes|gén.m.p.- qui senes erant adulescente me.",
         "Je me rappelle en effet le désespoir de ceux qui étaient des vieillards lorsque j'étais "
         ."un jeune homme."),
   // earum
   array("Deinde ex litteris, quas Pansae misi, cognosces omnia; nam "
        ."tibi -earum|CDN exemplar|gén.f.p.- exemplar misi.",
         "Tu apprendras tout après, par la lettre que j'ai envoyée à Pansa : je t'en envoie une copie."),
   array("mihi enim iudicatum est  me totum in litteras abdere tecumque et cum "
        ."ceteris -earum|compl. de l'adj. studiosis|gén.f.p.- studiosis honestissimo otio perfrui.",
        "Car j'ai décidé de me retirer tout entier dans les belles-lettres, et, avec toi et tous leurs "
       ."autres passionnés, de jouir du plus honnête des loisirs."),

   // iis 
   array("itaque nullas -iis|COS de dedi|dat.m.p.- praeterquam ad te et ad Brutum dedi litteras.",
         "C'est pourquoi je ne leur ai donné aucune autre lettre que celles que j'ai écrites à Brutus"
         ."et à toi."),
   array("cum te tranquilliorem animo esse cognoro, de -iis|compl. prép de certiorem|abl.f.p.- rebus, "
        ."quae hic geruntur, quemadmodumque se prouincia habeat, certiorem faciam.",
         "Lorsque j'aurai connu que tu as l'âme plus tranquille, je te donnerai des précisions sur "
         ."les événements qui se déroulent ici, et dans quel état est la province."),
   array("Omnis amor tuus ex omnibus partibus se ostendit in -iis|déterminant de litteris|abl.f.p.- "
        ."litteris, quas a te proxime accepi.",
         "Toute ton affection se montre de toutes parts dans la lettre que je viens de recevoir de toi."),
   array("quod fecissent numquam, nisi -iis|double datif|dat.m.p.- dolori meus fuisset dolor.",
         "Ils n'auraient jamais fait cela, si ma douleur n'avait été une douleur pour eux."),
   array("Cum decimum iam diem grauiter ex intestinis laborarem "
        ."neque -iis|COS de probarem|dat.m.p.-, qui mea opera uti uolebant, "
        ."me probarem non ualere, quia febrim non haberem, fugi in Tusculanum.",
         "Comme je souffrais gravement des intestins depuis neuf jours et que, n'ayant pas de fièvre, ".
         "je ne parvenais pas à convaincre ceux qui voulaient m'employer que j'allais mal, "
        ."j'ai fui dans mon domaine de Tusculum."),
   array("Ex -iis|dét. de litteris|p.- litteris, quas Atticus a te missas mihi legit, quid "
        ."ageres et ubi esses, cognoui.",
         "J'ai appris par la lettre que tu as envoyée à Atticus, et qu'il ma lue, ce que tu faisais et "
         ."où tu étais."),
   array("ego eram in -iis|compl.prép. de eram|abl.n.p.- locis, in quibus maxime tuto me esse arbitrabar.",
         "J'étais quant à moi dans les lieux où je me croyais le plus en sûreté.")
);
?>
