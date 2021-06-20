<?php

include_once 'i18n.inc.php';
header ('Location: index.'. $lang . '.html');

$just_test = T_("Sommaire");

// no closing tag at the end of the file to prevent errors.
