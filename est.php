<?php
// est + génitif de qualité
// est + ablatif de qualité
// est + datif
// habet + cod

include gd;
var_dump(gd_info());

$qualitates = array(
    "magna patientia,magnae patientiae,une grande patience",
    "summa auctoritate,summae auctoritatis,d'une très grande importance",
    "ualetudine prospera,ualetudinis prosperae,une bonne santé",
    "dissoluto animo,dissoluti animi,un courage défaillant"
);

$mancipiaF = array(
    "maritus,un mari",
    "pecten,un peigne"
);

$mancipiaM = array(
    "toga calda,une toge chaude"
);

$mancipia = array(
   "filia,une fille",
   "seruus,un esclave",
);

$attributiM = array(
    "magnus homo,un homme important",
);

$feminae = array(
    "Fadilla",
    "Seuera",
    "Supera",
    "Crispina",
    "Clara",
    "Longina",
    "Lucilla",
    "Drusilla",
    "Proba",
    "Faustina",
    "Paula",
    "Lepida",
    "Marcella"
);

$mares = array(
    "Appius",
    "Aulus",
    "Caius",
    "Cnaeus",
    "Decimus",
    "Lucius",
    "Mamercus",
    "Manius",
    "Marcus",
    "Numerius",
    "Publius",
    "Quintus",
    "Sextus",
    "Septimus",
    "Spurius"
);

function sorsColl($c) {
    if (count($c) == 1) return $c[0];
   return $c[mt_rand(0, count($c)-1)];   
}

?>
