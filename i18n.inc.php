<?php

// test a LANG environment variable eventually given to the browser
$wanted1 = getenv("LANG");

// test the browser's preferred language
$wanted2 = !empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) ?  $_SERVER['HTTP_ACCEPT_LANGUAGE']: false;

// test a GET parameter such as "lang"
$wanted3 = !empty($_GET["lang"]) ? $_GET["lang"]: false;

if ($wanted1) $lang = $wanted1;
if ($wanted2) $lang = $wanted2;
if ($wanted3) $lang = $wanted3;

switch (substr($lang, 0, 2)) {
case "en":
    $lang = "en_US.UTF-8"; // this locale must be enabled at system level
    break;
case "ru":
    $lang = "ru_RU.UTF-8"; // this locale must be enabled at system level
    break;
default:
    $lang = "fr_FR.UTF-8"; // this locale must be enabled at system level
    break;
}

$locale = setlocale(LC_MESSAGES, $lang); // this only works for enabled locales

bindtextdomain("crustula", "./lang/locale");
textdomain("crustula");

// no closing tag at the end of the file to prevent errors.
