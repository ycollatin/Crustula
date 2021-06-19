<?php

include_once 'i18n.inc.php';
header ('Location: index.'. $lang . '.html');

$just_test = _("Sommaire");

// no closing tag at the end of the file to prevent errors.
